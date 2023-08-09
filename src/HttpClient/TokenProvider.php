<?php

namespace App\HttpClient;

use App\Api\TokenHandler;

class TokenProvider implements TokenProviderInterface {

    private $tokenHandler;

    public function __construct() {
        $this->tokenHandler = new TokenHandler();
    }

    public function getToken(): string {
        return $this->tokenHandler->getToken();
    }

}
