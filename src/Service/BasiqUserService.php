<?php

namespace App\Service;

use App\BasiqApi\BasiqApi;

class BasiqUserService
{
    private $basiqApi;

    public function __construct(BasiqApi $basiqApi)
    {
        $this->basiqApi = $basiqApi;
    }

    public function getUserConsents(string $userId)
    {
        // Use BasiqApi to fetch consents and process as needed
        return $this->basiqApi->getBasiqUserConsents($userId);
    }

    public function fetchUserDetails(string $userId)
    {
        $user = $this->basiqApi->fetchUser($userId);
        // Process user details as needed for the controller
        return $user;
    }

    public function fetchUsersAccounts(string $userId)
    {
        $accounts = [];
        $accountLinks = $this->fetchUserDetails($userId)->getAccountLinks();
        foreach ($accountLinks as $accountLink) {
            $accounts[] = $this->basiqApi->fetchUsersAccount($accountLink);
        }
        // Process accounts as needed for the controller
        return $accounts;
    }

    public function fetchUserAccounts(string $userId): array
    {
        return $this->basiqApi->fetchUserAccounts($userId);
    }

    public function fetchUsersAccount(string $accountUrl): array
    {
        return $this->basiqApi->fetchUsersAccount($accountUrl);
    }
}
