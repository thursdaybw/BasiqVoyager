<?php

namespace App\BasiqApi\GuzzleWrapper\Factory;

use App\BasiqApi\BearerTokenManager;
use App\BasiqApi\GuzzleWrapper\GuzzleClientWrapper;
use App\BasiqApi\HttpClient\HttpClientWrapperInterface;

/**
 * Class BasiqHttpClientFactory.
 *
 * This class is responsible for creating HTTP clients to interact with the
 * Basiq API.
 */
class GuzzleWrapperWithAuthBearerTokenFactory implements GuzzleWrapperFactoryInterface {

  /**
   * BasiqHttpClientFactory constructor.
   *
   * @param \App\BasiqApi\BearerTokenManager $tokenHandler
   *   Handler for managing JWT tokens for Basiq API authentication.
   */
  public function __construct(readonly BearerTokenManager $tokenHandler) {}

  /**
   * Creates an HTTP client for interacting with the Basiq API.
   *
   * @return \App\BasiqApi\HttpClient\HttpClientWrapperInterface
   *   The GuzzleWrapper configured with headers for Basiq API requests.
   */
  public function createClient(string $baseUri): HttpClientWrapperInterface {

    // getToken will take care of getting the current
    // or on the account of expiry, or absence, make the API
    // call to fetch a new one.
    $jwtToken = $this->tokenHandler->getToken();

    $headers = [
      'accept' => 'application/json',
      'authorization' => "Bearer $jwtToken",
      'basiq-version' => '3.0',
    ];

    return new GuzzleClientWrapper($baseUri, $headers);
  }

}
