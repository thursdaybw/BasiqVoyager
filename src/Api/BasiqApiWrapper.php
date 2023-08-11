<?php

namespace App\Api;

use App\BasiqApi\BasiqApi;

/**
 *
 * @todo create an interface for this and simplify it.
 * @todo I am concerned about the connection to "BasiqUserConsents".
 */
class BasiqApiWrapper implements ApiInterface
{
  private $basiqApi;

  public function __construct(BasiqApi $basiqApi)
  {
    $this->basiqApi = $basiqApi;
  }

  public function fetchData($userId)
  {
    return $this->basiqApi->fetchUser($userId);
  }

  public function fetchUser($userId)
  {
    return $this->basiqApi->fetchUser($userId);
  }

  public function fetchUserAccounts($userId)
  {
    return $this->basiqApi->fetchUserAccounts($userId);
  }

  public function fetchUsersAccount($userId)
  {
    return $this->basiqApi->fetchUsersAccount($userId);
  }

  public function getBasiqUserConsents($userId)
  {
    $consents = $this->basiqApi->getBasiqUserConsents($userId);
    return $this->basiqApi->getBasiqUserConsents($userId);
  }

}

