<?php
include '../getConsents.php';

require_once __DIR__  . "/../config.php";

$userId = BASIC_TEST_USER_ID;

// Read the token from token.txt
$path = __DIR__.'/../token.txt'; 
$jwtToken = trim(file_get_contents($path));

$my_template_var = ""; // Initialize the template variable

function fetchUserAccounts($userId, $jwtToken) {
    // Reach out to Basiq API to retrieve a list of the user's accounts
    $ch = curl_init();
    $url = "https://au-api.basiq.io/users/$userId/accounts";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $headers = array();
    $headers[] = "Authorization: Bearer $jwtToken";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $accountResult = curl_exec($ch);
    curl_close($ch);
    
    return $accountResult;
}

if (isset($_POST['connectBank'])) {
    $consents = getBasiqUserConsents($userId, $jwtToken);
    print_r($consents);
    if (isset($consents['data']) && !empty($consents['data'])) {
        $accountResult = fetchUserAccounts($userId, $jwtToken);
        $my_template_var = "<pre>" . json_encode(json_decode($accountResult), JSON_PRETTY_PRINT) . "</pre>";
    } else {
        $my_template_var = "No consents found for the user.";
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

<?php echo $my_template_var; ?>

</body>
</html>
