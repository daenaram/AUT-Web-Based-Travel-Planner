<?php
// 1. Set Timezone to Auckland
date_default_timezone_set('Pacific/Auckland');

// 2. USE TODAY'S DATE (The free tier rarely allows searching months in advance)
$start = date('Y-m-d\TH:00', strtotime('now')); 
$end = date('Y-m-d\TH:00', strtotime('+12 hours'));

$apiKey = "c30cc247bcmshe4978b3cb2e1860p1fe7acjsn17542c019812";
$url = "https://rapidapi.com";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false, 
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: ://rapidapi.com",
        "x-rapidapi-key: $apiKey"
    ],
]);

$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Auckland Live Departures</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f4f7f6; }
        .container { max-width: 900px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 12px; text-align: left; }
        th { background: #007bff; color: white; }
        .debug { background: #222; color: #0f0; padding: 15px; margin-top: 20px; border-radius: 5px; font-family: monospace; overflow: auto; max-height: 300px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Auckland Departures (Next 12 Hours)</h2>
    <p>Search Range: <strong><?= $start ?></strong> to <strong><?= $end ?></strong></p>

    <?php if (!empty($data['departures'])): ?>
        <table>
            <tr>
                <th>Flight</th>
                <th>Airline</th>
                <th>Destination</th>
                <th>Time</th>
            </tr>
            <?php foreach ($data['departures'] as $flight): ?>
            <tr>
                <td><?= htmlspecialchars($flight['number'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($flight['airline']['name'] ?? 'N/A') ?></td>
                <td>
                    <?php 
                        // Updated path for Destination Name
                        echo htmlspecialchars(
                            $flight['arrival']['airport']['name'] 
                            ?? $flight['destination']['name'] 
                            ?? $flight['destination']['municipalityName'] 
                            ?? 'N/A'
                        ); 
                    ?>
                </td>
                <td>
                    <?php 
                        $t = $flight['movement']['scheduledTime']['local'] ?? $flight['departure']['scheduledTimeLocal'] ?? null;
                        echo $t ? date('h:i A', strtotime($t)) : 'N/A';
                    ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No flights found. If the debug box below is empty, your API key may have expired or reached its daily limit.</p>
    <?php endif; ?>

    <div class="debug">
        <strong>RAW API DATA:</strong><br>
        <pre><?php print_r($data); ?></pre>
    </div>
</div>

</body>
</html>
