<?php

namespace App\Application\BankingDataApi;

/**
 * This provides an interface for out app to interact with banking data.
 */
interface BankingDataApiInterface {

  public function fetchData(string $endpoint): \stdClass;

  public function fetchUser(string $userId): \stdClass;

  public function fetchUserAccounts(string $userId): array;

  public function fetchAccountsTransactions(string $account_id): array;

  public function fetchUsersAccount(string $userId): ?array;

  public function getUserConsents(string $userId): ?array;

}
