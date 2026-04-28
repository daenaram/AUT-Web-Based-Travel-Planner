<?php
session_start();

// Adjust this base URL to match how you access the project in the browser.
// Example: if you open http://localhost/AUT-Web-Based-Travel-Planner/... then use "/AUT-Web-Based-Travel-Planner"
$BASE_URL = '/AUT-Web-Based-Travel-Planner/Pages/UserAuthentication';
$DASHBOARD_URL = '/AUT-Web-Based-Travel-Planner/Pages/userDashboard/Dashboard.html';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: {$BASE_URL}/signup.html");
    exit();
}

require_once __DIR__ . '/../config/database.php';

// Get and sanitize form data
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$email    = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Basic validation
if ($username === '' || $email === '' || $password === '') {
    header("Location: {$BASE_URL}/signup.html?error=All+fields+are+required");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: {$BASE_URL}/signup.html?error=Invalid+email+format");
    exit();
}

if (strlen($password) < 8) {
    header("Location: {$BASE_URL}/signup.html?error=Password+must+be+at+least+8+characters");
    exit();
}

try {
    // Check if username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $count = (int) $stmt->fetchColumn();

    if ($count > 0) {
        header("Location: {$BASE_URL}/signup.html?error=Email+or+username+already+exists");
        exit();
    }

    // Hash the password — never store plain text passwords
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashedPassword]);

    // Log the user in by saving session info
    $userId = $pdo->lastInsertId();
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;

    // Redirect to dashboard on success
    header("Location: {$DASHBOARD_URL}");
    exit();
} catch (Exception $e) {
    // Log the error on server, show a generic message to user (avoid leaking internals)
    error_log("Signup error: " . $e->getMessage());
    header("Location: {$BASE_URL}/signup.html?error=Server+error.+Please+try+again+later.");
    exit();
}
?>