<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DealController extends Controller
{

    public function store()
    {

        $token = 'Zoho-oauthtoken ' .  env("APP_TOKEN");

        $headers = [
            'Authorization' => $token
        ];

        $json = json_decode(Storage::disk('local')->get('deal.json'));

        $response = Http::withHeaders($headers)->post('https://www.zohoapis.eu/crm/v3/Deals', $json);


        if($response->failed()){
            abort(403, 'Error happend!');
        } elseif ($response->clientError()) {
            abort(400, 'Client Error');
        } elseif ($response->successful()) {
            $jsonData = $response->json();
        }

        return view('deal', compact('response'));
    }

}