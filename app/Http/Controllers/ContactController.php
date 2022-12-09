<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\ConnectionException;

class ContactController extends Controller
{
    public function store()
    {

        $token = 'Zoho-oauthtoken ' .  env("APP_TOKEN");

        $headers = [
            'Authorization' => $token
        ];

        $json = json_decode(Storage::disk('local')->get('contact.json'));

        $response = Http::withHeaders($headers)->post('https://www.zohoapis.eu/crm/v3/Contacts', $json);

        if($response->failed()){
            abort(403, 'Error happend!');
        } elseif ($response->clientError()) {
            abort(400, 'Client Error');
        } elseif ($response->successful()) {
            $jsonData = $response->json();
        }

        return view('contact', compact('response'));
    }
}
