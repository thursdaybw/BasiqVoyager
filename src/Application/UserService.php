<?php

namespace App\Application;

use App\Application\BankingDataApi\BankingDataApiInterface;
use OpenAPI\Client\Model\Account;

/**
 * Class UserService.
 *
 * This class is responsible for managing and retrieving user details and
 * accounts.
 */
class UserService {

  public function __construct(readonly BankingDataApiInterface $bankingDataApi) {}

  /**
   * Retrieves user consents.
   *
   * @param string $userId
   *
   * @return mixed
   */

  /**
   * Fetches user details.
   *
   * @param string $userId
   *
   * @return mixed
   */
  public function fetchUserDetails(string $userId) {
    $user = $this->bankingDataApi->fetchUser($userId);

    return $user;
  }

  /**
   * Fetches user's accounts.
   *
   * @param string $userId
   *
   * @return array
   */
  public function fetchUsersAccounts(string $userId) {
    $accounts = [];
    $accountLinks = $this->fetchUserDetails($userId)->getAccountLinks();
    foreach ($accountLinks as $accountLink) {
      $accounts[] = $this->bankingDataApi->fetchUsersAccount($accountLink);
    }
    // Process accounts as needed for the controller.
    return $accounts;
  }

  /**
   * Fetches user accounts.
   *
   * @param string $userId
   *
   * @return \OpenAPI\Client\Model\Account[]
   */
  public function fetchUserAccounts(string $userId): array {
    return $this->bankingDataApi->fetchUserAccounts($userId);
  }

  /**
   * Fetches a user's account.
   *
   * @param string $accountUrl
   *
   * @return array
   */
  public function fetchUsersAccount(string $accountUrl): array {
    return $this->bankingDataApi->fetchUsersAccount($accountUrl);
  }

}
