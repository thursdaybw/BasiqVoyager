<?php

namespace App\Controller;

require_once __DIR__ . "/../../config.php";

use App\Model\User;
use App\Service\AccountProcessingService;
use App\Service\AccountService;
use App\Service\BasiqUserService;
use App\Service\ConsentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    private $basiqUserService;
    private $accountProcessingService;
    private $consentService;
    private $accountService;

    public function __construct(
        BasiqUserService $basiqUserService,
        ConsentService $consentService,
        AccountService $accountService
        ) {
            $this->basiqUserService = $basiqUserService;
            $this->consentService = $consentService;
            $this->accountService = $accountService;
    }

    #[Route('/', name: 'home')]
    public function index(Request $request): Response {
        $form = $this->createConnectBankForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $consents = $this->basiqUserService->getUserConsents(BASIC_TEST_USER_ID);
            $consent_errors_rendered = $this->consentService->handleConsentErrors($consents);

            $main_content_rendered = $this->handleMainContent($consents, $consent_errors_rendered);

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

    private function handleMainContent($consents, $consent_errors_rendered) {
        if (isset($consents['data']) && !empty($consents['data'])) {
            if ($user = $this->basiqUserService->fetchUserDetails(BASIC_TEST_USER_ID)) {
                $user_model = new User($user);

                $accounts = $this->accountService->getAccountsByUrls($user_model->getAccountLinks());

                return $this->renderMainContent($user, $accounts, $consent_errors_rendered);
            } else {
                return "Error fetching user details.";
            }
        } else {
            return "No consents found for the user.";
        }
    }

    private function renderMainContent($user, $accounts, $consent_errors_rendered) {
        $accounts_rendered = $this->render('home/accounts.html.twig', ['accounts' => $accounts]);
        return $this->render('home/main.html.twig', [
            'user' => $user,
            'accounts' => $accounts_rendered,
            'errors' => $consent_errors_rendered ?? null,
        ]);
    }


    private function createConnectBankForm(): FormInterface {
        return $this->createFormBuilder()
            ->add('connectBank', SubmitType::class, ['label' => 'Connect Bank'])
            ->getForm();
    }

}