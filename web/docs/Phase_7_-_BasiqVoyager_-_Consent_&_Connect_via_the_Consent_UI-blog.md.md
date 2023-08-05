# Phase 7 - BasiqVoyager - Consent & Connect via the Consent UI

In today's adventure with the Basiq API, we embarked on the mission to generate a user token for initiating the consent process. PHP, being our trusty tool, was at the forefront of this journey.

## The Initial Approach

We started with a straightforward PHP script that aimed to generate a user token by making a POST request to the Basiq API. The initial code looked something like this:

```php
// Initial code block...
```

## Challenge 1: Invalid Request Body

Our first attempt was met with an error indicating an "Invalid request body". The verbose logs from cURL provided insights into the request and response, but the error message was a bit vague.

### Resolution:

After diving into the Basiq documentation, we realized that the `scope` and `userid` parameters were crucial. We initially set the `scope` to `SERVER_ACCESS`, thinking our PHP script, being server-side, would fit this category. However, this led us to our next challenge.

## Challenge 2: Invalid Scope Specified

Despite our best efforts, we were met with another error, this time indicating an "Invalid scope specified". The error pointed towards the `scope` parameter in the request body.

### Resolution:

A deeper dive into the Basiq documentation revealed that for generating a user token, the `scope` should be set to `CLIENT_ACCESS`. This was a bit counterintuitive since our PHP script was server-side, but it made sense in the context of Basiq's API expectations. The API expects the token generation request to come from a browser, hence the name "CLIENT_ACCESS".

## The Final Code

After making the necessary adjustments, our final code looked like this:

```php
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
    'userid' => 'f16d0fed-ee64-4830-adb9-af153b32f78e'  // Replace with the correct userid value
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

// Enable verbose mode
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
    exit;
}

// If verbose mode is enabled, print the verbose output
if ($verbose) {
    rewind($verbose);
    $verboseLog = stream_get_contents($verbose);
    echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
}

curl_close($ch);

// Decode the response
$responseData = json_decode($response, true);

// Print the response
echo "<pre>";
print_r($responseData);
echo "</pre>";

// Check if the token and redirect URL are present in the response
if (isset($responseData['token']) && isset($responseData['redirect_url'])) {
    $token = $responseData['token'];
    $redirectUrl = $responseData['redirect_url'];

    // Store the token and redirect URL in user_token.txt
    $fileContent = "token={$token}\nredirect_url={$redirectUrl}";
    file_put_contents('user_token.txt', $fileContent);
} else {
    echo "Failed to retrieve token or redirect URL.";
    exit;
}

?>]
```

## Conclusion

Today's journey with the Basiq API was filled with challenges and learning opportunities. We faced errors, dove deep into documentation, and came out victorious with a working solution. The key takeaways from this experience are:

1. Always refer to the official documentation when in doubt.
2. Understand the context in which the API expects requests. In our case, even though our script was server-side, the Basiq API expected a client-side context for token generation.
3. Verbose logs are invaluable. They provide insights into the request and response flow, helping diagnose issues.

We hope this post helps others who might face similar challenges with the Basiq API or any other API integration. Remember, every error is a stepping stone to a solution. Happy coding!
