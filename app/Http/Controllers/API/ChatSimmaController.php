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
use MyFunctions;


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

    public function sync_chat(Request $request){
        $pageSize = $request->get('page_size', 1);
        // GET Contacts list yang last update chat nya kurang dari hari ini
        $today = date('Y-m-d');
        $contacts = $this->contactRepository->allquery()
            ->where('last_update_chat', '<', $today)
            ->orWhereNull('last_update_chat')
            ->orderBy('name', 'ASC')
            ->orderBy('last_name', 'ASC')
            ->limit($pageSize)->get();
        
        $key = date('Y-m-d H:i:s');
        foreach ($contacts as $contact) {
            // GET CHAT
            $responseJSON = $this->getChatFromQontakWeb($contact);

            
            // CREATE CHAT TO DATABASE
            $responseFromSimma = [];
            if (isset($responseJSON['response'][0])) {
                $chatData = $responseJSON['response'][0];
                // POST CONTACT TO SIMMA
                $responseFromSimma = $this->postChatToSimma($contact, $chatData);
                // SAVE CHAT TO DATABASE
                // DISINI BISA DITAMBAHKAN JIKA ADA ERROR DARI SIMMA KE CHAT DATA, SEKARANG BELUM
                $this->createOrUpdateChat($contact, $chatData);
            } else {
                // do nothing, don't create chat object in database
                $this->createOrUpdateChat($contact, null);
            }

            // GAGAL / BERHASIL TETAP UPDATE CONTACT 'last_update_chat'
            $input = [
                'last_update_chat' => $today
            ];  
            $contact->update($input);

            // CHAT LOGS
            if (isset($responseFromSimma['id'])){
                $this->createOrUpdateLog($key, $contact, 'success');
            } else {
                $this->createOrUpdateLog($key, $contact, 'failed');
            }
        }
        return response()->json(['status'=>'process finish (see your logs)']);
    }


    // HELPER METHOD
    private function getChatFromQontakWeb($contact) {
        $responseToken = MyFunctions::getQontakToken();
        $token = $responseToken["access_token"];        
        $url = "https://app.qontak.com/api/v3.1/contacts/".$contact["qontact_id"]."/chat-history";
        $responsechat = Http::withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->get($url);
        return $responsechat->json();
    }

    private function createOrUpdateChat($contact, $chatData) {
        $chatDataToSave = [
            'partner_id'=>$contact["partner_id"],
            'update_date'=>date('Y-m-d'),
            'status'=>0,
            'message'=>"",
        ];
        if (!$chatData) {
            $chatDataToSave['room_id']="";
            $chatDataToSave['chat']="";
            $chatDataToSave['error_message']=$contact['name']." ".$contact['last_name']." doesn't has chat data";
        } else {
            $chatDataToSave['chat'] = $this->formatChatContents($chatData);
            $chatDataToSave['room_id'] = $chatData['room_id'];
        }
        return $this->wab_historyRepository->create($chatDataToSave);
    }

    private function postChatToSimma($contact, $chatData) {
        $payload = [
            "PartnerID" => $contact["partner_id"],
            "RoomID" => $chatData["room_id"],
            "TextHistory" => $this->formatChatContents($chatData),
        ];
        $responsePostChat = ['meta'=>['developer_message' => '']];
        $responsePostChat = Http::withHeaders([
            'Authorization' => 'Bearer '.env('SIMMA_TOKEN'),
        ])->post('https://apimaster.wahanavisi.org/public/api/history-wab', $payload);
        return $responsePostChat->json();
    }

    private function createOrUpdateLog($key, $contact, $status) {
        $log = $this->chatLogsRepository->allquery()->where('key', $key)->get();
        $logData = [
            'key' => $key,
            'date' => $key,
            'total' => 1,
        ];  
        if (isset($log[0])) {
            $log = $log[0];
            $logData['total'] = $log['total'] + 1;
            if ($status==='failed') {
                $logData['failed_list_id'] = $log['failed_list_id'].', '.$contact["partner_id"];
            } else {
                $logData['list_id'] = $log['list_id'].', '.$contact["partner_id"];
            }
            $log->update($logData);
        } else {
            if ($status==='failed') {
                $logData['failed_list_id'] = $contact["partner_id"];
            } else {
                $logData['list_id'] = $contact["partner_id"];
            }
            $this->chatLogsRepository->create($logData);
        }
    }


    private function formatChatContents($chat) {
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
