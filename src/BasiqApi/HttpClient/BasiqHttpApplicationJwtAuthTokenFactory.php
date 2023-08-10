<?php

namespace App\BasiqApi\HttpClient;

// Include the config file for API key and other configurations.
require_once __DIR__ . '/../../../config.php';

/**
 * Class BasiqHttpApplicationJwtAuthTokenFactory.
 *
 * This class is responsible for creating HTTP clients specifically for
 * handling JWT authentication tokens with the Basiq API.
 */
class BasiqHttpApplicationJwtAuthTokenFactory {

  /**
   * Creates an HTTP client which handles JWT auth tokens with the Basiq API.
   *
   * @return GuzzleHttpClient
   *   The HTTP client configured with the base URI and headers for JWT auth.
   */
  public function createClient(): GuzzleHttpClient {
    $baseUri = 'https://au-api.basiq.io';
    $headers = [
      'accept' => 'application/json',
      'authorization' => 'Basic ' . BASIQ_API_KEY,
      'basiq-version' => '3.0',
      'content-type' => 'application/x-www-form-urlencoded',
    ];

    return new GuzzleHttpClient($baseUri, $headers);
  }

}
