<?php

require_once __DIR__  . "/../config.php";
require_once __DIR__  . "/../vendor/autoload.php"; // Include this if your autoload file is in the vendor directory

use App\Api\BasiqApi;
use App\Api\TokenHandler;
use App\HttpClient\GuzzleHttpClient;
use App\HttpClient\BasiqHttpClientFactory;
use App\Service\ConsentService;
use App\Model\User;

$tokenHandler = new TokenHandler(); 
$httpClientFactory = new BasiqHttpClientFactory($tokenHandler);
$httpClient = $httpClientFactory->createClient();

$api = new BasiqApi($httpClient);
$consentService = new ConsentService($httpClient);

$userId = BASIC_TEST_USER_ID;

function processAccountData($accounts) {
    $processedAccounts = array();

    foreach ($accounts as $account) {
        $processedAccount = array();

        $processedAccount['name'] = $account['name'] ?? '';
        $processedAccount['accountNo'] = $account['accountNo'] ?? '';
        $processedAccount['balance'] = $account['balance'] ?? '';
        $processedAccount['availableFunds'] = $account['availableFunds'] ?? '';
        $processedAccount['lastUpdated'] = $account['lastUpdated'] ?? '';
        $processedAccount['creditLimit'] = $account['creditLimit'] ?? '';
        $processedAccount['type'] = $account['type'] ?? '';
        $processedAccount['product'] = $account['class']['product'] ?? '';
        $processedAccount['accountHolder'] = $account['accountHolder'] ?? '';
        $processedAccount['status'] = $account['status'] ?? '';

        $processedAccounts[] = $processedAccount;
    }

    return $processedAccounts;
}

function generateAccountHTML($processedAccounts) {
    $html = '';

    foreach ($processedAccounts as $account) {

        $name           = $account['name'] ?? null; 
        $accountNo      = $account['accountNo'] ?? null; 
        $balance        = $account['balance'] ?? null; 
        $availableFunds = $account['availableFunds'] ?? null; 
        $lastUpdated    = $account['lastUpdated'] ?? null; 
        $creditLimit    = $account['creditLimit'] ?? null; 
        $type           = $account['type'] ?? null; 
        $product        = $account['product'] ?? null; 
        $accountHolder  = $account['accountHolder'] ?? null; 
        $status         = $account['status'] ?? null; 

        $html .= <<<EOT
        <table class="account" style="margin-top: 50px">
            <tr><th colspan="2" style="text-align: left;">{$name}</th></tr>
            <tr><td>Account No:</td><td>{$accountNo}</td></tr>
            <tr><td>Balance:</td><td>{$balance}</td></tr>
            <tr><td>Available Funds:</td><td>{$availableFunds}</td></tr>
            <tr><td>Last Updated:</td><td>{$lastUpdated}</td></tr>
            <tr><td>Credit Limit:</td><td>{$creditLimit}</td></tr>
            <tr><td>Type:</td><td>{$type}</td></tr>
            <tr><td>Product:</td><td>{$product}</td></tr>
            <tr><td>Account Holder:</td><td>{$accountHolder}</td></tr>
            <tr><td>Status:</td><td>{$status}</td></tr>
        </table>
        EOT;
    }

    return $html;
}


function consent_processor($variables) {

  $error = $variables['error'];

  return <<<EOF
  Title: {$error['title']}<br />
  Code: {$error['code']}<br />
  Detail: {$error['detail']}<br />
  Source: {$error['source']}<br /><br />
EOF; 

}

function consent_error_details_processor($variables) {

return <<<EOF
<h2>Error Report</h2>
Correlation ID: {$correlationId}<br /><br />
Errors:<br />
{$errorDetails}
EOF;
}

function main_template_processor($variables) {
    return <<<EOF
    <h2>Welcome: {$variables['user']->firstName}</h1>
    
    First name: {$variables['user']->firstName}<br /> 
    Last name: {$variables['user']->lastName}<br /> 
    Email: {$variables['user']->email}<br /> 
    
    Total banks connected: {$variables['user']->connections['count']}<br /> 
    Total accounts connected: {$variables['user']->accounts['count']}<br /> 
    
    Accounts:<br />
    <pr>
     {$variables['accounts']}
    </pre>
EOF;
}

// Initialize the template variable
$my_template_vars = [
  'error_detals' => [''],
];

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

            // Format the consent errors report for the template
            foreach ($errors as $error) {
                $error['source'] = print_r($error['source'], 1);
                $consent_errors_rendered .= consent_error_processor($error); 
            }

            $consent_errors_rendered = consent_error_details_processor([
                'correleation_id' => $consents['correlationId'],
                'error_details' => $consent_errors_rendered,
            ]);
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
            $processedAccounts = processAccountData($accounts);

            $main_content_rendered = main_template_processor([
                'user' => $user,
                'accounts' => generateAccountHTML($accounts),
                'errors' => $consent_errors_rendered ?? null, 
            ]);

        } else {
            $main_content_rendered = "Error fetching user details.";
        }

    } else {
        $main_content_rendered = "No consents found for the user.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basiq Consent Flow</title>
</head>
<body>

<form action="index.php" method="post">
    <button type="submit" name="connectBank">Get my user details from the remote BasiqAPI"</button>
</form>

<?php echo $main_content_rendered; ?>

</body>
</html>
