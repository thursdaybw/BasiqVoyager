<?php

namespace App\HttpClient;

use App\Api\TokenHandler;

class BasiqHttpApplicationJwtAuthTokenFactory {

    public function createClient(): GuzzleHttpClient {
        $baseUri = 'https://au-api.basiq.io';
        $headers = [
            'accept' => 'application/json',
            'authorization' => 'Basic ' . BASIQ_API_KEY,
            'basiq-version' => '3.0',
            'content-type' => 'application/x-www-form-urlencoded',
        ];

        return new GuzzleHttpClient($baseUri, $headers);
    }
}
