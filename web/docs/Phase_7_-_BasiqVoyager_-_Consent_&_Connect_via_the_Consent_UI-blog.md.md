# Blog: BasiqVoyager - Consent & Connect via the Consent UI

In the ongoing development of BasiqVoyager, we've reached a pivotal phase: the integration of the Basiq Consent UI. With our API key already secured, we're well-prepared for this next step. Here's a detailed breakdown of the process:

## Preparing the Groundwork: The Callback URL

First and foremost, determine a callback URL for your application. This URL will serve as the landing point post the user's consent process with Basiq. It's essential to ensure that this endpoint is equipped to handle the token provided by Basiq.

Since we are using the lando development environment, we can use the root of `http://basiqvoyager.lndo.site/` as the callback URL.
This callback URL has been saved in the Redirect URL field on the [Customise UI](https://dashboard.basiq.io/customise-ui) of the dashboard for this appication.

## Initiating the Consent UI

- Utilize the reference CURL command to create a PHP script that interacts with Basiq's API. Remember to include your API key for authentication.

```bash
curl --location --request POST 'https://au-api.basiq.io/token' \
--header 'Authorization: Basic [YOUR-API-KEY]' \
--header 'Content-Type: application/x-www-form-urlencoded' \
--header 'basiq-version: 3.0' \
--data-urlencode 'scope=CLIENT_ACCESS' \
--data-urlencode 'userId=1234567-1234-1234-1234-123456781234'
```

- Upon successful communication, Basiq will provide a URL for the Consent UI. This URL can be used to redirect users for the consent process.

## User Interaction Process

- Users will be directed to the Consent UI, where they'll select their bank and input their credentials.
- Upon successful consent, Basiq will redirect them back to your specified callback URL, providing a token in the process.

## Handling the Token

- Capture the token at the callback endpoint.
- This token is essential as it grants access to the user's financial data.

## Data Retrieval

- Use the token to interact with Basiq's API and retrieve relevant financial data, such as the account balance.

## Storing and Displaying Data

- Depending on your application's architecture, you might opt to store this data for subsequent use or present it to the user immediately.

It's imperative to prioritize the security and privacy of user data. Handle tokens with utmost care and consider implementing secure methods for their storage and transmission.

With the foundational knowledge of PHP, this integration process should be straightforward. However, should you encounter any challenges or have further questions, please don't hesitate to reach out.

---

Understood. Let's outline the two PHP scripts:

1. **get_user_token.php**:
   - This script will have user data hardcoded, similar to `create_user.php`.
   - It will interact with Basiq's API to initiate the consent process and retrieve the user's access token.
   - Once the token is retrieved, it will be stored in `user_token.txt`.

2. **index.php**:
   - This script will serve as the callback URL.
   - It will be hosted at `http://basiqvoyager.lndo.site/`.
   - Upon successful user consent via Basiq's Consent UI, Basiq will redirect to this URL, passing along the token.
   - The script can then capture this token and perform any subsequent actions, such as storing it or using it to fetch financial data.

Here's a basic structure for both:

**get_user_token.php**:
```php
<?php

// Data to be sent as part of the request
$data = [
    'email' => 'fred.jackson+BasiqVoyagerDevel@gmail.com',
    'mobile' => '+61400111222',
];

// Interact with Basiq's API to initiate the consent process
// ... (API interaction code)

// Retrieve the user's access token
// ... (token retrieval code)

// Store the token in user_token.txt
file_put_contents('user_token.txt', $token);

?>
```

**index.php**:
```php
<?php

// Or appropriate method to capture the token
$userSpecificToken = get_short_lived_user_specific_token_from_basiq_api();

?>

<?php if (!$userConsentIsGiven) { ?>

<!-- The form to trigger the user's consent process -->
<form action="https://consent.basiq.io/home" method="get">
    <input type="hidden" name="token" value="<?php echo $userSpecificToken; ?>">
    <input type="submit" value="Connect to Bank">
</form>

<?php } else { ?>

<?php
// Optionlly retrieve user account data to display.
?>

<h3>Success!</h3>

<? } ?>

```

This is a basic structure to get you started. You'll need to fill in the details, especially the API interaction parts, based on Basiq's documentation and your specific requirements. 
