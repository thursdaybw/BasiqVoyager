<?php

namespace App\BasiqApi;

use App\BasiqApi\HttpClient\BasiqHttpClientFactory;

/**
 * Class BasiqApi.
 *
 * This class provides methods to interact with the Basiq API, allowing
 * fetching of user data, accounts, and consents.
 */
class BasiqApi {
  private $httpClient;

  /**
   * BasiqApi constructor.
   *
   * @param \App\BasiqApi\HttpClient\BasiqHttpClientFactory $httpClientFactory
   *   Factory to create the HTTP client for Basiq API requests.
   */
  public function __construct(BasiqHttpClientFactory $httpClientFactory) {
    $this->httpClient = $httpClientFactory->createClient();
  }

  /**
   * Fetches user information from the Basiq API.
   *
   * @param string $userId
   *   The ID of the user to fetch.
   *
   * @return \stdClass The user object containing user details.
   */
  public function fetchUser(string $userId): \stdClass {
    return (object) $this->httpClient->request('GET', "/users/{$userId}");
  }

  /**
   * Fetches accounts associated with a specific user from the Basiq API.
   *
   * @param string $userId
   *   The ID of the user whose accounts are to be fetched.
   *
   * @return array An array of account objects.
   */
  public function fetchUserAccounts(string $userId): array {
    return $this->client->request('GET', "/users/{$userId}/accounts");
  }

  /**
   * Fetches a specific user's account using the account URL.
   *
   * @param string $accountUrl
   *   The URL of the account to fetch.
   *
   * @return array An array containing account details.
   */
  public function fetchUsersAccount(string $accountUrl): array {
    // Parse the URL to get the path and query parts.
    $parsedUrl = parse_url($accountUrl);
    $relativeUrl = $parsedUrl['path'] . (isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '');

    return $this->httpClient->request('GET', $relativeUrl);
  }

  /**
   * Fetches consents associated with a specific user from the Basiq API.
   *
   * @param string $userId
   *   The ID of the user whose consents are to be fetched.
   *
   * @return array An array of consent objects.
   */
  public function getBasiqUserConsents(string $userId): array {
    return $this->httpClient->request('GET', "/users/{$userId}/consents");
  }

}
