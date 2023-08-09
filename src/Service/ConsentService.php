<?php

namespace App\Service;

use App\BasiqApi\HttpClient\HttpClientInterface;

class ConsentService {
    private $client;

    public function __construct(HttpClientInterface $client) {
        $this->client = $client;
    }

    public function getBasiqUserConsents(string $userId): array {
        return $this->client->request('GET', "/users/{$userId}/consents");
    }
}
