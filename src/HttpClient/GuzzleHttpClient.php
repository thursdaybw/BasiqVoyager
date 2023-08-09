<?php

namespace App\HttpClient;

use GuzzleHttp\Client;

class GuzzleHttpClient implements HttpClientInterface {
    private $client;

    public function __construct(string $jwtToken) {
        $this->client = new Client([
            'base_uri' => 'https://au-api.basiq.io',
            'headers' => [
                'accept' => 'application/json',
                'authorization' => 'Bearer ' . $jwtToken,
                'basiq-version' => '3.0'
            ]
        ]);
    }

    public function request(string $method, string $url) {
        try {
            $response = $this->client->request($method, $url);
            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
