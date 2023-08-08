<?php

$currentDirectory = __DIR__;

define('BASIQ_CURL_VERBOSE', FALSE);

// Read the token from token.txt
$token = trim(file_get_contents("{$currentDirectory}/token.txt"));


// Endpoint URL
$url = 'https://au-api.basiq.io/users'; // Change this to the correct endpoint for creating a user

// Data to be sent as part of the request
$data = [
    'email' => 'fred.jackson+BasiqVoyagerDevel@gmail.com',
    'mobile' => '+61400111222',
];

// Set up the cURL request
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$jsonData = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    // Add the API key as a Basic Authorization header
    'Authorization: Bearer ' . $token, // Use Bearer for token authorization
    'Content-Type: application/json',
    'basiq-version: 3.0',
]);

// Execute the cURL request
$response = curl_exec($ch);

// Enable verbose output for debugging
if (!empty(BASIQ_CURL_VERBOSE)) {
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $verbose = fopen('php://temp', 'w+');
    curl_setopt($ch, CURLOPT_STDERR, $verbose);
}

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Output verbose data for debugging
if (!empty(BASIQ_CURL_VERBOSE)) {
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    echo "Verbose information:\n", htmlspecialchars($verboseLog), "\n";
}

// Decode the response JSON to extract the user data
$responseData = json_decode($response, true);

// You now have the user data that you can use for further API calls
if ($responseData) {
    print_r($responseData);
} else {
    echo 'No user data received.';
}

?>
