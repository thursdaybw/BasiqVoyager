<?php

namespace App\Model;

class User
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getAccountLinks()
    {
        $accountLinks = array();

        foreach ($this->data->accounts['data'] as $account) {
            $accountLinks[$account['id']] = $account['links']['self'];
        }

        return $accountLinks;
    }
}
