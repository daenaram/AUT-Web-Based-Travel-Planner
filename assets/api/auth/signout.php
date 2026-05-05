<?php
session_start();
// Clear all session data
$_SESSION = array();
// Destroy the session
session_destroy();
// Redirect to login page after sign out
header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
exit();
