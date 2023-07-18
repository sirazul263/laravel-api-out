<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TokenController extends Controller
{
    public function createToken (){
        $url = env('API_URL',null);
        //Headers
        $headers= [
            'Accept' => 'application/json' ,
            'Content-Type'=>'application/json'
        ];
        //Req Body
        $reqBody = [
            "client_id" => env('CLIENT_ID',null),
            "client_secret" => env('CLIENT_SECRET',null)
        ];
        $response = Http::withHeaders($headers)->post($url."/v1/create-token", $reqBody);
        return response()->json($response->json(), $response->status());
    }
}
