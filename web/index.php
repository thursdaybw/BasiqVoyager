<?php
include '../getConsents.php';

require_once __DIR__  . "/../config.php";

$userId = BASIC_TEST_USER_ID;

// Read the token from token.txt
$path = __DIR__.'/../token.txt'; 
$jwtToken = trim(file_get_contents($path));

$my_template_var = ""; // Initialize the template variable

function fetchUser($userId, $jwtToken) {
    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    $url = 'https://au-api.basiq.io/users/' . $userId;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return the transfer as a string
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'accept: application/json',
        'authorization: Bearer ' . $jwtToken
    ));

    // Execute cURL session and fetch the result
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Return the response
    return $response;
}

function fetchUserAccounts($userId, $jwtToken) {
    // Reach out to Basiq API to retrieve a list of the user's accounts
    $ch = curl_init();
    $url = "https://au-api.basiq.io/users/$userId/accounts";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $headers = array();
    $headers[] = "Authorization: Bearer $jwtToken";
    $headers[] = 'basiq-version: 3.0';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $accountResult = curl_exec($ch);
    curl_close($ch);
    
    return $accountResult;
}

if (isset($_POST['connectBank'])) {
    $consents = getBasiqUserConsents($userId, $jwtToken);
    if (isset($consents['data']) && !empty($consents['data'])) {
        //$accountResult = fetchUserAccounts($userId, $jwtToken);
        $accountResult = json_decode(fetchUser($userId, $jwtToken));
        $accountObject = print_r($accountResult, 1);
        $my_template_var = <<<EOF
<h2>Welcome: {$accountResult->firstName}</h1>

First name: {$accountResult->firstName}<br /> 
Last name: {$accountResult->lastName}<br /> 
Email: {$accountResult->email}<br /> 

Total banks connected: {$accountResult->connections->count}<br /> 
Total accounts connected: {$accountResult->accounts->count}<br /> 
EOF;

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
    <button type="submit" name="connectBank">Get my user details from the remote "BasiqAPI"</button>
</form>

<?php echo $my_template_var; ?>

</body>
</html>
