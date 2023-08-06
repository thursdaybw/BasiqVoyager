<?php
include '../getConsents.php';

require_once __DIR__  . "/../config.php";

$userId = BASIC_TEST_USER_ID;

// Read the token from token.txt
$path = __DIR__.'/../token.txt'; 
$jwtToken = trim(file_get_contents($path));

if (isset($_POST['connectBank'])) {
    $consents = getBasiqUserConsents($userId, $jwtToken);
    if (isset($consents['data']) && !empty($consents['data'])) {
        echo "User has given consent.<br />\n";
        // Process the consents as needed
    } else {
        echo "No consents found for the user.<br />\n";
    }
    echo "<pre>\n";
    print_r(json_encode($consents, JSON_PRETTY_PRINT));
    echo "</pre>\n";
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