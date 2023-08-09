<?php

namespace App\Api;

use App\HttpClient\HttpClientInterface;

class BasiqApi {
    private $client;

    private $tokenHandler;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
        $this->tokenHandler = new TokenHandler();
    }

    public function getToken(): string {
        return $this->tokenHandler->getToken();
    }

    public function fetchUser(string $userId): \stdClass {
        return (object) $this->client->request('GET', "/users/{$userId}");
    }

    public function fetchUserAccounts(string $userId): array {
        return $this->client->request('GET', "/users/{$userId}/accounts");
    }

    public function fetchUsersAccount(string $accountUrl): array {
        // Remove the base URL from the account URL
        $relativeUrl = str_replace('https://au-api.basiq.io', '', $accountUrl);
        return $this->client->request('GET', $relativeUrl);
    }

}
