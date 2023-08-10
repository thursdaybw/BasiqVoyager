<?php

namespace App\BasiqApi\HttpClient;

use GuzzleHttp\Client;

/**
 *
 */
class GuzzleHttpClient implements HttpClientInterface {
  private $client;

  /**
   *
   */
  public function __construct(string $baseUri, array $headers = []) {
    $this->client = new Client([
      'base_uri' => $baseUri,
      'headers' => $headers,
    ]);
    $this->response = NULL;
  }

  /**
   *
   */
  public function get(string $url, array $query_parameters = NULL) {
    $options = [
      'query' => $query_string_data ?? NULL,
    ];

    return $this->request('GET', $url, $options);
  }

  /**
   *
   */
  public function post(string $url, array $form_params = NULL) {
    $options = [
      'form_params' => $form_params ?? NULL,
    ];

    return $this->request('POST', $url, $options);
  }

  /**
   *
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
   *
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
