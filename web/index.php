<?php

// Include the config file for API key and other configurations
require_once(dirname(__FILE__) . '/../config.php');


// Check if the token is present in the request
if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    // If the token is not present, retrieve it from the previously generated file
    $token = file_get_contents(dirname(__FILE__) . '/../user_token.txt');

}

// If the token is still not found, exit with an error message
if (!isset($token)) {
    echo "Error: Token not found!";
    exit;
}

// Set up the cURL request to Basiq's API using the token
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://au-api.basiq.io/consent');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'basiq-version: 3.0'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// Decode the response
$responseData = json_decode($response, true);

// Check if the consent URL is present in the response
if (isset($responseData['consent_url'])) {
    $consentUrl = $responseData['consent_url'];
    // Redirect the user to the consent URL
    header("Location: $consentUrl");
    exit;
} else {
    echo "Failed to retrieve consent URL.";
    exit;
}

?>
