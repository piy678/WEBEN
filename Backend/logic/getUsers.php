<?php
header("Content-Type: application/json");

require_once '../config/db.php';  

$result = $mysqli->query("SELECT id, vorname, nachname, email, is_active FROM benutzer");

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Abfrage fehlgeschlagen: " . $mysqli->error]);
    exit;
}

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
