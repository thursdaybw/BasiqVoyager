<?php

namespace App\Model;

/**
 * This is a model for the user data, so we can keep the processing isolated.
 */
class UserModel {

  private array $data;

  /**
   * Constructs a new UserModel.
   */
  public function __construct(array $data) {
    $this->data = $data;
  }

  /**
   * Gets the links to the account endpoints for each of the user's accounts.
   *
   * @todo This is BasiqApi specific. We need to decouple it from the API.
   */
  public function getAccountLinks() {
    $accountLinks = [];

    foreach ($this->data->accounts['data'] as $account) {
      $accountLinks[$account['id']] = $account['links']['self'];
    }

    return $accountLinks;
  }

}
