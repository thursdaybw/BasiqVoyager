<?php

namespace App\Application;

use App\Application\BankingDataApi\BankingDataApiInterface;

/**
 * Class UserService.
 *
 * This class is responsible for managing and retrieving user details and
 * accounts.
 */
class UserService {

  private $bankingDataApi;

  /**
   * BasiqUserService constructor.
   *
   * @param \App\Application\BankingDataApi\BankingDataApiInterface $api
   */
  public function __construct(BankingDataApiInterface $api) {
    $this->bankingDataApi = $api;
  }

  /**
   * Retrieves user consents.
   *
   * @param string $userId
   *
   * @return mixed
   */
  public function getUserConsents(string $userId) {
    // Use BasiqApi to fetch consents and process as needed.
    $consents = $this->bankingDataApi->getUserConsents($userId);
    return $consents;
  }

  /**
   * Fetches user details.
   *
   * @param string $userId
   *
   * @return mixed
   */
  public function fetchUserDetails(string $userId) {
    $user = $this->bankingDataApi->fetchUser($userId);
    // Process user details as needed for the controller.
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
   * @return array
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
