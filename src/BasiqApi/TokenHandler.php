<?php

namespace App\BasiqApi;

use App\BasiqApi\HttpClient\BasiqHttpApplicationJwtAuthTokenFactory;

class TokenHandler
{
    private $tokenFile = 'token.json';
    private $tokenData = [];

    public function getToken()
    {
        $this->tokenData = $this->readTokenDataFromFile();

        if (empty($this->tokenData) || $this->isTokenExpired()) {
            $this->fetchNewToken();
        }

        return $this->tokenData['access_token'];
    }

    private function isTokenExpired()
    {
        $expires_at = $this->tokenData['expires_at'];
        if ($expires_at <= time()) {
            return false;
        } else {
            return true;
        }
    }

    private function fetchNewToken()
    {
        $clientFactory = new BasiqHttpApplicationJwtAuthTokenFactory();
        $client = $clientFactory->createClient($clientFactory);

        try {
            $form_params = [
               'scope' => 'SERVER_ACCESS', // Use SERVER_ACCESS for full access
            ];


            $data = $client->post("/token", $form_params);
            $statusCode = $client->getStatusCode();

            if ($statusCode === 200) {
                $this->saveTokenDataToFile($data);
            } else {
                // Handle other status codes as needed
                // You may log the error or throw an exception
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $e = $e;
            // Handle exceptions related to the request
            // You may log the error or throw an exception
        }
    }

    private function readTokenDataFromFile()
    {
        $tokenFilePath = __DIR__ . '/../../token.json';

        if (file_exists($tokenFilePath)) {
            $jsonContent = file_get_contents($tokenFilePath);
            $tokenData = json_decode($jsonContent, true); // Decode the JSON as an associative array
        } else {
            $tokenData = [];
        }

        return $tokenData;
    }

    private function saveTokenDataToFile($data)
    {
        $this->tokenData = $data;
        $tokenFilePath = __DIR__ . '/../../token.json';

        // Calculate the expiration time
        $data['expires_at'] = time() + $data['expires_in'];

        // Remove the 'expires_in' field as it's no longer needed
        unset($data['expires_in']);

        // Convert the data to JSON format
        $jsonData = json_encode($data);

        // Check if the file exists or needs to be created, then write the JSON data
        if (file_put_contents($tokenFilePath, $jsonData) === false) {
            // Handle the error if the file could not be written
            throw new Exception('Failed to write to ' . $tokenFilePath);
        }

        return $jsonData;
    }
}
