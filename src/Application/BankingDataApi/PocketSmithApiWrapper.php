<?php

namespace App\Application\BankingDataApi;

use OpenAPI\Client\Api\AccountsApi;
use OpenAPI\Client\Api\TransactionsApi;

/**
 * Wraps the BasiqPHPAPI with a simple interface for use with our front end.
 *
 * @todo I am concerned about the connection to "BasiqUserConsents".
 */
class PocketSmithApiWrapper implements BankingDataApiInterface {

  public function __construct(
    readonly AccountsApi $accountsApi,
    readonly TransactionsApi $transactionsApi
  ) {}

  public function fetchData($userId): \stdClass {
    return $this->accountsApi->fetchUser($userId);
  }

  public function fetchUser($userId): \stdClass {
    return $this->accountsApi->usersIdAccountsGet($userId);
  }

  public function fetchUserAccounts($userId): array {
    return $this->accountsApi->usersIdAccountsGet($userId);
  }

  public function fetchUsersAccount($userId): ?array {
    return $this->accountsApi->fetchUsersAccount($userId);
  }

  public function getUserConsents($userId): ?array {
    return $this->accountsApi->getUserConsents($userId);
  }

  public function fetchAccountsTransactions(string $account_id): array {
    return $this->transactionsApi->accountsIdTransactionsGet($account_id);
  }

}
