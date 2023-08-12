<?php

namespace App\Application\BankingDataApi;

use App\BasiqApi\BasiqApi;

/**
 * Wraps the BasiqPHPAPI with a simple interface for use with our front end.
 *
 * @todo I am concerned about the connection to "BasiqUserConsents".
 */
class BasiqBankingDataApiWrapper implements BankingDataApiInterface {

  private $basiqApi;

  public function __construct(BasiqApi $basiqApi) {
    $this->basiqApi = $basiqApi;
  }

  public function fetchData($userId): \stdClass {
    return $this->basiqApi->fetchUser($userId);
  }

  public function fetchUser($userId): \stdClass {
    return $this->basiqApi->fetchUser($userId);
  }

  public function fetchUserAccounts($userId): array {
    return $this->basiqApi->fetchUserAccounts($userId);
  }

  public function fetchUsersAccount($userId): ?array {
    return $this->basiqApi->fetchUsersAccount($userId);
  }

  public function getUserConsents($userId): ?array {
    return $this->basiqApi->getUserConsents($userId);
  }

}
