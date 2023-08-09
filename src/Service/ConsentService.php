<?php

namespace App\Service;

use App\BasiqApi\HttpClient\BasiqHttpClientFactory;

class ConsentService {
    
    private $httpClient;

    public function __construct(BasiqHttpClientFactory $httpClientFactory)
    {
        $this->httpClient = $httpClientFactory->createClient();
    }

    public function getBasiqUserConsents(string $userId): array {
        return $this->httpClient->request('GET', "/users/{$userId}/consents");
    }
}
