<?php

namespace App\Service;

/**
 * Class AccountProcessingService.
 *
 * This class is responsible for processing and setting default values for
 * account details.
 */
class AccountProcessingService {

  /**
   * Sets default values for missing keys of accounts.
   *
   * @param array $accounts
   *
   * @return array
   */
  public function setDefaultValuesForMissingKeysOfAccounts(array $accounts): array {
    $account_required_keys = [
      'balance', 'availableFunds', 'lastUpdated',
      'creditLimit', 'type', 'product',
      'accountHolder', 'status',
    ];

    foreach ($accounts as &$account) {
      foreach ($account_required_keys as $required_key) {
        if (!isset($account[$required_key])) {
          $account[$required_key] = NULL;
        }
      }
    }

    return $accounts;
  }

}
