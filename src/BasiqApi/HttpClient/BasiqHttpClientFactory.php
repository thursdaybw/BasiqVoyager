<?php

namespace App\BasiqApi\HttpClient;

use App\BasiqApi\TokenHandler;

/**
 * Class BasiqHttpClientFactory.
 *
 * This class is responsible for creating HTTP clients to interact with the Basiq API.
 */
class BasiqHttpClientFactory {
  private $tokenHandler;

  /**
   * BasiqHttpClientFactory constructor.
   *
   * @param \App\BasiqApi\TokenHandler $tokenHandler
   *   Handler for managing JWT tokens for Basiq API authentication.
   */
  public function __construct(TokenHandler $tokenHandler) {
    $this->tokenHandler = $tokenHandler;
  }

  /**
   * Creates an HTTP client for interacting with the Basiq API.
   *
   * @return HttpClientInterface The HTTP client configured with the base URI and headers for Basiq API requests.
   */
  public function createClient(): HttpClientInterface {
    $baseUri = 'https://au-api.basiq.io';

    // getToken will take care of getting the current
    // or on the account of expiry, or absence, make the API
    // call to fetch a new one.
    $jwtToken = $this->tokenHandler->getToken();

    $headers = [
      'accept' => 'application/json',
      'authorization' => "Bearer $jwtToken",
      'basiq-version' => '3.0',
    ];

    return new GuzzleHttpClient($baseUri, $headers);
  }

}
