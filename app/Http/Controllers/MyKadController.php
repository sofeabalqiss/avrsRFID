<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class MyKadController extends Controller
{
    public function proxyReader()
    {
        try {
            $client = new Client();
            $response = $client->request('GET', 'http://127.0.0.1:2187/read_smartcard');
            return response()->json(json_decode($response->getBody()->getContents()));
        } catch (\Exception $e) {
            return response()->json([
                'ic_number' => ''.rand(800101, 991231).rand(1000,9999),
                'name_1' => 'Sample Visitor',
                'address_1' => 'NO 18A',
                'address_2' => 'KAMPUNG PULAU KERAMAT',
                'address_3' => 'MUKIM LESUNG',
                'city' => 'POKOK SENA',
                'state' => 'KEDAH',
                'post_code' => '06400'
            ]);
        }
    }
}
