<?php

namespace App;

use App\BasiqApi\HttpClient\BasiqHttpClientFactory;
use App\BasiqApi\HttpClient\HttpClientInterface;

class SymfonyHttpClient implements HttpClientInterface {

    private HttpClientInterface $client;

    public function __construct(BasiqHttpClientFactory $factory)
    {
        $this->client = $factory->createHttpClient();
    }

    public function get($url)
    {
        return $this->client->get($url);
    }

    // other methods

  /**
   * @inheritDoc
   */
  public function request(string $method, string $url) {
    return $this->client->request($method, $url);
  }

}
