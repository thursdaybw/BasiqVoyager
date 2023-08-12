<?php

namespace App\BasiqApi\GuzzleWrapper\Factory;

use App\BasiqApi\GuzzleWrapper\GuzzleClientWrapper;

require_once __DIR__ . '/../../../../config.php';

/**
 * Class HttpApplicationWithAuthBasicFactory.
 *
 * This class is responsible for creating HTTP clients specifically for
 * handling JWT authentication tokens with the Basiq API.
 */
class GuzzleWrapperWithAuthBasicFactory implements GuzzleWrapperFactoryInterface {

  /**
   * Creates an HTTP client which handles JWT auth tokens with the Basiq API.
   *
   * @return GuzzleClientWrapper
   *   The HTTP client configured with the base URI and headers for JWT auth.
   */
  public function createClient(): GuzzleClientWrapper {
    $baseUri = 'https://au-api.basiq.io';
    $headers = [
      'accept' => 'application/json',
      'authorization' => 'Basic ' . BASIQ_API_KEY,
      'basiq-version' => '3.0',
      'content-type' => 'application/x-www-form-urlencoded',
    ];

    return new GuzzleClientWrapper($baseUri, $headers);
  }

}
