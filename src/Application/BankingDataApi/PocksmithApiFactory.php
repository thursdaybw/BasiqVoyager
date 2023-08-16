<?php

namespace App\Application\BankingDataApi;

use GuzzleHttp\Client;
use OpenAPI\Client\Api\AccountsApi;
use OpenAPI\Client\Configuration;

class PocksmithApiFactory {

  public static function create(array $settings) {

    $config = Configuration::getDefaultConfiguration()
      ->setApiKey('X-Developer-Key', $settings['api_key']);

    $api = new AccountsApi(
      new Client(),
      $config
    );

    return new PocketSmithApiWrapper($api);

  }

}
