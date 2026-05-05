<?php
// Start session to access user data from login
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/settingsbutton.css">
</head>
<body>

<h1>CampusTrips</h1>
<?php if (isset($_SESSION['username'])): ?>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
<?php endif; ?>
<p>Here you can manage your travel plans, view your itinerary, and access exclusive travel deals</p>
<a class="top-right-button" href="/AUT-Web-Based-Travel-Planner/assets/api/auth/signout.php">Sign Out</a>
</body>
</html>