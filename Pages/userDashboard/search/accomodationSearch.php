<?php 
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
    exit();
}

// Include database connection
require_once __DIR__ . '/../../assets/api/config/database.php';

// Retrieve and normalize search parameters (accept empty values)
$post = filter_input_array(INPUT_POST, [
    'name' => FILTER_DEFAULT,
    'type' => FILTER_DEFAULT,
    'city' => FILTER_DEFAULT,
    'country' => FILTER_DEFAULT,
    'address' => FILTER_DEFAULT,
    'check_in_time' => FILTER_DEFAULT,
    'check_out_time' => FILTER_DEFAULT,
    'price_per_night_nzd' => FILTER_DEFAULT,
    'rating' => FILTER_DEFAULT,
    'amenities' => FILTER_DEFAULT,
]);

$name      = trim((string)($post['name'] ?? ''));
$type      = trim((string)($post['type'] ?? ''));
$city      = trim((string)($post['city'] ?? ''));
$country   = trim((string)($post['country'] ?? ''));
$address   = trim((string)($post['address'] ?? ''));
$checkin   = trim((string)($post['check_in_time'] ?? ''));
$checkout  = trim((string)($post['check_out_time'] ?? ''));
$priceRaw  = trim((string)($post['price_per_night_nzd'] ?? ''));
$ratingRaw = trim((string)($post['rating'] ?? ''));
$amenities = trim((string)($post['amenities'] ?? ''));

// Prepare query parts
$query = 'SELECT * FROM accommodations';
$conditions = [];
$params = [];

if ($name !== '') {
    $conditions[] = 'name LIKE :name';
    $params[':name'] = "%$name%";
}

if ($type !== '') {
    $conditions[] = 'type LIKE :type';
    $params[':type'] = "%$type%";
}

if ($city !== '') {
    $conditions[] = 'city LIKE :city';
    $params[':city'] = "%$city%";
}

if ($country !== '') {
    $conditions[] = 'country LIKE :country';
    $params[':country'] = "%$country%";
}

if ($address !== '') {
    $conditions[] = 'address LIKE :address';
    $params[':address'] = "%$address%";
}

// Check-in / Check-out times: match partially (e.g., "14:00")
if ($checkin !== '') {
    $conditions[] = 'check_in_time LIKE :checkin';
    $params[':checkin'] = "%$checkin%";
}
if ($checkout !== '') {
    $conditions[] = 'check_out_time LIKE :checkout';
    $params[':checkout'] = "%$checkout%";
}

// Price: treat provided price as a maximum (users typically filter by max price)
if ($priceRaw !== '' && is_numeric($priceRaw)) {
    $price = (float)$priceRaw;
    $conditions[] = 'price_per_night_nzd <= :price';
    $params[':price'] = $price;
}

// Rating: treat provided rating as a minimum
if ($ratingRaw !== '' && is_numeric($ratingRaw)) {
    $rating = (float)$ratingRaw;
    $conditions[] = 'rating >= :rating';
    $params[':rating'] = $rating;
}

if ($amenities !== '') {
    $conditions[] = 'amenities LIKE :amenities';
    $params[':amenities'] = "%$amenities%";
}

if (count($conditions) > 0) {
    $query .= ' WHERE ' . implode(' AND ', $conditions);
}

// Order results by name
$query .= ' ORDER BY name ASC';

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Search Results</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">

</head>
<body>
    <h1>Accommodation Search Results</h1>

    <div class="search-container">
        <div class="search-tabs">
            <a href="searchBoard.php" class="tab">Flights</a>
            <a href="accomodationSearch.php" class="tab active">Accommodation</a>
        </div>  

        <div class="search-results">
            <?php if (count($accommodations) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Address</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Price per Night (NZD)</th>
                            <th>Rating</th>
                            <th>Amenities</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($accommodations as $accommodation): ?>
                            <tr>
                                <td><?= htmlspecialchars($accommodation['name']) ?></td>
                                <td><?= htmlspecialchars($accommodation['type']) ?></td>
                                <td><?= htmlspecialchars($accommodation['city']) ?></td>
                                <td><?= htmlspecialchars($accommodation['country']) ?></td>
                                <td><?= htmlspecialchars($accommodation['address']) ?></td>
                                <td><?= htmlspecialchars($accommodation['check_in_time']) ?></td>
                                <td><?= htmlspecialchars($accommodation['check_out_time']) ?></td>
                                <td><?= htmlspecialchars($accommodation['price_per_night_nzd']) ?></td>
                                <td><?= htmlspecialchars($accommodation['rating']) ?></td>
                                <td><?= htmlspecialchars($accommodation['amenities']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No accommodations found matching your search criteria.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>