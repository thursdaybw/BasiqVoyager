<?php

namespace App\Controller;

require_once __DIR__ . "/../../config.php";

use App\BasiqApi\BasiqApi;
use App\BasiqApi\TokenHandler;
use App\BasiqApi\HttpClient\GuzzleHttpClient;
use App\BasiqApi\HttpClient\BasiqHttpClientFactory;
use App\Service\ConsentService;
use App\Model\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    #[Route('/', name: 'home')]
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder()
        ->add('connectBank', SubmitType::class, ['label' => 'Connect Bank'])
        ->getForm();

       $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Handle form submission
            $tokenHandler = new TokenHandler();
            $httpClientFactory = new BasiqHttpClientFactory($tokenHandler);

            $api = new BasiqApi($httpClientFactory);
            $consentService = new ConsentService($httpClientFactory);

            $consents = $consentService->getBasiqUserConsents(BASIC_TEST_USER_ID);

            if (isset($consents['data']) && !empty($consents['data'])) {
                $errors = array_filter($consents['data'], function ($item) {
                    return isset($item['type']) && $item['type'] === 'error';
                });

                if (!empty($errors)) {
                    error_log("Error found in the 'data' key of the response.");
                    $consent_errors_rendered = $this->render(
                        'consent_errors.html.twig',
                        [
                            'correleation_id' => $consents['correlationId'],
                            'errors' => print_r($errors, 1),
                        ]
                    );
                }
            }

            if (isset($consents['data']) && !empty($consents['data'])) {
                if ($user = $api->fetchUser(BASIC_TEST_USER_ID)) {
                    $user_model = new User($user);
                    $account_links = $user_model->getAccountLinks();
                    $accounts = [];
                    foreach ($account_links as $account_link) {
                        $accounts[] = $api->fetchUsersAccount($account_link);
                    }

                    $account_required_keys = [
                        'balance',
                        'availableFunds',
                        'lastUpdated',
                        'creditLimit',
                        'type',
                        'product',
                        'accountHolder',
                        'status',
                    ];


                    foreach ($accounts as &$account) {
                      foreach ($account_required_keys as $required_key) {
                         if (!isset($account[$required_key])) {
                            $account[$required_key] = NULL;
                         } 
                      }
                    }

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
}
