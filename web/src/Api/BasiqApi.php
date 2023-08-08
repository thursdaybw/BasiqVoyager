<?php

namespace App\Api;

use App\HttpClient\HttpClientInterface;

class BasiqApi {
    private $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function fetchUser(string $userId): array {
        return $this->client->request('GET', "/users/{$userId}");
    }

    public function fetchUserAccounts(string $userId): array {
        return $this->client->request('GET', "/users/{$userId}/accounts");
    }

    public function fetchUserAccount(string $accountUrl): array {
        // Remove the base URL from the account URL
        $relativeUrl = str_replace('https://au-api.basiq.io', '', $accountUrl);
        return $this->client->request('GET', $relativeUrl);
    }

}
