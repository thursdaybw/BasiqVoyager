<?php

namespace App\ViewModel;

use Symfony\Component\Form\FormView;

class HomePageViewModel
{
    private $form;
    private $showForm;
    private $mainContent;

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

    public function getMainContent()
    {
        return $this->mainContent;
    }

    public function setMainContent($mainContent): void
    {
        $this->mainContent = $mainContent;
    }
}
