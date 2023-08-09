<?php

namespace App\Service;

class AccountService {

    private $basiqUserService;
    private $accountProcessingService; // Correct property

    public function __construct(BasiqUserService $basiqUserService, AccountProcessingService $accountProcessingService) {
        $this->basiqUserService = $basiqUserService;
        $this->accountProcessingService = $accountProcessingService; // Correct assignment
    }


    public function getAccountsByUrls(array $account_links): array {
        $accounts = [];
        foreach ($account_links as $account_link) {
            $accounts[] = $this->basiqUserService->fetchUsersAccount($account_link);
        }
        return $this->accountProcessingService->setDefaultValuesForMissingKeysOfAccounts($accounts);
    }

}
