<?php

namespace App\Application;

/**
 * Class AccountService.
 *
 * This class is responsible for managing and retrieving user accounts.
 */
class AccountService {

  /**
   * AccountService constructor.
   *
   * @param UserService $basiqUserService
   * @param AccountProcessingService $accountProcessingService
   */
  public function __construct(
    readonly UserService $basiqUserService,
    readonly AccountProcessingService $accountProcessingService,
  ) {
  }

  /**
   * Retrieves accounts by URLs.
   *
   * @param array $account_links
   *
   * @return array
   */
  public function getAccountsByUrls(array $account_links): array {
    $accounts = [];
    foreach ($account_links as $account_link) {
      $accounts[] = $this->basiqUserService->fetchUsersAccount($account_link);
    }
    return $this->accountProcessingService->setDefaultValuesForMissingKeysOfAccounts($accounts);
  }

}
