<?php

namespace App\BasiqApi\HttpClient;

// Include the config file for API key and other configurations
require_once(__DIR__ . '/../../../config.php');

class BasiqHttpApplicationJwtAuthTokenFactory
{


    public function createClient(): GuzzleHttpClient
    {
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
