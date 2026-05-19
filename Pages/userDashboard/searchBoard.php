<?php
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
    exit();
}

require_once __DIR__ . '/../../assets/api/config/database.php';

$departureCity = trim($_POST['departure_city'] ?? '');
$arrivalCity   = trim($_POST['arrival_city'] ?? '');
$departureDate = trim($_POST['departure_date'] ?? '');
$returnDate    = trim($_POST['return_date'] ?? '');

$query = 'SELECT * FROM flights';
$conditions = [];
$params = [];

if ($departureCity !== '') {
    $conditions[] = 'departure_city LIKE :departure_city';
    $params[':departure_city'] = "%$departureCity%";
}

if ($arrivalCity !== '') {
    $conditions[] = 'arrival_city LIKE :arrival_city';
    $params[':arrival_city'] = "%$arrivalCity%";
}

if ($departureDate !== '' && $returnDate !== '') {
    $conditions[] = 'DATE(departure_datetime) BETWEEN :departure_date AND :return_date';
    $params[':departure_date'] = $departureDate;
    $params[':return_date'] = $returnDate;
} elseif ($departureDate !== '') {
    $conditions[] = 'DATE(departure_datetime) = :departure_date';
    $params[':departure_date'] = $departureDate;
} elseif ($returnDate !== '') {
    $conditions[] = 'DATE(departure_datetime) = :return_date';
    $params[':return_date'] = $returnDate;
}

if (count($conditions) > 0) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

$query .= ' ORDER BY departure_datetime ASC';
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <link rel="stylesheet" href="../../assets/css/settingsbutton.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>
    <h1>Flight Search</h1>

    <div class="search-container">
        <div class="search-tabs">
            <button class="tab-btn active" onclick="showSearchTab('flights', this)">Flights</button>
            <button class="tab-btn" onclick="showSearchTab('accommodation', this)">Accommodation</button>
            <button class="tab-btn" onclick="showSearchTab('budget', this)">Budget</button>
            <button class="tab-btn" onclick="showSearchTab('itinerary', this)">Itinerary Building</button>
        </div>

        <div id="flights" class="search-panel active-panel">
            <form id="flight-search-form" method="POST" action="/AUT-Web-Based-Travel-Planner/Pages/userDashboard/searchBoard.php">
                <input type="text" name="departure_city" placeholder="Starting Location..." value="<?php echo htmlspecialchars($departureCity); ?>">
                <input type="text" name="arrival_city" placeholder="Destination..." value="<?php echo htmlspecialchars($arrivalCity); ?>">
                <input type="date" name="departure_date" value="<?php echo htmlspecialchars($departureDate); ?>">
                <input type="date" name="return_date" value="<?php echo htmlspecialchars($returnDate); ?>">
                <button type="submit" class="search-btn">Search</button>
                <button type="button" class="search-btn" onclick="location.href='Dashboard.php'">Back to Dashboard</button>
            </form>
        </div>

        <div id="accommodation" class="search-panel">
            <input type="text" placeholder="Search accommodation...">
            <input type="text" placeholder="Accommodation type...">
            <button class="search-btn">Search</button>
        </div>

        <div id="budget" class="search-panel">
            <input type="text" placeholder="Search budget...">
            <button class="search-btn">Search</button>
        </div>

        <div id="itinerary" class="search-panel">
            <input type="text" placeholder="Search itinerary...">
            <button class="search-btn">Search</button>
        </div>
    </div>

    <div class="search-results">
        <h2>Search Results</h2>
        <?php if (count($flights) === 0): ?>
            <p>No flights found for the selected criteria.</p>
        <?php else: ?>
            <table class="flight-results-table">
                <thead>
                    <tr>
                        <th>Airline</th>
                        <th>Flight #</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Departure</th>
                        <th>Arrival</th>
                        <th>Duration</th>
                        <th>Stops</th>
                        <th>Class</th>
                        <th>Price (NZD)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($flights as $flight): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($flight['airline']); ?></td>
                            <td><?php echo htmlspecialchars($flight['flight_number']); ?></td>
                            <td><?php echo htmlspecialchars($flight['departure_city']); ?> (<?php echo htmlspecialchars($flight['departure_airport']); ?>)</td>
                            <td><?php echo htmlspecialchars($flight['arrival_city']); ?> (<?php echo htmlspecialchars($flight['arrival_airport']); ?>)</td>
                            <td><?php echo htmlspecialchars($flight['departure_datetime']); ?></td>
                            <td><?php echo htmlspecialchars($flight['arrival_datetime']); ?></td>
                            <td><?php echo htmlspecialchars($flight['duration_minutes']); ?> min</td>
                            <td><?php echo htmlspecialchars($flight['stops']); ?></td>
                            <td><?php echo htmlspecialchars($flight['cabin_class']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($flight['price_nzd'], 2)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function showSearchTab(tabId, clickedButton) {
            const panels = document.querySelectorAll('.search-panel');
            const buttons = document.querySelectorAll('.tab-btn');

            panels.forEach(panel => panel.classList.remove('active-panel'));
            buttons.forEach(button => button.classList.remove('active'));

            document.getElementById(tabId).classList.add('active-panel');
            clickedButton.classList.add('active');
        }
    </script>
</body>
</html>