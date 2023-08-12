<?php

namespace App\BasiqApi\HttpClient;

/**
 * Interface HttpClientInterface.
 *
 * This interface defines the contract for HTTP clients used in the project,
 * providing a method for making HTTP requests.
 */
interface HttpClientWrapperInterface {

  /**
   * Makes an HTTP request using the specified method and URL.
   *
   * @param string $method
   *   The HTTP method to use (e.g., GET, POST).
   * @param string $url
   *   The URL to request.
   *
   * @return mixed The response from the HTTP request.
   */
  public function request(string $method, string $url);

}
