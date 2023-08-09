<?php

namespace App\HttpClient;

interface HttpClientInterface {
    public function request(string $method, string $url);
}
