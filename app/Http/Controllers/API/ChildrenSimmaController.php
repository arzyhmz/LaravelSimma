<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\childrenRepository;
use App\Repositories\children_logsRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\contact;
use App\Jobs\GetDetailContactFromSimma;
use MyFunctions;


class ChildrenSimmaController extends Controller{
    private $childrenRepository;
    private $children_logsRepository;
    private $getDataChildrenFromSimmaURL = "https://apimaster.wahanavisi.org/public/api/children-wab";
    private $postStatusToSimmaURL = "https://apimaster.wahanavisi.org/public/api/update-status-wab";
    
    public function __construct(
        childrenRepository $contactRepo, 
        children_logsRepository $logsRepo
    ){
        $this->childrenRepository = $contactRepo;
        $this->children_logsRepository = $logsRepo;
    }

    // sync data from simma to local database
    public function sync_children_from_simma(Request $request){
        $page = $request->get('page', 1);
        if($page) {
            $url = $this->getDataChildrenFromSimmaURL."?page=".$page;
        }
        $response = $this->getContactFromSimma($url);
        $responseJSON = $response->json();
        $datas = $responseJSON['data'];
        foreach ($datas as $data) {
            $payload = [
                'partner_id' => $data["partner_id"],           
                'pledge_id' => $data["pledge_id"],
                'paid_thru' => $data["paid_thru"],
                'name' => $data["name"],
                'idn' => $data["idn"],
                'status' => "0",
            ];
            $prevData = $this->childrenRepository->allquery()
                ->where('simma_id', $data['id']);
            if ($prevData->count() > 0) {
                $payload['update_at'] = date('Y-m-d H:i:s');
                $prevData->update($payload);
            } else {
                $contact = $this->childrenRepository->create($payload);
            }
        }
        return response()->json(['data'=>$responseJSON, 'status'=>'success']);
    }

    // post data from local database to website qontak
    // public function post_contact_to_qontak_web(Request $request){
    //     $pageSize = $request->get('page_size', 10);
    //     $response = MyFunctions::getQontakToken();
    //     $token = $response["access_token"];
    //     $contacts = $this->childrenRepository->allquery()
    //         ->limit($pageSize)
    //         ->orderBy('name', 'ASC')
    //         ->orderBy('last_name', 'ASC')
    //         ->where('status', "0")->get();
    //     $key = date('Y-m-d H:i:s'); 
    //     foreach ($contacts as $contact) {
    //         $payload = $this->buildPayloadQontak($contact);
    //         $response = ['meta'=>['developer_message' => '']];
    //         // Update data ke Qontak untuk data yang pernah dikirim sebelumnya (METHOD: PUT)
    //         if (isset($contact['qontact_id'])) {
    //             $response = Http::withHeaders([
    //                 'Authorization' => 'Bearer '.$token,
    //             ])->put('https://app.qontak.com/api/v3.1/contacts/'.$contact['qontact_id'], $payload);
    //             $response = $response->json();
    //         } 
    //         // Create data ke Qontak untuk data Baru (METHOD: POST)
    //         else {
    //             $response = Http::withHeaders([
    //                 'Authorization' => 'Bearer '.$token,
    //             ])->post('https://app.qontak.com/api/v3.1/contacts/', $payload);
    //             $response = $response->json();
    //         }
    //         // jika berhasil create new contact
    //         if (isset($response['response']['id'])){
    //             $this->updateStatusContact($contact, '1', 'succcess', $response['response']['id'], "");
    //             $this->createOrUpdateLog($key, $contact, 'success');
    //             $this->updateContactStatusToSimma(1, $contact);
    //         } 
    //         // jika response dari contact adalah update bukan create
    //         else if ($response['meta']['developer_message'] === 'Success') {
    //             // update setelah update
    //             $this->updateStatusContact($contact, '1', 'succcess', null, "");
    //             $this->createOrUpdateLog($key, $contact, 'success');
    //             $this->updateContactStatusToSimma(1, $contact);
    //         } 
    //         // Jika error post ke qontak (misal duplicate email atau sebagainya)
    //         else {
    //             $errorMessage = $response['meta']['developer_message'].' - '.$response['meta']['message'];
    //             $this->updateStatusContact($contact, '2', 'failed', null, $errorMessage);
    //             $this->createOrUpdateLog($key, $contact, 'failed');
    //             $this->updateContactStatusToSimma(2, $contact);
    //         }
            
    //     }

    //     return response()->json(['status'=>'process finish (see your logs)']);
    // }

    // - - - - -  - - - - HELPER  - - -  - - - - - -  - -
    private function getContactFromSimma($url) {
        $response = Http::withHeaders([
            'Authorization' => $simmaToken = env('SIMMA_TOKEN'),
        ])->get($url);
        return $response;
    }

    private function buildPayloadQontak($contact) {
        return [
            'sponsor_id' => $contact["partner_id"],
            "first_name"=> $contact['name'],
            "last_name"=> $contact['last_name'],
            "email"=> $contact['email_sponsor'],
            "telephone"=> $contact['wa_countrycode'].$contact['wa_number'],
            "date_of_birth"=> $contact['date_of_birth'],
            "source"=> $contact['source'],
            "additional_fields"=> [
                // [
                //     "id"=> 8478028,
                //     "name"=> "name_see",
                //     "value"=> $contact['name_see'],
                //     "value_name"=> $contact['name_see']
                // ],
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
    }

    private function createOrUpdateLog($key, $contact, $status) {
        $log = $this->children_logsRepository->allquery()->where('key', $key)->get();
        $logData = [
            'key' => $key,
            'date' => $key,
            'total' => 1,
        ];  
        if (isset($log[0])) {
            $log = $log[0];
            $logData['total'] = $log['total'] + 1;
            if ($status==='failed') {
                if ($log['failed_list_id'] !== "") {
                    $logData['failed_list_id'] = $log['failed_list_id'].', '.$contact["partner_id"];
                } else {
                    $logData['failed_list_id'] = $contact["partner_id"];
                }
            } else {
                if ($log['list_id'] !== "") {
                    $logData['list_id'] = $log['list_id'].', '.$contact["partner_id"];
                } else {
                    $logData['list_id'] = $contact["partner_id"];
                }
            }
            $log->update($logData);
        } else {
            if ($status==='failed') {
                $logData['failed_list_id'] = $contact["partner_id"];
            } else {
                $logData['list_id'] = $contact["partner_id"];
            }
            $this->children_logsRepository->create($logData);
        }
    }

    private function updateContactStatusToSimma($status, $contact) {
        $payloadUpdate = [
            "id" =>  (int)$contact["simma_id"],
            "status" =>  1
        ];
        $responseUpdate = Http::post($this->postStatusToSimmaURL, $payloadUpdate);
    }

    private function updateStatusContact($contact, $statusNumber, $statusString,  $qontactId, $errorMessage) {
        $input = [
            'status' =>  $statusNumber,
            'posted_status' =>  $statusString,
            'posted_to_qontact_date' => date('Y-m-d H:i:s')
        ];  
        if ($qontactId) {
            $input['qontact_id'] = $qontactId;
        }
        if ($errorMessage) {
            $input['error_message'] = $errorMessage;
        }
        $contact->update($input);
    }
    
}

