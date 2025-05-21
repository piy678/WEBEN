<?php
session_start();
header("Content-Type: application/json");

require_once("../config/db.php");
// Überprüfen, ob der Benutzer eingeloggt ist
$userId = $_SESSION["user_id"] ?? null;

if (!$userId) {
    http_response_code(403);
    echo json_encode([]); // kein Benutzer eingeloggt
    exit;
}

// Alle Bestellungen dieses Benutzers holen
$sql = "SELECT id, total_price, created_at FROM orders WHERE user_id = ? ORDER BY created_at ASC";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
// Alle Bestellungen in ein Array speichern
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
