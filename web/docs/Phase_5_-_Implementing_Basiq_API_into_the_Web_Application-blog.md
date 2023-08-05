# Status: BasicVoyager - Implementing Basiq API into the Web Application

Before we start, we had some more work to do:

So, we're at this point where we need a solid IDE to make our development process smoother. We could've gone with PHPStorm, it's familiar territory. But, considering the React learning curve and the open-source charm, Visual Studio Code seems like the way to go. Yes, it's a Microsoft product, but let's not hold that against it. We've got a plan in place - update the system packages and then install Visual Studio Code. We're yet to get started, but we'll keep you posted on the journey.
- Sat 05 Aug 2023 20:12:30 AEST See: [Virtual Studio Code](rabbits/Virtual_Studio_Code.md)

---

Sure, here's a summary of the guide from the [Basiq API Quickstart Part 1](https://api.basiq.io/docs/quickstart-part-1)

1. **Have an API key**: We have an API key for the Demo Application

2. **Authenticate**: Trade your new API key for an access token. The response will contain an access token which will allow you to make secure calls to the Basiq API. They expire every 60 minutes so it's recommended to store it globally and refresh 2-3 times an hour. For this quick start, the scope used is 'serveraccess'.

Here's a sample code snippet for authentication:

```bash
curl --location --request POST 'https://au-api.basiq.io/token' \
  --header 'Authorization: Basic $YOUR_API_KEY' \
  --header 'Content-Type: application/x-www-form-urlencoded' \
  --header 'basiq-version: 2.0' \
  --data-urlencode 'scope=SERVER_ACCESS'
```

3. **Create a user**: Creating a user gives you a bucket to store all your financial data. Upon successful creation of a user, you will receive a user ID. With that and the access token you created earlier, you have everything you need to start creating and fetching financial data.

Here's a sample code snippet for creating a user:

```bash
curl --location --request POST 'https://au-api.basiq.io/users' \
  --header 'Authorization: Bearer $YOUR_ACCESS_TOKEN' \
  --header 'Accept: application/json' \
  --header 'Content-Type: application/json' \
  --data-raw '{
    "email": "max@hooli.com",
    "mobile": "+614xxxxxxxx"
  }'
```

We need to turn this into PHP code. I have tried this and am having some issues.


## Debugging the Basiq API Connection: A Deeper Dive

As we delved deeper into the issue of connecting to the Basiq API, we enhanced our PHP script to provide more detailed information about the cURL request being made. This was achieved by enabling verbose output for debugging purposes. Here's the relevant code snippet:

```php
// Enable verbose output for debugging
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);
```

This code tells cURL to output detailed information about the request, which is then captured in a temporary stream. After the cURL request is executed, we rewind the stream and output its contents:

```php
// Output verbose data for debugging
rewind($verbose);
$verboseLog = stream_get_contents($verbose);
echo "Verbose information:\n", htmlspecialchars($verboseLog), "\n";
```

This verbose output confirmed that our Authorization header was being sent correctly. Here's the relevant section of the verbose output:

```php
> POST /token HTTP/2
Host: au-api.basiq.io
accept: */*
authorization: Basic ************************
content-type: application/x-www-form-urlencoded
basiq-version: 2.0
content-length: 19
```

Despite this, the server was still returning a `400 Bad Request` response. The error message was contained within the JSON response from the server. We can extract this error message with the following PHP code:

```php
$responseData = json_decode($response, true);
$errorDetail = $responseData['data'][0]['detail'] ?? null;
echo 'Error detail: ' . $errorDetail;
```

This code decodes the JSON response and extracts the `detail` field from the first item in the `data` array, which contains the error message. In our case, the error message was "Invalid authorization header".

Despite our best efforts, the issue remains unresolved. We're considering several possibilities, including issues with the API key activation, permissions, or type. We're also considering reaching out to Basiq support for further assistance. This experience underscores the importance of a methodical approach to debugging and the value of detailed logging and error reporting.

## Debugging the Basiq API Connection - Resolution

After a series of debugging steps and hypotheses, we found the root cause of the issue. It turned out that the API key was already base64 encoded and we were inadvertently encoding it again in our PHP script. 

The line of code that was causing the issue was:

```php
'Authorization: Basic ' . base64_encode($apiKey . ':'),
```

We were base64 encoding the API key again before sending it in the Authorization header. However, since the API key was already base64 encoded, this additional encoding was causing the server to reject our request with an "Invalid authorization header" error.

The solution was to use the API key directly in the Authorization header, without encoding it again:

```php
'Authorization: Basic ' . $apiKey,
```

After making this change, the PHP script was able to successfully connect to the Basiq API and we received a valid access token in response.

This experience has underscored the importance of understanding the data we're working with. In this case, knowing that the API key was already base64 encoded would have saved us from the confusion. However, it's all part of the learning process and we're glad to have resolved the issue. We'll continue to share our experiences and learnings as we progress with the integration of the Basiq API into our web application.


Here is our resulting PHP file

web/generate_and_output_token.php
```
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
    'basiq-version: 2.0',
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
```

config.php
```
<?php
// Define your Basiq API key here
define('BASIQ_API_KEY', '********');

// You can define other configuration settings here if needed
// define('ANOTHER_SETTING', 'some_value');
?>
```
