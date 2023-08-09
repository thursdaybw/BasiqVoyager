<?php

namespace App\BasiqApi\HttpClient;

interface HttpClientInterface
{
    public function request(string $method, string $url);
}
