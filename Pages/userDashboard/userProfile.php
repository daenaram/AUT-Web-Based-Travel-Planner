<?php
// Start session to access user data
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
    exit();
}

require_once __DIR__ . '/../../assets/api/config/database.php';

$stmt = $pdo->prepare("SELECT username, email, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User profile not found.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <!-- Page heading for profile setup -->
    <h1>User Profile Set Up</h1>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Account Created:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>

    <p><a href="Dashboard.php">Back to Dashboard</a></p>
    <p><a href="../UserAuthentication/change_password.php">Change Password</a></p>
    <!-- Add profile setup form and fields here -->
    <a href = "/AUT-Web-Based-Travel-Planner/assets/api/auth/signout.php">Sign Out</a>
</body>
</html>