<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DemandaRequest;
use GuzzleHttp\Client;

class DemandaController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('API_CLIENTE_URL');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 60,
            'connect_timeout' => 30,
            'read_timeout' => 30,
            'allow_redirects' => true,
            'http_errors' => true,
            'verify' => false,
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ]
        ]);
    }

    public function index(Request $request)
    {
        $response = $this->client->get('', [
            'auth' => [env('API_CLIENTE_USER'), env('API_CLIENTE_PASSWORD')],
            'query' => [
                'auth' => [env('API_CLIENTE_USER'), env('API_CLIENTE_PASSWORD')],
                'TIPO' => $request->tipo,
                'INFO' => $request->info,
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json; charset=UTF-8'
                ]
            ],
        ]);

        return response()->json(json_decode($response->getBody()), $response->getStatusCode());
    }

    public function store(DemandaRequest $request)
    {
        $response = $this->client->post('', [
            'auth' => [env('API_CLIENTE_USER'), env('API_CLIENTE_PASSWORD')],
            'json' => $request->all(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=UTF-8'
            ]
        ]);

        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function update(DemandaRequest $request)
    {
        $response = $this->client->put('', [
            'auth' => [env('API_CLIENTE_USER'), env('API_CLIENTE_PASSWORD')],
            'json' => $request->all(),
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json; charset=UTF-8'
            ]
        ]);

        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function destroy(Request $request)
    {
        $response = $this->client->delete('', [
            'auth' => [env('API_CLIENTE_USER'), env('API_CLIENTE_PASSWORD')],
            'json' => $request->all(),
        ]);

        return response($response->getBody(), $response->getStatusCode())
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
