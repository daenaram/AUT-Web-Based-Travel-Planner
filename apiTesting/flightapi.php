<?php

$apiKey = "c30cc247bcmshe4978b3cb2e1860p1fe7acjsn17542c019812";
$url = "https://api.flightapi.io/onewaytrip/$apiKey/AKL/SYD/2026-05-10/1/0/0/Economy/USD";

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,

    // SSL fix
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
]);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

// DEBUG: See raw response
echo "<h3>Raw API Response:</h3>";
echo "<pre>";
print_r($data);
echo "</pre>";

// Try to display flights
if (!empty($data)) {

    echo "<h2>Flight Results</h2>";

    // Loop through whatever structure exists
    foreach ($data as $key => $value) {

        if (is_array($value)) {
            foreach ($value as $flight) {

                if (is_array($flight)) {
                    echo "<div style='border:1px solid #ccc; margin:10px; padding:10px;'>";

                    echo "Airline: " . ($flight['airline'] ?? 'N/A') . "<br>";
                    echo "Price: " . ($flight['price'] ?? 'N/A') . "<br>";

                    echo "</div>";
                }
            }
        }
    }

} else {
    echo "No data returned from API.";
}

?>