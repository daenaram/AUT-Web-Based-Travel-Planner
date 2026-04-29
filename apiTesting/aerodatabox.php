<?php

$apiKey = "c30cc247bcmshe4978b3cb2e1860p1fe7acjsn17542c019812";

// Example: Departures from Auckland Airport (AKL)
$url = "https://aerodatabox.p.rapidapi.com/flights/airports/iata/AKL/2026-05-10T00:00/2026-05-10T12:00";

// Initialize cURL
$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,

    // SSL fix (for local dev)
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,

    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: aerodatabox.p.rapidapi.com",
        "x-rapidapi-key: $apiKey"
    ],
]);

$response = curl_exec($ch);

// Error handling
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch);
    exit;
}

curl_close($ch);

// Decode JSON
$data = json_decode($response, true);

// DEBUG (optional)
echo "<pre>";
print_r($data);
echo "</pre>";

// Display results
if (!empty($data['departures'])) {

    echo "<h2>Departing Flights (AKL)</h2>";

    foreach ($data['departures'] as $flight) {
        echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";

        echo "<strong>Flight:</strong> " . ($flight['number'] ?? 'N/A') . "<br>";
        echo "<strong>Airline:</strong> " . ($flight['airline']['name'] ?? 'N/A') . "<br>";
        echo "<strong>Destination:</strong> " . ($flight['arrival']['airport']['name'] ?? 'N/A') . "<br>";
        echo "<strong>Departure Time:</strong> " . ($flight['departure']['scheduledTime']['local'] ?? 'N/A') . "<br>";

        echo "</div>";
    }

} else {
    echo "No flight data found or invalid response.";
}

?>