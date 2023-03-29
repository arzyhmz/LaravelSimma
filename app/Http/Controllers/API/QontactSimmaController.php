<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\contactRepository;
use Illuminate\Support\Facades\Http;
 


class QontactSimmaController extends Controller{
    private $contactRepository;
    public function __construct(contactRepository $contactRepo){
        $this->contactRepository = $contactRepo;
    }

    public function list_change_simma(Request $request){
        // get list chage save to database
        // save to database as to send
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('simma.wahanavisi.org/laravel/public/v2/origin-wab', [
            "TableName"=> "PartnerPhones",
            "TableID"=> "84100"
        ]);
        return $response;
        // return response()->json(['message'=>'Berhasil tambah data', 'status'=>'success']);
    }

    public function list_change_simma_detail(Request $request){
        // get list chage save to database
        // can direct hit every data from changment and save detail tod atabase
        $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('simma.wahanavisi.org/laravel/public/v2/changes-wab', [
            "TableName"=> "PartnerPhones",
            "TableID"=> "84100"
        ]);
        // return $response;

        $payload = array(
            "name"=>$response["First Name"],
            'contact_email' => $response["Contact Email"],
            'phone_number' => $response["Phone Number"],
            'status' => $response["Status"],
            'date_of_birth'  => $response["Date of Birth"],
            'source' => $response["Source"],
            'sponsor_id' => $response["Sponsor ID"],
            'name_see' => $response["Nama SEE"],
            'motivation_code' => $response["Motivation Code"],
            'join_date' => $response["Join Date"],
            'sp' => $response["SP"],
            'title' => $response["Title"],
            'en' => $response["EN"],
            'pl' => $response["PL"],
            'dr' => $response["DR"],
            'email_sponsor' => $response["Email Sponsor"],
            'need_tp_post' => 'true'
        );
        $contact = $this->contactRepository->create($payload);

        return response()->json(['message'=>'Berhasil tambah data', 'status'=>'success']);
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
        $contacts = $this->contactRepository->allquery()->where('need_tp_post', 'true')->get();
        foreach ($contacts as $contact) {
            // post to qontact
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token,
            ])->asForm()->post('https://app.qontak.com/api/v3.1/contacts/', [
                "first_name"=> $contact['name']
            ]);
            $response = $response->json();
            // udpate in database
            $input = ['need_tp_post' => 'false'];
            $contact->update($input);
            // usleep(1000000);  // sleep avery 3 second
        }

        return response()->json(['data'=>$token, 'status'=>'success']);
    }
}
