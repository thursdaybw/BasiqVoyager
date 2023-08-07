<?php

function getBasiqUserConsents($userId, $jwtToken) {

    $ch = curl_init();

    // Store URL in variable so we can print as is.
    $url = "https://au-api.basiq.io/users/$userId/consents";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

    $headers = array();
    $headers[] = "Authorization: Bearer $jwtToken";
    $headers[] = "basiq-version: 3.0";
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