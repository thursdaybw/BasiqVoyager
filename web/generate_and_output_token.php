<?php
$currentDirectory = __DIR__;

define('BASIQ_CURL_VERBOSE', FALSE);

// Config contains our define('BASIQ_API_KEY', '********');
// config.php is outside the webroot, so it keeps the API Key safe.
// Do not commit config.php to your repo.
require_once("{$currentDirectory}/../config.php");

$apiKey = BASIQ_API_KEY;

// Endpoint URL
$url = 'https://au-api.basiq.io/token';

// Data to be sent as part of the request
$data = [
    'scope' => 'SERVER_ACCESS', // Use SERVER_ACCESS for full access
];

// Set up the cURL request
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$httpQueryResult = http_build_query($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $httpQueryResult);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    // Add the API key as a Basic Authorization header
    'Authorization: Basic ' . $apiKey,
    'Content-Type: application/x-www-form-urlencoded',
    'basiq-version: 3.0',
]);

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

// Decode the response JSON to extract the access token
$responseData = json_decode($response, true);

$accessToken = $responseData['access_token'] ?? null;

// You now have the access token that you can use for further API calls
if ($accessToken) {
    echo $accessToken;
} else {
    echo 'No access token received.';
}
?>
