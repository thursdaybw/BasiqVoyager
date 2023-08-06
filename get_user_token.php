<?php

// Include the config file for API key and other configurations
require_once('config.php');

// Data to be sent as part of the request
$data = [
    /** 
     * CLIENT_ACCESS is required for user token generation.
     * 
     * BasiqAPI expects a token generation request to come from
     * a browser, hence the name "CLIENT_ACCESS", but for our
     * purposes we are performing the client action ahead of time,
     * client side.
     */
    'scope' => 'CLIENT_ACCESS', // or 'SERVER_ACCESS' depending on your use case
    'userid' => BASIC_TEST_USER_ID,
];

$apiKey = BASIQ_API_KEY;

// Set up the cURL request to Basiq's API
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://au-api.basiq.io/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . $apiKey,
    'Content-Type: application/x-www-form-urlencoded',
    'basiq-version: 3.0'
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

curl_close($ch);

// Decode the response
$responseData = json_decode($response, true);

// Check if the token and redirect URL are present in the response
if (isset($responseData['access_token'])) {
    // Store the token in user_token.txt
    print_r($responseData);
} else {
    echo "Failed to retrieve token or redirect URL.";
    exit;
}

?>