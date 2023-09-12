<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\childrenRepository;
use App\Repositories\children_logsRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\child;
use App\Jobs\GetDetailchildFromSimma;
use MyFunctions;


class ChildrenSimmaController extends Controller{
    private $childrenRepository;
    private $children_logsRepository;
    private $getDataChildrenFromSimmaURL = "https://apimaster.wahanavisi.org/public/api/children-wab";
    private $postStatusToSimmaURL = "https://apimaster.wahanavisi.org/public/api/update-status-children";
    
    public function __construct(
        childrenRepository $childRepo, 
        children_logsRepository $logsRepo
    ){
        $this->childrenRepository = $childRepo;
        $this->children_logsRepository = $logsRepo;
    }

    // sync data from simma to local database
    public function sync_children_from_simma(Request $request){
        $page = $request->get('page', 1);
        if($page) {
            $url = $this->getDataChildrenFromSimmaURL."?page=".$page;
        }
        $response = $this->getchildFromSimma($url);
        $responseJSON = $response->json();
        $datas = $responseJSON['data'];
        foreach ($datas as $data) {
            $payload = [
                'partner_id' => $data["partner_id"],           
                // 'pledge_id' => $data["pledge_id"],
                'paid_thru' => $data["paid_thru"],
                'name' => $data["name"],
                'simma_id' => $data["id"],
                'idn' => $data["idn"],
                'status' => "0",
            ];
            $prevData = $this->childrenRepository->allquery()
                ->where('idn', $data['idn']);
            if ($prevData->count() > 0) {
                $payload['update_at'] = date('Y-m-d H:i:s');
                $prevData->update($payload);
            } else {
                $child = $this->childrenRepository->create($payload);
            }
        }
        return response()->json(['data'=>$responseJSON, 'status'=>'success']);
    }

    // post data from local database to website qontak
    public function post_children_to_qontak_web(Request $request){
        $pageSize = $request->get('page_size', 10);
        $response = MyFunctions::getQontakToken();
        $token = $response["access_token"];
        $children = $this->childrenRepository->allquery()
            ->limit($pageSize)
            ->orderBy('name', 'ASC')
            ->where('status', "0")->get();
        $key = date('Y-m-d H:i:s'); 
        foreach ($children as $child) {
            $payload = $this->buildPayloadQontak($child);
            $response = ['meta'=>['developer_message' => '']];
            // Update data ke Qontak untuk data yang pernah dikirim sebelumnya (METHOD: PUT)
            if (isset($child['qontak_id'])) {
                
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])->put('https://app.qontak.com/api/v3.1/deals/'.$child['qontak_id'], $payload);
                $response = $response->json();
            } 
            // Create data ke Qontak untuk data Baru (METHOD: POST)
            else {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer '.$token,
                ])->post('https://app.qontak.com/api/v3.1/deals', $payload);
                $response = $response->json();
            }
            // jika berhasil create new child
            if (isset($response['response']['id'])){
                $this->updateStatuschild($child, '1', 'succcess', $response['response']['id'], "");
                $this->createOrUpdateLog($key, $child, 'success');
                $this->updatechildrentatusToSimma(1, $child);
            } else if (isset($response['meta']['status']) == 200){
                $this->updateStatuschild($child, '1', 'succcess', null, "");
                $this->createOrUpdateLog($key, $child, 'success');
                $this->updatechildrentatusToSimma(1, $child);
            } 
            else {
                $errorMessage = $response['error'];
                $this->updateStatuschild($child, '2', 'failed', null, $errorMessage);
                $this->createOrUpdateLog($key, $child, 'failed');
                $this->updatechildrentatusToSimma(2, $child);
            }
            
        }

        return response()->json(['status'=>'process finish (see your logs)']);
    }

    // - - - - -  - - - - HELPER  - - -  - - - - - -  - -
    private function getchildFromSimma($url) {
        $response = Http::withHeaders([
            'Authorization' => $simmaToken = env('SIMMA_TOKEN'),
        ])->get($url);
        return $response;
    }

    private function buildPayloadQontak($child) {
        return [
            "name" => $child['idn'],
            "currency" => null,
            "size" => null,
            "closed_date" => null,
            "creator_id" => 121450,
            "creator_name" => "Trial",
            "crm_source_id" => 555131,
            "crm_source_name" => "Multichannel",
            "crm_lost_reason_id" => null,
            "crm_lost_reason_name" => null,
            "crm_pipeline_id" => 92468,
            "crm_pipeline_name" => "Pipeline PTD Anak",
            "crm_stage_id" => 557630,
            "crm_stage_name" => "Data PTD Anak",
            "start_date" => null,
            "expired_date" => null,
            "crm_priority_id" => null,
            "crm_priority_name" => null,
            "crm_company_id" => null,
            "crm_company_name" => null,
            "crm_lead_ids" => [],
            "crm_lead_name" => [],
            "product_association_ids" =>  [22],
            "product_association_name" =>  [22],
            "product_association_quantity" => [],
            "product_association_price" => [],
            "product_association_total_price" => [],
            "unique_deal_id" => null,
            "idempotency_key" => null,
            "channel_integration_room_id" => null,
            "additional_fields" => [
                [
                    "id" => 8478042,
                    "name" => "child_name",
                    "value" =>  $child['name'],
                    "value_name" => $child['name']
                ],
                [
                    "id" => 8478043,
                    "name" => "status_ptd",
                    "value" => $child['paid_thru'],
                    "value_name" => $child['paid_thru']
                ],
                [
                    "id" => 8478125,
                    "name" => "last_payment",
                    "value" => null,
                    "value_name" => null
                ],
                [
                    "id" => 8478126,
                    "name" => "upload_date",
                    "value" => date('d/m/Y'),
                    "value_name" => date('d/m/Y')
                ]
            ]
        ];
    }

    private function createOrUpdateLog($key, $child, $status) {
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
                    $logData['failed_list_id'] = $log['failed_list_id'].', '.$child["partner_id"];
                } else {
                    $logData['failed_list_id'] = $child["partner_id"];
                }
            } else {
                if ($log['list_id'] !== "") {
                    $logData['list_id'] = $log['list_id'].', '.$child["partner_id"];
                } else {
                    $logData['list_id'] = $child["partner_id"];
                }
            }
            $log->update($logData);
        } else {
            if ($status==='failed') {
                $logData['failed_list_id'] = $child["partner_id"];
            } else {
                $logData['list_id'] = $child["partner_id"];
            }
            $this->children_logsRepository->create($logData);
        }
    }

    private function updatechildrentatusToSimma($status, $child) {
        $payloadUpdate = [
            "id" =>  (int)$child["simma_id"],
            "status" =>  1
        ];
        $responseUpdate = Http::post($this->postStatusToSimmaURL, $payloadUpdate);
    }

    private function updateStatuschild($child, $statusNumber, $statusString,  $qontactId, $errorMessage) {
        $input = [
            'status' =>  $statusString,
            'udpate_date' => date('Y-m-d H:i:s')
        ];  
        if ($qontactId) {
            $input['qontak_id'] = $qontactId;
        }
        if ($errorMessage) {
            $input['message'] = $errorMessage;
        }
        $child->update($input);
    }
    
}

