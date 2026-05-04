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
<body>

<h1>My First Heading</h1>
<?php if (isset($_SESSION['username'])): ?>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
<?php endif; ?>
<p>Here you can manage your travel plans, view your itinerary, and access exclusive travel deals</p>
    

</body>
</html>