# Blog: BasiqVoyager - Consent UI Flow & Redirect URL Setup


In the ever-evolving world of fintech, integrating with platforms like Basiq can be a daunting task. The documentation, while comprehensive, often assumes a certain level of prior knowledge. As developers, we're no strangers to diving deep into documentation, piecing together information, and formulating a plan of action. After extensive research, we've managed to craft a PHP solution that aims to streamline the Basiq integration process. But as with all code, the real test lies in its execution. In this section of our blog, we'll walk you through our journey of understanding, the challenges we faced, and the PHP code we've formulated. It's time to roll up our sleeves and put our code to the test!

**3. Log of our journey:**

**a. Initial Understanding:**
- We began by examining the Basiq documentation to understand the flow of integrating with their platform.
- Identified what we initially comprehended the steps to be (the details evolved as we progressed). These steps included registering the application, configuring it, generating an API key, authenticating, and creating a user.

**b. Delving into the "Consent" Step:**
- The "Consent" step was initially perplexing because the documentation seemed to imply that after creating a user, there was an immediate need to retrieve their financial data. However, it wasn't clear how or when the user's explicit consent was obtained.
- [Basiq's Quickstart Guide](https://api.basiq.io/docs/quickstart-part-1) mentioned the need for consent but didn't delve into the specifics, which led to our initial confusion.
  
  > "Before you can retrieve a user's financial data, you first need to link to their financial institutions by creating a connection. This can only be done once a user has explicitly consented to share their data."
  
- After further exploration, we realized that after creating a user, they need to be redirected to the Basiq Consent UI to give their consent. This was a pivotal moment in our understanding.

**d. Muddles with "Consent":**
- Initially, there was confusion about where the consent data is stored and how to retrieve it. The Quickstart guide assumed prior knowledge about this step, which we didn't have at the outset.
- We had to delve deeper into the 'consent' documentation, specifically the [Consents Endpoint](https://api.basiq.io/reference#getconsents), to get clarity.
  
  > "Retrieve a list of consents for a user. A consent is created when a user connects an institution."
  
  This snippet clarified that a user's consents are stored against their user object in Basiq and can be retrieved using the API.

**e. PHP Implementation:**
- We used PHP's cURL functions to make API requests to Basiq. For example:
  ```php
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://au-api.basiq.io/users/$userId/consents");
  ```
  
**f. `index.php` Overview:**
- `index.php` is the main entry point for our application. Its primary purpose is to allow a user to check their consent status.
- Dependencies: The script depends on `getConsents.php` to retrieve the user's consents from Basiq.
- Data Requirements: The script requires the user's ID and the Application JWT token. These are injected directly into the script.
- Flow: When the "Check Consent Status" button is clicked, the script checks if the user has given any consents and displays the appropriate message.

**g. `getConsents.php` Overview:**
- This script contains the `getBasiqUserConsents` function, which retrieves the user's consents from Basiq.
- Interaction with `index.php`: The function can be called directly from `index.php` to check the user's consent status.
- Usage:
  - **CLI**: Run the script using `php getConsents.php [USER_ID] [JWT_TOKEN]`.
  - **Include in another PHP file**: Use `include 'getConsents.php';` and then call the function with the required parameters.

**h. Final Understanding:**
- We believe we've gained clarity on the importance of the "Consent" step in the Basiq integration flow.
- We have an untested idea of how to retrieve a user's consents using the Basiq API and reflect that in the PHP code.

Our untested code.

**1. `index.php`:**
```php
<?php
include 'getConsents.php';

$userId = 'YOUR_USER_ID'; // Replace with the actual user ID
$jwtToken = 'YOUR_APPLICATION_JWT_TOKEN'; // Replace with your Application JWT token

if (isset($_POST['connectBank'])) {
    $consents = getBasiqUserConsents($userId, $jwtToken);
    if (isset($consents['data']) && !empty($consents['data'])) {
        echo "User has given consent.";
        // Process the consents as needed
    } else {
        echo "No consents found for the user.";
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
    <button type="submit" name="connectBank">Check Consent Status</button>
</form>

</body>
</html>
```

**2. `getConsents.php`:**
```php
<?php

function getBasiqUserConsents($userId, $jwtToken) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://au-api.basiq.io/users/$userId/consents");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "Authorization: Bearer $jwtToken";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
        return null;
    }
    curl_close($ch);

    // Decode the result to get the consents
    return json_decode($result, true);
}
?>
```

**Next Steps**:
- The next logical step is to integrate this code into a live environment, test the flow, and ensure that the user's consents are correctly retrieved and processed.

As we wrap up this section, it's evident that the journey of integration is filled with twists and turns. The path from initial confusion to a clearer understanding has been enlightening, to say the least. But this is just the beginning. As we move forward, we'll continue to log our experiences, challenges, and solutions right here. So, stay tuned as we execute our plan, test our code, and delve deeper into the world of Basiq integration. Until next time, happy coding!


## Continuing Our Journey with Basiq's API

### Running the PHP Code:

Before diving into the Basiq dashboard, we first attempted to run the PHP code we had crafted. We were eager to see it in action and to verify if our understanding was correctly translated into code. However, as with many first attempts, we hit a snag.

1. **Executing the PHP Script**: We ran our PHP script, hoping to see a successful interaction with the Basiq API. I resolved a few issues wtih file paths and variables names, until I hit a "Route Not Found" from the API, this is where things got interesting for a while.

2. **Encountering the "Route Not Found" Error**: To our surprise, the script returned a "Route Not Found" error. This was puzzling, as we had followed the documentation closely.

3. **Discovering the Interactive API Tool**: In our quest to understand the error, we stumbled upon Basiq's [Interactive API Tool](https://api.basiq.io/reference/getconsents). This tool allows users to test API endpoints directly from the browser, which seemed like a perfect way to debug our issue.

4. **Testing with the Interactive API Tool**: Hoping to gain clarity, we tested the same endpoint using the Interactive API Tool. To our astonishment, we received the same "Route Not Found" error, indicating that the issue might not be with our code but with the API or its configuration.

### Generating the Consent Link via Basiq Dashboard:

Given the error, we decided to take a different approach. We did not have enough information to determine if the "Route not found" was
a legitimate response to retrieving consents that do not yet exist. It's abnormal behavior for an API to do so however it's possible. So, we need to test against a user that has consents, we need to create one manually. I navigated to the Basiq dashboard to manually generate a consent link.

1. **Accessing the Users Section**: We went to the users section of our Basiq application in the dashboard.

2. **Clicking on "Generate Link"**: In the top menu, we found and clicked on the "generate link" option.

3. **Receiving the Consent Link**: The dashboard provided us with a link: `https://connect.basiq.io/0b23510d-2638-44f8-bef1-b430ca3e2987`. We copied this link and opened it in a new browser tab.

### Walking Through the Consent Form:

With the consent link in hand, we proceeded to give our consent via the form.

1. **Opening the Consent Form**: Clicking on the generated link opened the Basiq consent form.

2. **Filling in Personal Details**: The form prompted us for some personal details. We filled these in, which triggered an SMS ID check for identity verification.

3. **Selecting the Bank**: After verifying our identity, the form presented us with a list of banks. We selected our bank from the available options.

4. **Entering Account Details**: Post bank selection, a new form appeared, asking for our bank account details. We entered the necessary information and hit the submit button.

5. **Encountering the "Access Denied" Error**: Instead of a confirmation, we were presented with an error message: "Connections not enabled. Error: access-denied." This was unexpected, and we deduced that the "Payments environment" setting in our Basiq application might be the cause.

### Reflections:

Our hands-on experience with the Basiq API and dashboard provided valuable insights. While we encountered errors, each one offered a learning opportunity. The "Route Not Found" error from both our script and the Interactive API Tool was particularly enlightening, suggesting potential issues on Basiq's end or with their CloudFront configuration.


### Next Steps:

Our journey isn't over. We aim to check the user's consents using the API next as it now likely has a consent attached. Even if we couldn't establish a bank connection, the user might still have given their consent. We're eager to see if this is reflected in the API's response.

## Continuing Our Journey with Basiq's API

### Blog: BasiqVoyager - Navigating API Challenges and Discovering CloudFront Issues

After our initial journey with the Basiq API, where we delved deep into the "Consent" step and tried to integrate it into our PHP application, we encountered several challenges. Here's a continuation of our experiences and the insights we've gathered:

#### Exploring the User's Dashboard

While navigating through the user's area of the Basiq dashboard, we made a significant discovery. We found that we could directly view and manage consents for a user. This feature allowed us to:

- View the status and scopes of any consents.
- Remove consents if needed.

This direct access provided us with a clearer picture of the user's interactions with the platform and their consent status.

#### Encountering the 403 Error

Our next step was to use the interactive API form provided by Basiq. Upon entering the user's ID, we were met with a 403 error. This error, which typically indicates a permissions issue, hinted at "insufficient rights to a resource." This led us to believe that our Application JWT access token might have expired. JWT tokens are time-sensitive, and their expiration can lead to such errors.

To address this, we used our `generate_and_output_token.php` script to generate a fresh JWT token, ensuring that our subsequent API requests would have the necessary permissions.

#### The Recurring "Route Not Found" Error

Even with a new JWT token, we faced the "Route not found for this API version." error again. This recurring issue was puzzling, especially since we were following the Basiq documentation closely.

## The Suspicion Around CloudFront

CloudFront, Amazon's content delivery network (CDN) service, came into the spotlight. If Basiq is using CloudFront for their API, any misconfigurations or issues with CloudFront could lead to the errors we were experiencing. The "Route not found" error, which is atypical for an API endpoint that should exist, suggested a potential issue with how CloudFront was routing the requests to the Basiq API.

Given this observation, we began to suspect that the root cause of our challenges might lie with CloudFront. It's possible that there's a misconfiguration on Basiq's end or that CloudFront is caching an older version of the API.

## Reflections and Next Steps

Our journey with the Basiq API has been filled with learning opportunities. Each challenge, from understanding the "Consent" step to navigating API errors, has provided us with valuable insights. The discovery around CloudFront, in particular, has given us a direction to explore further.

As we move forward, our plan is to:

- Reach out to Basiq's support with our findings to gain more clarity.
- Explore potential solutions or workarounds for the CloudFront issue.
- Continue to document our experiences, challenges, and solutions to provide a comprehensive guide for others navigating the Basiq integration.

## BasiqVoyager Integration - The Journey Continues

### Addressing the "Route not found for this API version" Error

Despite our best efforts, the "Route not found for this API version." error persisted. We initially thought that adding the `basiq-version` to the request headers would resolve the issue. However, even after including the version string in the header, the error remained.

### The User ID Mismatch

A crucial realization dawned upon us. The user for whom we had created consent was not the same user we were trying to retrieve consent for in our PHP script. This mismatch was likely a result of switching users when testing consent via the Basiq Dashboard. To address this, we updated the user ID in our `get_user_token.php` script.

### Generating a New Token

With the updated user ID in place, the next step was to generate a new token. We ran the script to generate a fresh token and saved it in the `token.txt` file. This file serves as a reference for our script to read the token.

### A Breakthrough!

After making these changes, we tested the integration again, and voilà! We received an actual result. The returned JSON was extensive and contained a wealth of information:

```json
{
  "type": "list",
  "size": 1,
  "data": [
    {
      "type": "consent",
      "id": "b90cb14e-e2bc-47a5-939d-9c9ac70a7c88",
      "created": "2023-08-05T16:08:38Z",
      "updated": "2023-08-05T16:08:38Z",
      "expiryDate": "2024-08-05T07:27:00Z",
      "origin": "user",
      "status": "active",
      "purpose": "...",
      ...
    }
  ]
}
```

### Double checking our assumptions

1. **'basiq-version: 2.0'**
    - I removed the basiq-version: 2.0 string from the header sent by `getBasiqUserConsents()` and confirm I can retieve a valid response now.

2. **[The Interactive API tool](https://api.basiq.io/reference/getconsents)**
    - I entered the User ID of the user and the newish Application JWT Access token to the form once more. I noticed this time that when I double clicked in the "Bearer/JST" box to select the existing value it did not highlight the entire string but rather identified characters in that token as an end of word, so a 'double click' > `ctrl+v` action was likely resulting in an invalid token in my previous attempts.

3. **Response for user's with no consents**
    - Having got both my PHP script and the Interactive API Tool to give valid responses, I grabbed the ID from the dashboard of the user with no consents, tested via the Interacgice API tool and was able to retrieve a response then too.
    ```json
    {
      "type": "list",
      "correlationId": "9db99f4a-a733-4237-a4e3-90adbf8dcf55",
      "data": [
        {
          "type": "error",
          "code": "access-denied",
          "title": "Access denied.",
          "detail": "",
          "source": null
        }
      ]
    }
    ``` 

### What's Next?

Our immediate next step is to analyze the content to help us understand the details of the consent and any other relevant information the JSON might hold.

[Here is the the first successful consent response](assets/first_successful_consent_response.json)
