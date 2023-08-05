<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Http;

class MyFunctions {

    public static function getQontakToken()
    {
        $response = Http::asForm()->post('https://app.qontak.com/oauth/token/', [
            "username"=> "trialwahanavisi@qontak.com",
            "password"=> "Password123!",
            "grant_type" => "password"
        ]);
        return $response->json();
    }
}

?>


