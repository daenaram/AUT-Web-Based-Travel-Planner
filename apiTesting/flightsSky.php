<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://flights-sky.p.rapidapi.com/web/flights/details?flightId=12345",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    
    // 🔴 SSL fix
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,

    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "x-rapidapi-host: flights-sky.p.rapidapi.com",
        "x-rapidapi-key: YOUR_API_KEY_HERE"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #: " . $err;
} else {
    echo $response;
}
?>