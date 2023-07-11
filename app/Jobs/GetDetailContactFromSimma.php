<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

// Deprecated, Tidak Jadi digunakan
class GetDetailContactFromSimma implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $datas;

    public function __construct($datas)
    {
        $this->datas = $datas;
    }

    public function handle(){
        $i = 0;
        foreach ($this->datas as $data) {
            $data['table_name'];
            $token = "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMyNjUsImlzcyI6Imh0dHBzOlwvXC9leHBsdXNtb2JpbGUud29ybGR2aXNpb24ub3JnLnBoXC9leHBsdXMtbW9iaWxlXC9kZXZlbG9wZXJcL2xhcmF2ZWwtYmFja2VuZFwvcHVibGljXC9hcGlcL2F1dGhlbnRpY2F0ZSIsImlhdCI6MTUyNjUzMzkzNywiZXhwIjoxNTI2NTM3NTM3LCJuYmYiOjE1MjY1MzM5MzcsImp0aSI6IjMyNzE0ZmExYjk4OWFjMGFkMTdhYjkyZGQ4NDY3MmRjIn0.rJP7aBrteIFrtwzXBsBIu2jyhLQFkdPmOb8cDc9hEVM";
            $response = Http::withHeaders([
                'Authorization' => $token,
            ])->post('simma.wahanavisi.org/laravel/public/v2/changes-wab', [
                "TableName"=> $data['table_name'],
                "TableID"=> $data['table_id']
            ]);
            $response = $response->json();
            if ($response) {
                $response = $response[0];
                $payload = array(
                    "name"=> $response["first_name"].' '.$response["last_name"],
                    // 'contact_email' => $response["Contact Email"],
                    'phone_number' => $response["phone_number"],
                    // 'status' => $response["Status"],
                    'date_of_birth'  => $response["date_of_birth"],
                    'source' => $response["source"],
                    'sponsor_id' => $response["partner_id"],
                    // 'name_see' => $response["Nama SEE"],
                    'motivation_code' => $response["motivation_code"],
                    'join_date' => $response["join_date"],
                    // 'sp' => $response["SP"],
                    'title' => $response["title"],
                    'partner_id' => $response["partner_id"],
                    // 'en' => $response["EN"],
                    // 'pl' => $response["PL"],
                    // 'dr' => $response["DR"],
                    'email_sponsor' => $response["email_sponsor"],
                    // 'need_tp_post' => 'true',
                    'status' => 'need_to_post',
                );
                $data->update($payload);
            }
            $i++;
            // if ($i % 5 == 0) {
            //     sleep(10);
            // }
        }
    }
}
