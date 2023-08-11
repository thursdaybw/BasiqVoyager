<?php

namespace App\Service;

use App\Api\ApiInterface;
use App\BasiqApi\BasiqApi;

/**
 * Class BasiqUserService.
 *
 * This class is responsible for managing and retrieving user details and
 * accounts.
 */
class BasiqUserService {

  private $basiqApi;

  /**
   * BasiqUserService constructor.
   *
   * @param \App\Api\ApiInterface $api
   */
  public function __construct(ApiInterface $api) {
    $this->basiqApi = $api;
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
    $consents = $this->basiqApi->getBasiqUserConsents($userId);
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
    $user = $this->basiqApi->fetchUser($userId);
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
      $accounts[] = $this->basiqApi->fetchUsersAccount($accountLink);
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
    return $this->basiqApi->fetchUserAccounts($userId);
  }

  /**
   * Fetches a user's account.
   *
   * @param string $accountUrl
   *
   * @return array
   */
  public function fetchUsersAccount(string $accountUrl): array {
    return $this->basiqApi->fetchUsersAccount($accountUrl);
  }

}
