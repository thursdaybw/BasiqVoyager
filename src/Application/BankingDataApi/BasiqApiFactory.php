<?php

namespace App\Application\BankingDataApi;

use BasiqPhpApi\ContainerFactory;

class BasiqApiFactory
{
  public static function create(array $settings)
  {
    $containerFactory = new ContainerFactory($settings);
    $container = $containerFactory->createContainer();

    return $container->get('BasiqPhpApi\Api');
  }
}
