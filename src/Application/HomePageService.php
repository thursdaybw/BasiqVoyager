<?php

namespace App\Application;

use App\Alias\BasiqUserId;
use App\Model\UserModel;
use App\ViewModel\HomePageViewModel;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomePageService.
 *
 * This class is responsible for handling home page requests and managing the
 * connect bank form.
 */
class HomePageService {

  /**
   * HomePageService constructor.
   *
   * @param UserService $basiqUserService
   * @param AccountService $accountService
   * @param \Symfony\Component\Form\FormFactoryInterface $formFactory
   * @param string $userId
   */
  public function __construct(
    readonly UserService $basiqUserService,
    readonly AccountService $accountService,
    readonly FormFactoryInterface $formFactory,
    readonly string $userId
  ) {}

  /**
   * Handles home page requests and returns a view model.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \App\ViewModel\HomePageViewModel
   */
  public function handleHomePageRequest(Request $request): HomePageViewModel {
    $form = $this->createConnectBankForm();
    $form->handleRequest($request);

    $showForm = TRUE;
    $viewModel = new HomePageViewModel();

    if ($form->isSubmitted() && $form->isValid()) {
      $consents = $this->basiqUserService->getUserConsents($this->userId);

      if (isset($consents['data']) && !empty($consents['data'])) {
        if ($user = $this->basiqUserService->fetchUserDetails($this->userId)) {
          $userModel = new UserModel($user);
          $accounts = $this->accountService->getAccountsByUrls($userModel->getAccountLinks());

          $viewModel->setUser($user);
          $viewModel->setAccounts($accounts);

        }
        else {
          $viewModel->setMessage("Error fetching user details.");
        }
      }
      else {
        $viewModel->setMessage("Error fetching user details. No valid consents found.");
      }

      $showForm = FALSE;
    }

    $viewModel->setForm($form->createView());
    $viewModel->setShowForm($showForm);

    return $viewModel;
  }

  /**
   * Creates the connect bank form.
   *
   * @return \Symfony\Component\Form\FormInterface
   */
  private function createConnectBankForm(): FormInterface {
    return $this->formFactory->createBuilder()
      ->add('connectBank', SubmitType::class, ['label' => 'Connect Bank'])
      ->getForm();
  }

}
