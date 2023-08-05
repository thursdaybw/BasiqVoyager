<<<<<<< Updated upstream
# Status: BasiqVoyager - Phase 6 - Implementing Basiq API into the Web Application

In phase 5 we performed the first two steps of Basiq's "Quick" Guide: 


**Have an API key:** We have an API key for the Demo Application

**Authenticate:** Trade your new API key for an access token. The response will contain an access token which will allow you to make secure calls to the Basiq API. They expire every 60 minutes so it's recommended to store it globally and refresh 2-3 times an hour. For this quick start, the scope used is 'serveraccess'.

Authenticate was a pain in the butt.

Now we're ready to move on with "Create a user".

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
=======
# Phase 6 - Creating a User in Your Application via the PHP API

In this phase of the BasiqVoyager project, we successfully integrated the Basiq API into our PHP application to create a user. This process involved understanding the Basiq API's user creation process, writing a PHP script to send a POST request to the API, and debugging the script to ensure it worked correctly. 

## Understanding the Basiq API's User Creation Process

The first step was to understand the Basiq API's user creation process. According to the Basiq API documentation, creating a user involves sending a POST request to the `/users` endpoint with the user's email and mobile number in the request body. The API then returns a response indicating whether the user was successfully created or if there were any errors.

## Writing the PHP Script

With this understanding, we wrote a PHP script to send a POST request to the Basiq API. The script included the necessary cURL options to send a POST request to the `/users` endpoint, and it used the `json_encode` function to format the user data as a JSON object for the request body.

Here's the initial version of the script:

```php
// Data to be sent as part of the request
$data = [
    'email' => 'fred.jackson+somewhere-devel@gmail.com',
    'mobile' => '0612456897',
];

// ...

$jsonData = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    // Use the token for authorization
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json', // Change this to application/json
    'basiq-version: 2.0',
]);
```

## Debugging the PHP Script

After writing the script, we tested it by running it and checking the response from the API. This is where we encountered several bugs that we had to debug.

### Debugging the Authorization Token Error

The first bug was an "Invalid authorization token" error. This error occurred because the script was not correctly reading the token from `token.txt` and including it in the API requests. 

To fix this bug, we modified the script to read the token from `token.txt` and include it in the `Authorization` header of the API requests:

```php
// Read the token from token.txt
$token = trim(file_get_contents("{$currentDirectory}/token.txt"));

// ...

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    // Use the token for authorization
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json', // Change this to application/json
    'basiq-version: 2.0',
]);
```

### Debugging the Request Content Format Error

The next bug was an "Invalid request content" error. This error occurred because the script was using the `http_build_query` function to format the user data for the cURL request, which resulted in a URL-encoded string instead of a JSON object.

To fix this bug, we removed the `http_build_query` function and used the `json_encode` function to format the user data as a JSON object:

```php
$jsonData = json_encode($data);

curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
```

### Debugging the Mobile Number Format Error

The final bug was a "Provided mobile is in bad format" error. This error occurred because the mobile number was not in the international format that the Basiq API expects.

To fix this bug, we modified the script to format the mobile number in the international format:

```php
// Data to be sent as part of the request
$data = [
    'email' => 'fred.jackson+somewhere-devel@gmail.com',
    'mobile' => '+61400111222', // Example mobile number in the correct format
];

// ...
```

## Conclusion

After debugging these issues, we tested the script again and it worked correctly, creating a user in the application via the Basiq API. This phase of the project was a great exercise in API integration and debugging, and it brought us one step closer to completing the BasiqVoyager project. In the next phase, we'll continue to build on this foundation and further enhance the application's functionality.
>>>>>>> Stashed changes
