<?php

namespace App\Service;

use App\ViewModel\HomePageViewModel;
use App\Model\User;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

// Include the config file for API key and other configurations
require_once(__DIR__ . '/../../config.php');

class HomePageService
{
    private $basiqUserService;
    private $consentService;
    private $accountService;
    private FormFactoryInterface $formFactory;

    public function __construct(
        BasiqUserService $basiqUserService,
        ConsentService $consentService,
        AccountService $accountService,
        FormFactoryInterface $formFactory,
    ) {
        $this->basiqUserService = $basiqUserService;
        $this->consentService = $consentService;
        $this->accountService = $accountService;
        $this->formFactory = $formFactory;
        $this->formBuilder = $this->formFactory->createBuilder();
    }

    public function handleHomePageRequest(Request $request): HomePageViewModel
    {
        $form = $this->createConnectBankForm();
        $form->handleRequest($request);

        $showForm = true;
        $mainContent = 'Nothing happened.';

        if ($form->isSubmitted() && $form->isValid()) {
            $consents = $this->basiqUserService->getUserConsents(BASIC_TEST_USER_ID);
            $consentErrorsRendered = $this->consentService->handleConsentErrors($consents);

            if (isset($consents['data']) && !empty($consents['data'])) {
                if ($user = $this->basiqUserService->fetchUserDetails(BASIC_TEST_USER_ID)) {
                    $userModel = new User($user);
                    $accounts = $this->accountService->getAccountsByUrls($userModel->getAccountLinks());
                    $mainContent = [
                        'user' => $user,
                        'accounts' => $accounts,
                        'errors' => $consentErrorsRendered ?? null
                    ];
                } else {
                    $mainContent = "Error fetching user details.";
                }
            } else {
                $mainContent = "No consents found for the user.";
            }

            $showForm = false;
        }

        $viewModel = new HomePageViewModel();
        $viewModel->setForm($form->createView());
        $viewModel->setShowForm($showForm);
        $viewModel->setMainContent($mainContent);

        return $viewModel;
    }

    private function createConnectBankForm(): FormInterface
    {
      return $this->formBuilder
        ->add('connectBank', SubmitType::class, ['label' => 'Connect Bank'])
        ->getForm();
    }
}
