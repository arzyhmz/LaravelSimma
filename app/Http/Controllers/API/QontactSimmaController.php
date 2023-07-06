<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\contactRepository;
use App\Repositories\logsRepository;
use Illuminate\Support\Facades\Http;
use App\Models\contact;
use App\Jobs\GetDetailContactFromSimma;


class QontactSimmaController extends Controller{
    private $contactRepository;
    private $logsRepository;
    public function __construct(contactRepository $contactRepo, logsRepository $logsRepo){
        $this->contactRepository = $contactRepo;
        $this->logsRepository = $logsRepo;
    }
    private $simmaToken = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
    private function getFromSimma($url) {
        $response = Http::withHeaders([
            'Authorization' => $this->simmaToken,
        ])->get($url);
        return $response;
    }


    public function list_change_simma(Request $request){
        $page = $request->get('page', '');
        $url = "https://simma.wahanavisi.org/laravel/public/v2/origin-wab";
        if($page) {
            $url = $url."?page=".$page;
        }
        $response = $this->getFromSimma($url);
        $datas = $response->json();
        foreach ($datas as $data) {
            if (isset($data[0])) {
                $data = $data[0];
                $prevData = $this->contactRepository->allquery()
                    ->where('partner_id', $data['partner_id']);
                $payload = [
                    'partner_id' => $data["partner_id"],           
                    'name' => $data["Name"],
                    'phone_number' => $data["phone_number"],
                    'wa_number' => $data["wa_number"],
                    'wa_countrycode' => $data["wa_countrycode"],
                    'date_of_birth' => $data["date_of_birth"],
                    'source' => $data["source"],
                    'name_see' => $data["name_see"],
                    'motivation_code' => $data["motivation_code"],
                    'join_date' => $data["join_date"],
                    'title' => $data["title"],
                    'sp' => $data["state_sp"],
                    'en' => $data["state_en"],
                    'pl' => $data["state_pl"],
                    'dr' => $data["state_dr"],
                    'date_added' =>  date('Y-m-d H:i:s'),
                    'email_sponsor' => $data["email_sponsor"],
                    'IDN' => $data["IDN"],
                    'contact_email' => $data['email_sponsor'],
                    'status' => "0",
                    'need_tp_post' => 'true',
                    'sponsor_id' => 'string',
                    'qontact_id' => 'string',
                ];
                if ($prevData->count() > 0) {
                    $payload['update_at'] = date('Y-m-d H:i:s');
                    $prevData->update($payload);
                } else {
                    $contact = $this->contactRepository->create($payload);
                }
            }
        }
        return response()->json(['data'=>$response->json(), 'status'=>'success']);
    }

    public function post_contact_to_qontact(Request $request){
        $pageSize = $request->get('page_size', 10);
        $response = Http::asForm()->post('https://app.qontak.com/oauth/token/', [
            "username"=> "trialwahanavisi@qontak.com",
            "password"=> "Password123!",
            "grant_type" => "password"
        ]);
        $response = $response->json();
        $token = $response["access_token"];
        $contacts = $this->contactRepository->allquery()
            ->limit($pageSize)
            ->orderBy('partner_id', 'ASC')
            ->where('status', "0")->get();
        $key = time();
        foreach ($contacts as $contact) {
            $payload = [
                'sponsor_id' => $contact["partner_id"],
                "first_name"=> $contact['name'],
                "last_name"=> $contact['name'],
                "telephone"=> $contact['phone_number'].$contact['phone_number'],
                "date_of_birth"=> $contact['date_of_birth'],
                "source"=> $contact['source'],
                "additional_fields"=> [
                    [
                        "id"=> 8478028,
                        "name"=> "nama_see",
                        "value"=> $contact['nama_see'],
                        "value_name"=> $contact['nama_see']
                    ],
                    [
                        "id"=> 8478029,
                        "name"=> "motivation_code",
                        "value"=> $contact['motivation_code'],
                        "value_name"=> $contact['motivation_code']
                    ],
                    [
                        "id"=> 8478030,
                        "name"=> "join_date",
                        "value"=> $contact['join_date'],
                        "value_name"=> $contact['join_date']
                    ],
                    [
                        "id"=> 8478031,
                        "name"=> "sp",
                        "value"=> $contact['sp'],
                        "value_name"=> $contact['sp']
                    ],
                    [
                        "id"=> 8478032,
                        "name"=> "en",
                        "value"=> $contact['en'],
                        "value_name"=> $contact['en']
                    ],
                    [
                        "id"=> 8478033,
                        "name"=> "pl",
                        "value"=> $contact['pl'],
                        "value_name"=> $contact['pl']
                    ],
                    [
                        "id"=> 8478034,
                        "name"=> "dr",
                        "value"=> $contact['dr'],
                        "value_name"=> $contact['dr']
                    ],
                    [
                        "id"=> 8478025,
                        "name"=> "email_sponsor",
                        "value"=> $contact['email_sponsor'],
                        "value_name"=> $contact['email_sponsor']
                    ],
                    [
                        "id"=> 8478027,
                        "name"=> "sponsor_id",
                        "value"=> $contact['sponsor_id'],
                        "value_name"=> $contact['sponsor_id']
                    ],
                    [
                        "id"=> 8478035,
                        "name"=> "child_id",
                        "value"=> $contact['IDN'],
                        "value_name"=> $contact['IDN'],
                    ],
                    [
                        "id"=> 8478036,
                        "name"=> "child_name",
                        "value"=> null,
                        "value_name"=> null
                    ],
                    [
                        "id"=> 8478037,
                        "name"=> "program_non_sponsorship",
                        "value"=> null,
                        "value_name"=> null
                    ],
                    [
                        "id"=> 8478038,
                        "name"=> "summary_ptd",
                        "value"=> null,
                        "value_name"=> null
                    ],
                    [
                        "id"=> 8478039,
                        "name"=> "upload_date",
                        "value"=> date('Y-m-d H:i:s'),
                        "value_name"=> date('Y-m-d H:i:s')
                    ],
                    [
                        "id"=> 8478040,
                        "name"=> "ptd",
                        "value"=> null,
                        "value_name"=> null
                    ],
                    [
                        "id"=> 8478041,
                        "name"=> "jumlah_anak_sponsor",
                        "value"=> null,
                        "value_name"=> null
                    ]
                ],
                "unique_hub_account"=> null
            ];
            //   POST TO QONTACT
            //   HARUS DI PISAH JADI METHOD SENDIRI
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->post('https://app.qontak.com/api/v3.1/contacts/', $payload);
            $response = $response->json();
            $current_date = date('Y-m-d H:i:s');
            if ($response['response']['id']){
                $input = [
                    'qontact_id' => $response['response']['id'], 
                    'status' =>  "1",
                    'posted_status' => 'success',
                    'posted_to_qontact_date' => $current_date
                ];  
                $contact->update($input);
            } else {
                $input = [
                    'error_message' => $response,
                    'status' =>  'posted_to_qontact',
                    'posted_status' => 'failed',
                    'posted_to_qontact_date' => $current_date
                ];  
                $contact->update($input);
            }

            //   CREATE OR UPDATE LOGS
            //   HARUS DI PISAH JADI METHOD SENDIRI
            $log = $this->logsRepository->allquery()->where('key', $key)->get();
            $log_data = [
                'key' => $key, 
                'date' => date('Y-m-d H:i:s'),
                'total' => 1,
                'list_id' => $contact["partner_id"]
            ];  
            if (isset($log_data[0])) {
                $log_data = $log_data[0];
                $log_data['total'] = $log_data['total'] + 1;
                $log_data['list_id'] = $log_data['list_id'].', '.$contact["partner_id"];
                $log->update($log_data);
            } else {
                $this->logsRepository->create($log_data);
            }
            
            //   CHANGE STATUS to 1, if success send to contaq
            //   HARUS DI PISAH JADI METHOD SENDIRI
            //.  URL dipisah juga
            $payloadUpdate = [
                'id' =>  $contact["simma_id"]
            ]
            $response = Http::withHeaders([
                'Authorization' =>  $this->simmaToken,
            ])->post('https://apimaster.wahanavisi.org/public/api/update-status-wab', $payload);

            $response = Http::withHeaders([
                'Authorization' => $this->simmaToken,
            ])->get($url);

            usleep(1000000);  // sleep avery 3 second
        }

        return response()->json(['data'=>$token, 'status'=>'success']);
    }
}
