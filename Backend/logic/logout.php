<?php
session_start();
session_unset();
session_destroy();
//Entferne den Token aus der Datenbank (damit er nicht mehr gültig ist)
if (isset($_COOKIE['rememberme'])) {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("DELETE FROM login_tokens WHERE token = ?");
        $stmt->bind_param("s", $_COOKIE['rememberme']);
        $stmt->execute();
    }

    // Cookie löschen
    setcookie("rememberme", "", time() - 3600, "/");
}


// beiJSON ausgeben!
header("Content-Type: application/json");
echo json_encode(["success" => true]);
header("Location: ../../Frontend/sites/index.php");
exit;


