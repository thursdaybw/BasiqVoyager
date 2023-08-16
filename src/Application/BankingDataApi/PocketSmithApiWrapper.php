<?php

namespace App\Application\BankingDataApi;

use OpenAPI\Client\Api\AccountsApi;

/**
 * Wraps the BasiqPHPAPI with a simple interface for use with our front end.
 *
 * @todo I am concerned about the connection to "BasiqUserConsents".
 */
class PocketSmithApiWrapper implements BankingDataApiInterface {

  private $api;

  public function __construct(AccountsApi $api) {
    $this->api = $api;
  }

  public function fetchData($userId): \stdClass {
    return $this->api->fetchUser($userId);
  }

  public function fetchUser($userId): \stdClass {
    return $this->api->usersIdAccountsGet($userId);
  }

  public function fetchUserAccounts($userId): array {
    return $this->api->usersIdAccountsGet($userId);
  }

  public function fetchUsersAccount($userId): ?array {
    return $this->api->fetchUsersAccount($userId);
  }

  public function getUserConsents($userId): ?array {
    return $this->api->getUserConsents($userId);
  }

}
