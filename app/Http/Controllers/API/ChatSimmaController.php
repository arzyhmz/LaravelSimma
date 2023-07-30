<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\contactRepository;
use App\Repositories\wab_historyRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\contact;
use App\Jobs\GetDetailContactFromSimma;
use App\Repositories\chat_logsRepository;


class ChatSimmaController extends Controller{
    private $contactRepository;
    private $wab_historyRepository;
    private $chatLogsRepository;
    
    public function __construct(
            contactRepository $contactRepo, 
            chat_logsRepository $chatLogsRepo,
            wab_historyRepository $wab_historyRepo
    ){
        $this->contactRepository = $contactRepo;
        $this->wab_historyRepository = $wab_historyRepo;
        $this->chatLogsRepository = $chatLogsRepo;
    }

    private $simmaToken = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";

    public function sync_chat(Request $request){
        $pageSize = $request->get('page_size', 2);
        $responseToken = Http::asForm()->post('https://app.qontak.com/oauth/token/', [
            "username"=> "trialwahanavisi@qontak.com",
            "password"=> "Password123!",
            "grant_type" => "password"
        ]);
        $responseToken = $responseToken->json();
        $token = $responseToken["access_token"];
        
        // 1. Looping Contaq Jika last update chat kurang dari hari ini
        $today = date('Y-m-d');
        $contacts = $this->contactRepository->allquery()
            ->where('last_update_chat', '<', $today)
            ->orWhereNull('last_update_chat')
            ->limit($pageSize)
            ->orderBy('name', 'ASC')->get();
        
        // dd("1", $contacts);
        $key = date('Y-m-d H:i:s');
        $loop = 1;
        foreach ($contacts as $contact) {
            // 2. Get chat from SIMMA utk qontact tersebut
            // url prod
            // $url = "https://app.qontak.com/api/v3.1/contacts/".$contact["partner_id"]."/chat-history";
            if ($loop % 2 === 0) {
                $url = "https://app.qontak.com/api/v3.1/contacts/41234486/chat-history";
            } else {
                $url = "https://app.qontak.com/api/v3.1/contacts/41049338/chat-history";
            }
            // $url = "https://app.qontak.com/api/v3.1/contacts/41049338/chat-history";
            $responsechat = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->get($url);
            $responseJSON = $responsechat->json();
            $responsePostChat = [];
            if (!isset( $responseJSON['response'][0])) {
                // dd("2", $responseJSON);
                $chatDataToSave = [
                    'partner_id'=>$contact["partner_id"],
                    'room_id'=>"no chat",
                    'update_date'=>$today,
                    'chat'=>"no chat",
                    'status'=>0,
                    'message'=>"This user doesn't has chat to backup",
                ];
                $chatDataObj = $this->wab_historyRepository->create($chatDataToSave);
            } else {
                // create chat to database
                $chatData = $responseJSON['response'][0];
                $chatDataToSave = [
                    'partner_id'=>$contact["partner_id"],
                    'room_id'=>$chatData['room_id'],
                    'update_date'=>$today,
                    'chat'=>$this->formatChatContents($chatData),
                    'status'=>0,
                    'message'=>"",
                ];
                $chatDataObj = $this->wab_historyRepository->create($chatDataToSave);

                // 2 Post Chat to Simma
                $payload = [
                    "PartnerID" => $contact["partner_id"],
                    "RoomID" => $chatData["room_id"],
                    "TextHistory" => $this->formatChatContents($chatData),
                ];
                $responsePostChat = ['meta'=>['developer_message' => '']];
                $responsePostChat = Http::withHeaders([
                    'Authorization' => 'Bearer '.$this->simmaToken,
                ])->post('https://apimaster.wahanavisi.org/public/api/history-wab', $payload);
                $responsePostChat = $responsePostChat->json();
            }

            // dd("3", $chatData['id']);
            //jika berhasil
            if (isset($responsePostChat['id'])){
                $input = [
                    'last_update_chat' => $today
                ];  
                $contact->update($input);
                $log = $this->chatLogsRepository->allquery()->where('key', $key)->get();
                $logData = [
                    'key' => $key,
                    'date' => $today,
                    'total' => 1,
                    'list_id' => $contact["partner_id"],
                ];  
                if (isset($log[0])) {
                    $log = $log[0];
                    $logData['total'] = $log['total'] + 1;
                    $logData['list_id'] = $log['list_id'].', '.$contact["partner_id"];
                    $log->update($logData);
                } else {
                    $this->chatLogsRepository->create($logData);
                }
                // change status di contaq jiak berhasil
            } else {
                // tidak perlu update last chat
                $input = [
                    'last_update_chat' => $key
                ];  
                $contact->update($input);

                $log = $this->chatLogsRepository->allquery()->where('key', $key)->get();
                $logData = [
                    'key' => $key,
                    'date' => $key,
                    'total' => 1,
                    'failed_list_id' => $contact["partner_id"]
                ];  
                if (isset($log[0])) {
                    $log = $log[0];
                    $logData['total'] = $log['total'] + 1;
                    $logData['failed_list_id'] = $log['failed_list_id'].', '.$contact["partner_id"];
                    $log->update($logData);
                } else {
                    $this->chatLogsRepository->create($logData);
                }
            }
            if ($loop == 2) {
                dd("Dibatasi 2 looping saja, 1 berhasil satu gagal");
            }
            $loop += 1;
        }
        // return response()->json(['status'=>'process finish (see your logs)']);
    }
    function formatChatContents($chat) {
        // $data = json_decode($json, true);
        $formattedChatArray = array_map(function($chat) {
            return '<b>' . $chat['user'] . '</b>' .
                   '<br/>' . $chat['timestamp'] .
                   '<br>' . $chat['message'] .
                   '<br/>' . '<br/>';
        }, $chat['chat_contents']);
    
        return implode('', $formattedChatArray);
    }
    
    
}
