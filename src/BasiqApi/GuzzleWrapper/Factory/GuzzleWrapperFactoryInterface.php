<?php

namespace App\BasiqApi\GuzzleWrapper\Factory;

use App\BasiqApi\HttpClient\HttpClientWrapperInterface;

/**
 * Provides and interface for GuzzleWrapperFactories.
 *
 * A GuzzleWrapper is just a wrapper around guzzle, providing a simpler
 * interface designed for our needs, and some custom wiring, for example
 * enabling Guzzle's logging.
 *
 * We have two GuzzleWrapperFactories, one is build with a basic
 * auth header in the HTTP client, the other with a bearer token in the
 * header.
 *
 * This interface allows us to instantiate the GuzzleWrappers as service
 * via these factories.
 */
interface GuzzleWrapperFactoryInterface {

  public function createClient(string $baseUri): HttpClientWrapperInterface;

}
