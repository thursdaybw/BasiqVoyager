<?php

require_once __DIR__  . "/../config.php";
require_once __DIR__  . "/../vendor/autoload.php"; // Include this if your autoload file is in the vendor directory

use App\BasiqApi\BasiqApi;
use App\BasiqApi\TokenHandler;
use App\BasiqApi\HttpClient\GuzzleHttpClient;
use App\BasiqApi\HttpClient\BasiqHttpClientFactory;
use App\Service\ConsentService;
use App\Model\User;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);

$tokenHandler = new TokenHandler(); 
$httpClientFactory = new BasiqHttpClientFactory($tokenHandler);
$httpClient = $httpClientFactory->createClient();

$api = new BasiqApi($httpClient);
$consentService = new ConsentService($httpClient);

$userId = BASIC_TEST_USER_ID;

$main_content = '';
if (isset($_POST['connectBank'])) {

    $consents = $consentService->getBasiqUserConsents($userId);

    if (isset($consents['data']) && !empty($consents['data'])) {

        // Check for errors in the 'data' array
        $errors = array_filter($consents['data'], function($item) {
            return isset($item['type']) && $item['type'] === 'error';
        });

        if (!empty($errors)) {
            // Log the error for debugging
            error_log("Error found in the 'data' key of the response.");

            $consent_errors_rendered = $twig->render(
                'consent_errors_template.twig',
                [
                  'correleation_id' => $consents['correlationId'],
                  'errors' => print_r($errors, 1),
                ],
            );
        }
        
    }

    if (isset($consents['data']) && !empty($consents['data'])) {

        if ($user = $api->fetchUser($userId)) {

            $user_model = new User($user);
            $account_links = $user_model->getAccountLinks();
            $accounts = [];
            foreach ($account_links as $account_link) {
               $accounts[] = $api->fetchUsersAccount($account_link);
            }

            $accounts_rendered = $twig->render(
                'accounts_template.twig',
                [
                  'accounts' => $accounts,
                ]
            );

            $main_content_rendered = $twig->render(
                'main_template.twig',([
                'user' => $user,
                'accounts' => $accounts_rendered, 
                'errors' => $consent_errors_rendered ?? null, 
            ]));

        } else {
            $main_content_rendered = "Error fetching user details.";
        }

    } else {
        $main_content_rendered = "No consents found for the user.";
    }

}

echo $twig->render(
  'page.twig',([
  'main' => $main_content_rendered,
]));
