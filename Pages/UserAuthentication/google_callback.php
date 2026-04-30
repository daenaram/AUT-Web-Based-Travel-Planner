<?php
    session_start();

if (isset($_GET['error'])) {
    header("Location: loginForm.html?status=cancel");
    exit();
}

if (!isset($_GET['code'])) {
    header("Location: loginForm.html?status=error");
    exit();
}

// For now, this is a simplified success example.
// Later, exchange the code for user details.
$_SESSION['user_logged_in'] = true;

header("Location: Dashboard.html");
exit();


?>