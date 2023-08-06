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
