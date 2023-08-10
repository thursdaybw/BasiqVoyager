<?php

namespace App\BasiqApi;

use App\BasiqApi\HttpClient\BasiqHttpClientFactory;

/**
 *
 */
class BasiqApi {
  private $httpClient;

  /**
   *
   */
  public function __construct(BasiqHttpClientFactory $httpClientFactory) {
    $this->httpClient = $httpClientFactory->createClient();
  }

  /**
   *
   */
  public function fetchUser(string $userId): \stdClass {
    return (object) $this->httpClient->request('GET', "/users/{$userId}");
  }

  /**
   *
   */
  public function fetchUserAccounts(string $userId): array {
    return $this->client->request('GET', "/users/{$userId}/accounts");
  }

  /**
   *
   */
  public function fetchUsersAccount(string $accountUrl): array {
    // Parse the URL to get the path and query parts.
    $parsedUrl = parse_url($accountUrl);
    $relativeUrl = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');

    return $this->httpClient->request('GET', $relativeUrl);
  }

  /**
   *
   */
  public function getBasiqUserConsents(string $userId): array {
    return $this->httpClient->request('GET', "/users/{$userId}/consents");
  }

}
