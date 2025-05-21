<?php
header("Content-Type: application/json");

require_once '../config/db.php';  
//Benutzer Daten holen
$result = $mysqli->query("SELECT id, vorname, nachname, email, is_active FROM benutzer");
//Überprüfen, ob die Abfrage erfolgreich war
if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Abfrage fehlgeschlagen: " . $mysqli->error]);
    exit;
}
//Alle Benutzer in ein Array speichern
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
