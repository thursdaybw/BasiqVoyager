<?php

namespace App\Service;

class AccountProcessingService
{
    public function setDefaultValuesForMissingKeysOfAccounts(array $accounts): array
    {
        $account_required_keys = [
            'balance', 'availableFunds', 'lastUpdated',
            'creditLimit', 'type', 'product',
            'accountHolder', 'status',
        ];

        foreach ($accounts as &$account) {
            foreach ($account_required_keys as $required_key) {
                if (!isset($account[$required_key])) {
                    $account[$required_key] = null;
                }
            }
        }

        return $accounts;
    }
}
