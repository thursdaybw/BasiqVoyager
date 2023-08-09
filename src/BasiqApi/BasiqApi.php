<?php

namespace App\BasiqApi;

use App\BasiqApi\HttpClient\BasiqHttpClientFactory;

class BasiqApi {
    private $httpClient;

    public function __construct(BasiqHttpClientFactory $httpClientFactory)
    {
        $this->httpClient = $httpClientFactory->createClient();
    }

    public function fetchUser(string $userId): \stdClass {
        return (object) $this->httpClient->request('GET', "/users/{$userId}");
    }

    public function fetchUserAccounts(string $userId): array {
        return $this->client->request('GET', "/users/{$userId}/accounts");
    }

    public function fetchUsersAccount(string $accountUrl): array {
        // Remove the base URL from the account URL
        $relativeUrl = str_replace('https://au-api.basiq.io', '', $accountUrl);
        return $this->httpClient->request('GET', $relativeUrl);
    }

}
