<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\contactRepository;
use Illuminate\Support\Facades\Http;
use App\Models\contact;
use App\Jobs\GetDetailContactFromSimma;


class QontactSimmaController extends Controller{
    private $contactRepository;
    public function __construct(contactRepository $contactRepo){
        $this->contactRepository = $contactRepo;
    }

    public function list_change_simma(Request $request){
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->get('simma.wahanavisi.org/laravel/public/v2/origin-wab');

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
                    'email_sponsor' => $data["email_sponsor"],
                    'IDN' => $data["IDN"],
                    'contact_email' => $data['email_sponsor'],
                    'status' => 'need_to_post',
                    'need_tp_post' => 'true',
                    'sponsor_id' => 'string',
                    'qontact_id' => 'string',
                ];
                if ($prevData->count() > 0)
                    $prevData->update($payload);
                else {
                    $contact = $this->contactRepository->create($payload);
                }
            }
        }
        return response()->json(['data'=>$response->json(), 'status'=>'success']);
    }

    public function list_change_simma_detail(Request $request){
        // get list chage save to database
        // can direct hit every data from changment and save detail tod atabase
        // 
        $datas = $this->contactRepository->allquery()
            ->orderBy('table_id', 'ASC')
            ->limit(20)
            ->where('status', 'need_to_sync_detail')->get();
        GetDetailContactFromSimma::dispatch($datas);
        // foreach ($datas as $data) {
        //     $data['table_name'];
        //     $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
        //     $response = Http::withHeaders([
        //         'Authorization' => $token,
        //     ])->post('simma.wahanavisi.org/laravel/public/v2/changes-wab', [
        //         "TableName"=> $data['table_name'],
        //         "TableID"=> $data['table_id']
        //     ]);
        //     $response = $response->json();
        //     $response = $response[0];
        //     $payload = array(
        //         "name"=>$response["first_name"].' '.$response["last_name"],
        //         // 'contact_email' => $response["Contact Email"],
        //         'phone_number' => $response["phone_number"],
        //         // 'status' => $response["Status"],
        //         'date_of_birth'  => $response["date_of_birth"],
        //         'source' => $response["source"],
        //         'sponsor_id' => $response["partner_id"],
        //         // 'name_see' => $response["Nama SEE"],
        //         'motivation_code' => $response["motivation_code"],
        //         'join_date' => $response["join_date"],
        //         // 'sp' => $response["SP"],
        //         'title' => $response["title"],
        //         'partner_id' => $response["partner_id"],
        //         // 'en' => $response["EN"],
        //         // 'pl' => $response["PL"],
        //         // 'dr' => $response["DR"],
        //         'email_sponsor' => $response["email_sponsor"],
        //         // 'need_tp_post' => 'true',
        //         'status' => 'need_to_post',
        //     );
        //     $data->update($payload);
        // }
        return response()->json([
            'message'=>'Process run in background, please wait the progress', 
            'status'=>'success'
        ]);
    }

    public function post_contact_to_qontact(Request $request){
        // get qontact token
        $response = Http::asForm()->post('https://app.qontak.com/oauth/token/', [
            "username"=> "trialwahanavisi@qontak.com",
            "password"=> "Password123!",
            "grant_type" => "password"
        ]);
        $response = $response->json();
        $token = $response["access_token"];
        // use token to post create contact to qontact  
        $contacts = $this->contactRepository->allquery()
            ->limit(1)
            ->orderBy('partner_id', 'ASC')
            ->where('status', 'need_to_post')->get();
        foreach ($contacts as $contact) {
            // post to qontact
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
                    // [
                    //     "id"=> 8478026,
                    //     "name"=> "title",
                    //     "value"=> $contact['title'],
                    //     "value_name"=> $contact['title']
                    // ],
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
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->post('https://app.qontak.com/api/v3.1/contacts/', $payload);
            $response = $response->json();
            $current_date = date('Y-m-d H:i:s');
            dd($response);
            if ($response['response']['id']){
                $input = [
                    'qontact_id' => $response['response']['id'], 
                    'status' =>  'posted_to_qontact',
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
            usleep(1000000);  // sleep avery 3 second
        }

        return response()->json(['data'=>$token, 'status'=>'success']);
    }
}
