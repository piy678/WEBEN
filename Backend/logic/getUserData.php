<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';
// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Nicht eingeloggt."]);
    exit;
}

$userId = $_SESSION['user_id'];
//Alle Daten des Benutzers holen
$stmt = $mysqli->prepare("SELECT vorname, nachname, email, adresse, plz, ort, zahlungsmethode FROM benutzer WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
//Json-Objekt zurückgeben
echo json_encode([
    "success" => true,
    "user" => $user
]);
