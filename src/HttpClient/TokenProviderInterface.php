<?php

namespace App\HttpClient;

interface TokenProviderInterface {
    public function getToken(): string;
}