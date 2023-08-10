<?php

namespace App\BasiqApi\HttpClient;

use GuzzleHttp\Client;

/**
 * Class GuzzleHttpClient
 * This class implements the HttpClientInterface and provides methods for making HTTP requests using Guzzle.
 */
class GuzzleHttpClient implements HttpClientInterface {
  private $client;

  /**
   * GuzzleHttpClient constructor.
   *
   * @param string $baseUri
   *   The base URI for the HTTP client.
   * @param array $headers
   *   Optional headers to include with requests.
   */
  public function __construct(string $baseUri, array $headers = []) {
    $this->client = new Client([
      'base_uri' => $baseUri,
      'headers' => $headers,
    ]);
    $this->response = NULL;
  }

  /**
   * Makes a GET request to the specified URL.
   *
   * @param string $url
   *   The URL to request.
   * @param array $query_parameters
   *   Optional query parameters to include with the request.
   *
   * @return array The response body as an associative array.
   */
  public function get(string $url, array $query_parameters = NULL) {
    $options = [
      'query' => $query_string_data ?? NULL,
    ];

    return $this->request('GET', $url, $options);
  }

  /**
   * Makes a POST request to the specified URL.
   *
   * @param string $url
   *   The URL to request.
   * @param array $form_params
   *   Optional form parameters to include with the request.
   *
   * @return array The response body as an associative array.
   */
  public function post(string $url, array $form_params = NULL) {
    $options = [
      'form_params' => $form_params ?? NULL,
    ];

    return $this->request('POST', $url, $options);
  }

  /**
   * Makes an HTTP request using the specified method, URL, and options.
   *
   * @param string $method
   *   The HTTP method to use (e.g., GET, POST).
   * @param string $url
   *   The URL to request.
   * @param array $options
   *   Optional options to include with the request.
   *
   * @return array The response body as an associative array.
   *
   * @throws HttpClientException If an error occurs during the request.
   */
  public function request(string $method, string $url, array $options = NULL) {

    try {
      if ($options) {
        $this->response = $this->client->request($method, $url, $options);
      }
      else {
        $this->response = $this->client->request($method, $url);
      }

      $body = json_decode($this->response->getBody(), TRUE);
      return $body;
    }
    catch (\Exception $e) {
      throw new HttpClientException('Error making HTTP request: ' . $e->getMessage(), $e->getCode(), $e);
    }
  }

  /**
   * Retrieves the status code from the last response.
   *
   * @return int|bool The status code, or FALSE if no response is available.
   */
  public function getStatusCode() {
    if (!empty($this->response)) {
      return $this->response->getStatusCode();
    }
    else {
      return FALSE;
    }
  }

}
