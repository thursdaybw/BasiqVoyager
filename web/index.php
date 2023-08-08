<?php


require_once __DIR__  . "/../config.php";
require_once __DIR__  . "/../vendor/autoload.php"; // Include this if your autoload file is in the vendor directory

use App\HttpClient\GuzzleHttpClient;
use App\Api\BasiqApi;
use App\Service\ConsentService;

$jwtToken = trim(file_get_contents(__DIR__.'/../token.txt'));
$httpClient = new GuzzleHttpClient($jwtToken);
$api = new BasiqApi($httpClient);
$consentService = new ConsentService($httpClient);

$userId = BASIC_TEST_USER_ID;

function extractUserAccountLinksFromUserObject($userObject) {
    $accountLinks = array();

    foreach ($userObject->accounts->data as $account) {
        $accountLinks[$account->id] = $account->links->self;
    }

    return $accountLinks;
}

function formatAccountData($accounts) {
    $html = '';
    foreach ($accounts as $account) {
        $name = $account->name ?? '';
        $accountNo = $account->accountNo ?? '';
        $balance = $account->balance ?? '';
        $availableFunds = $account->availableFunds ?? '';
        $lastUpdated = $account->lastUpdated ?? '';
        $creditLimit = $account->creditLimit ?? '';
        $type = $account->type ?? '';
        $product = $account->class->product ?? '';
        $accountHolder = $account->accountHolder ?? '';
        $status = $account->status ?? '';

        $lendingRates = '';
        if (!empty($account->meta->lendingRates)) {
            $lendingRates = '<ul style="list-style-type: none;">';
            foreach ($account->meta->lendingRates as $rate) {
                $lendingRates .= "<li>Type: {$rate->lendingRateType}</li>";
                $lendingRates .= "<li>Rate: {$rate->rate}</li>";
                $lendingRates .= "<li>Frequency: {$rate->applicationFrequency}</li>";
            }
            $lendingRates .= '</ul>';
        }

        $loan = '';
        if (!empty($account->meta->loan)) {
            $loan = "<ul style='list-style-type: none;'>
                        <li>Repayment Type: {$account->meta->loan->repaymentType}</li>
                        <li>Min Instalment Amount: {$account->meta->loan->minInstalmentAmount}</li>
                    </ul>";
        }

        $creditCard = '';
        if (!empty($account->meta->creditCard)) {
            $creditCard = "<ul style='list-style-type: none;'>
                            <li>Min Payment Amount: {$account->meta->creditCard->minPaymentAmount}</li>
                            <li>Payment Due Amount: {$account->meta->creditCard->paymentDueAmount}</li>
                            <li>Payment Due Date: {$account->meta->creditCard->paymentDueDate}</li>
                        </ul>";
        }

        $html .= <<<EOT
        <table class="account" style="margin-top: 50px">
            <tr><th colspan="2" style="text-align: left;">$name</th></tr>
            <tr><td>Account No:</td><td>$accountNo</td></tr>
            <tr><td>Balance:</td><td>$balance</td></tr>
            <tr><td>Available Funds:</td><td>$availableFunds</td></tr>
            <tr><td>Last Updated:</td><td>$lastUpdated</td></tr>
            <tr><td>Credit Limit:</td><td>$creditLimit</td></tr>
            <tr><td>Type:</td><td>$type</td></tr>
            <tr><td>Product:</td><td>$product</td></tr>
            <tr><td>Account Holder:</td><td>$accountHolder</td></tr>
            <tr><td>Status:</td><td>$status</td></tr>
            <tr><td style="vertical-align: top;">Lending Rates:</td><td>$lendingRates</td></tr>
            <tr><td style="vertical-align: top;">Loan:</td><td>$loan</td></tr>
            <tr><td style="vertical-align: top;">Credit Card:</td><td>$creditCard</td></tr>
        </table>
        EOT;
    }
    return $html;
}

// Initialize the template variable
$my_template_var = "";

if (isset($_POST['connectBank'])) {
    $consents = $consentService->getBasiqUserConsents($userId);

    if (isset($consents['data']) && !empty($consents['data'])) {
        $user = $api->fetchUser($userId);

        // Check for errors in the 'data' array
        $errors = array_filter($consents['data'], function($item) {
            return isset($item['type']) && $item['type'] === 'error';
        });

        if (!empty($errors)) {
            // Log the error for debugging
            error_log("Error found in the 'data' key of the response.");

            // Format the error report for the template
            $correlationId = $consents['correlationId'];
            $errorDetails = "";
            foreach ($errors as $error) {
                $error['source'] = print_r($error['source'], 1);
                $errorDetails .= <<<EOF
Title: {$error['title']}<br />
Code: {$error['code']}<br />
Detail: {$error['detail']}<br />
Source: {$error['source']}<br /><br />
EOF;
            }

            $my_template_var = <<<EOF
<h2>Error Report</h2>
Correlation ID: {$correlationId}<br /><br />
Errors:<br />
{$errorDetails}
EOF;
        }
        elseif ($userObject !== null) {

            $account_links = extractUserAccountLinksFromUserObject($userObject);
            $accounts = [];
            foreach ($account_links as $account_link) {
               $accounts[] = json_decode($account = $api->fetchUserAccount($account_link));
               $account_links_output = "Account link: " . print_r($account_link, 1) . "<br />";
            }

            $accounts_template_var = formatAccountData($accounts); 

            $my_template_var = <<<EOF
<h2>Welcome: {$userObject->firstName}</h1>

First name: {$userObject->firstName}<br /> 
Last name: {$userObject->lastName}<br /> 
Email: {$userObject->email}<br /> 

Total banks connected: {$userObject->connections->count}<br /> 
Total accounts connected: {$userObject->accounts->count}<br /> 

Accounts:<br />
<pr>
 $accounts_template_var
</pre>

<!--
Account links:<br />
 $account_links_output
-->
EOF;
        } else {
            $my_template_var = "Error fetching user details.";
        }
    } else {
        $my_template_var = "No consents found for the user.";
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

<?php echo $my_template_var; ?>

</body>
</html>
