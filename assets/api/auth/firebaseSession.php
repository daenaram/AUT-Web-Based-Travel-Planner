<?php
session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["email"])) {
    http_response_code(400);
    echo "Missing email";
    exit();
}

$_SESSION["user_id"] = $data["email"];
$_SESSION["username"] = $data["name"] ?? "User";
$_SESSION["email"] = $data["email"];

echo "success";
?>