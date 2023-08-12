<?php

namespace App\BasiqApi\GuzzleWrapper;

use App\BasiqApi\HttpClient\HttpClientWrapperInterface;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;

/**
 * Class GuzzleHttpClientWrapper.
 *
 * This class implements the HttpClientInterface and provides a simplified
 * interface for making HTTP requests using Guzzle.
 *
 * In handles a extra guzzle configuration such as enabling logging.
 */
class GuzzleClientWrapper implements HttpClientWrapperInterface {

  private Client $client;

  private ?Response $response;

  /**
   * GuzzleHttpClientWrapper constructor.
   *
   * @param string $baseUri
   *   The base URI for the HTTP client.
   * @param array $headers
   *   Optional headers to include with requests. */
  public function __construct(string $baseUri, array $headers = []) {

    /*
     * Use Monologger to configure a locger to pass on to guzzle.
     */
    $log = new Logger('guzzle');
    $log->pushHandler(new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::DEBUG));

    /*
     * Stick the logger on the stack.
     */
    $stack = HandlerStack::create();
    $stack->push(
          Middleware::log(
              $log,
              new MessageFormatter(MessageFormatter::DEBUG)
          )
      );

    /*
     * Thanks to the logging that we just setup, we can set debug to  TRUE here
     * and guzzle logs to PHP's error log. (ErrorLogHandler::OPERATING_SYSTEM).
     */
    $this->client = new Client([
      'handler' => $stack,
      'debug'   => FALSE,
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
   * @param ?array $options
   *   Optional options to include with the request.
   *
   * @return array The response body as an associative array.
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
      throw new GuzzleWrapperException('Error making HTTP request: ' . $e->getMessage(), $e->getCode(), $e);
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

  /**
   * Retrieves the status code from the last response.
   *
   * @return ?array The status code, or FALSE if no response is available.
   */
  public function getResponseHeaders(): ?array {
    if (!empty($this->response)) {
      return $this->response->getHeaders();
    }
    else {
      return NULL;
    }
  }

}
