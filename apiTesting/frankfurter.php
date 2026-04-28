<?php
$url = "https://api.frankfurter.app/latest?from=USD&to=NZD";

$response = file_get_contents($url);

if ($response === FALSE) {
    echo "Error fetching API";
} else {
    $data = json_decode($response, true);
    echo "NZD Rate: " . $data['rates']['NZD'];
}
?>