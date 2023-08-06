# Blog: BasiqVoyager - Consent UI Flow & Redirect URL Setup


In the ever-evolving world of fintech, integrating with platforms like Basiq can be a daunting task. The documentation, while comprehensive, often assumes a certain level of prior knowledge. As developers, we're no strangers to diving deep into documentation, piecing together information, and formulating a plan of action. After extensive research, we've managed to craft a PHP solution that aims to streamline the Basiq integration process. But as with all code, the real test lies in its execution. In this section of our blog, we'll walk you through our journey of understanding, the challenges we faced, and the PHP code we've formulated. It's time to roll up our sleeves and put our code to the test!

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

**3. Log of our journey:**

**a. Initial Understanding:**
- We started by examining the Basiq documentation to understand the flow of integrating with their platform.
- Identified steps like registering the application, configuring it, generating an API key, authenticating, and creating a user.

**b. Diving into Consent:**
- We delved into the "Consent" step, which was initially confusing.
- Realized that after creating a user, they need to be redirected to the Basiq Consent UI to give their consent.
- This consent is crucial before accessing a user's financial data.

**c. PHP Implementation:**
- Created PHP scripts (`index.php` and `getConsents.php`) to reflect the logic flow.
- `index.php` serves as the main entry point where a user can check their consent status.
- `getConsents.php` contains the function to retrieve a user's consents from Basiq.

**d. Muddles with "Consent":**
- Initially, there was confusion about where the consent data is stored and how to retrieve it.
- After diving deeper into the Basiq documentation, we found that consent data is stored against the user's object in Basiq.
- We can retrieve this data using the Basiq API by making a GET request to the `/users/{userId}/consents` endpoint.

**e. Code Implementation:**
- Used PHP's cURL functions to make API requests to Basiq.
- The `getBasiqUserConsents` function in `getConsents.php` retrieves the user's consents.
- In `index.php`, when the "Check Consent Status" button is clicked, the script checks if the user has given any consents and displays the appropriate message.

**f. Documentation & References:**
- Made extensive use of Basiq's official documentation to understand the platform's flow and endpoints.
- Used the provided cURL commands as a reference to implement the PHP code.

**g. Final Understanding:**
- Gained clarity on the importance of the "Consent" step in the Basiq integration flow.
- Understood how to retrieve a user's consents using the Basiq API and reflect that in the PHP code.

As we wrap up this section, it's evident that the journey of integration is filled with twists and turns. The path from initial confusion to a clearer understanding has been enlightening, to say the least. But this is just the beginning. As we move forward, we'll continue to log our experiences, challenges, and solutions right here. So, stay tuned as we execute our plan, test our code, and delve deeper into the world of Basiq integration. Until next time, happy coding!
