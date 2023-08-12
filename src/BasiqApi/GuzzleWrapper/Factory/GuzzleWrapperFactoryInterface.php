<?php

namespace App\BasiqApi\GuzzleWrapper\Factory;

use App\BasiqApi\HttpClient\HttpClientWrapperInterface;

interface GuzzleWrapperFactoryInterface {
  public function createClient(): HttpClientWrapperInterface;
}