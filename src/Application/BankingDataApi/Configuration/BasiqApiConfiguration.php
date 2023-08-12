<?php

namespace App\Application\BankingDataApi\Configuration;

class BasiqApiConfiguration {
  private array $settings;

  public function __construct(array $basiqApiSettings) {
    $this->settings = $basiqApiSettings;
  }

  public function getUserId(): string {
    return $this->settings['user_id'];
  }

  public function getApiKey(): string {
    return $this->settings['api_key'];
  }

  // Other methods to access specific settings if needed
}
