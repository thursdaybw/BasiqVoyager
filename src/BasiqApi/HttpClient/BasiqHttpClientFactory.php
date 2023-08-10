<?php

namespace App\BasiqApi\HttpClient;

use App\BasiqApi\TokenHandler;

/**
 *
 */
class BasiqHttpClientFactory {
  private $tokenHandler;

  /**
   *
   */
  public function __construct(TokenHandler $tokenHandler) {
    $this->tokenHandler = $tokenHandler;
  }

  /**
   *
   */
  public function createClient(): HttpClientInterface {
    $baseUri = 'https://au-api.basiq.io';

    // getToken will take care of getting the current
    // or on the account of expiry, or absense, make the API
    // cal to fetch a new one.
    $jwtToken = $this->tokenHandler->getToken();

    $headers = [
      'accept' => 'application/json',
      'authorization' => "Bearer $jwtToken",
      'basiq-version' => '3.0',
    ];

    return new GuzzleHttpClient($baseUri, $headers);
  }

}
