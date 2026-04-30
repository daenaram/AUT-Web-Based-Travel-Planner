<?php
    $client_id = "Your_Google_Client_ID";
    redirect_id="http://localhost/yourfolder/google_callback.php";

    $scope="email profile";
    
    $url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query([
    "client_id" => $client_id,
    "redirect_uri" => $redirect_uri,
    "response_type" => "code",
    "scope" => $scope,
    "access_type" => "offline",
    "prompt" => "select_account"
]);

header("Location: " . $url);
exit();
?>