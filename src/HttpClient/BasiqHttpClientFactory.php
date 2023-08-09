<?php

namespace App\HttpClient;

use App\Api\TokenHandler;

class BasiqHttpClientFactory {
    private $tokenHandler;

    public function __construct(TokenHandler $tokenHandler) {
        $this->tokenHandler = $tokenHandler;
    }

    public function createClient(): GuzzleHttpClient {
        $baseUri = 'https://au-api.basiq.io';
        $jwtToken = $this->tokenHandler->getToken();
        $headers = [
            'accept' => 'application/json',
            'authorization' => "Bearer $jwtToken",
            'basiq-version' => '3.0'
        ];

        return new GuzzleHttpClient($baseUri, $headers);
    }
}
