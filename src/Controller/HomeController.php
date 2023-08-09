<?php

namespace App\Controller;

require_once __DIR__ . "/../../config.php";

use App\Model\User;
use App\Service\AccountProcessingService;
use App\Service\BasiqUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    private $basiqUserService;
    private $accountProcessingService;

    public function __construct(BasiqUserService $basiqUserService, AccountProcessingService $accountProcessingService)
    {
        $this->basiqUserService = $basiqUserService;
        $this->accountProcessingService = $accountProcessingService;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $form = $this->createConnectBankForm();

       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $consents = $this->basiqUserService->getUserConsents(BASIC_TEST_USER_ID);
            $consent_errors_rendered = $this->handleConsentErrors($consents);

            if (isset($consents['data']) && !empty($consents['data'])) {
                if ($user = $this->basiqUserService->fetchUserDetails(BASIC_TEST_USER_ID)) {
                    $user_model = new User($user);
                    $account_links = $user_model->getAccountLinks();
                    $accounts = [];
                    foreach ($account_links as $account_link) {
                        $accounts[] = $this->basiqUserService->fetchUsersAccount($account_link);
                    }

                    $accounts = $this->accountProcessingService->setDefaultValuesForMissingKeysOfAccounts($accounts);

                    $accounts_rendered = $this->render(
                        'home/accounts.html.twig',
                        [
                            'accounts' => $accounts,
                        ]
                    );

                    $main_content_rendered = $this->render(
                        'home/main.html.twig',
                        [
                            'user' => $user,
                            'accounts' => $accounts_rendered,
                            'errors' => $consent_errors_rendered ?? null,
                        ]
                    );
                } else {
                    $main_content_rendered = "Error fetching user details.";
                }
            } else {
                $main_content_rendered = "No consents found for the user.";
            }

            return $this->render('home/index.html.twig', [
                'form' => NULL, 
                'showForm' => FALSE,
                'main' => $main_content_rendered,
            ]);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'showForm' => TRUE,
            'main' => 'Nothing happened.',
        ]);

    }

    private function processAccounts(array $accounts): array {
      $account_required_keys = [
        'balance', 'availableFunds', 'lastUpdated',
        'creditLimit', 'type', 'product',
        'accountHolder', 'status',
      ];

      foreach ($accounts as &$account) {
        foreach ($account_required_keys as $required_key) {
            if (!isset($account[$required_key])) {
                $account[$required_key] = NULL;
            }
        }
      }

      return $accounts;
   }

   private function createConnectBankForm(): FormInterface {
    return $this->createFormBuilder()
        ->add('connectBank', SubmitType::class, ['label' => 'Connect Bank'])
        ->getForm();
   }

   private function handleConsentErrors(array $consents): ?Response {
    if (isset($consents['data']) && !empty($consents['data'])) {
        $errors = array_filter($consents['data'], function ($item) {
            return isset($item['type']) && $item['type'] === 'error';
        });

        if (!empty($errors)) {
            error_log("Error found in the 'data' key of the response.");
            return $this->render(
                'consent_errors.html.twig',
                [
                    'correleation_id' => $consents['correlationId'],
                    'errors' => print_r($errors, 1),
                ]
            );
        }
    }

    return null;
   }


}
