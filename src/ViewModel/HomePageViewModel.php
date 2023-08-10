<?php

namespace App\ViewModel;

use Symfony\Component\Form\FormView;

class HomePageViewModel
{
    private $form;
    private $showForm;
    private $user;
    private $accounts;
    private $errors;
    private $message;

    public function getForm(): ?FormView
    {
        return $this->form;
    }

    public function setForm(?FormView $form): void
    {
        $this->form = $form;
    }

    public function getShowForm(): bool
    {
        return $this->showForm;
    }

    public function setShowForm(bool $showForm): void
    {
        $this->showForm = $showForm;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getAccounts()
    {
        return $this->accounts;
    }

    public function setAccounts($accounts): void
    {
        $this->accounts = $accounts;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): void
    {
        $this->message = $message;
    }
}
