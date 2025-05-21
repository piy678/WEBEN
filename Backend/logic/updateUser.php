<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';
//überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Nicht eingeloggt."]);
    exit;
}
//Session speichern
$userId = $_SESSION['user_id'];
$pw = $_POST['passwort'] ?? '';
//Passwort überprüfen
$stmt = $mysqli->prepare("SELECT passwort FROM benutzer WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

if (!$record || !password_verify($pw, $record['passwort'])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Passwort ist falsch."]);
    exit;
}

// Eingaben holen
$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$email = $_POST['email'];
$adresse = $_POST['adresse'];
$plz = $_POST['plz'];
$ort = $_POST['ort'];
$zahlung = $_POST['zahlungsmethode'];

// Aktualisieren
$update = $mysqli->prepare("UPDATE benutzer SET vorname=?, nachname=?, email=?, adresse=?, plz=?, ort=?, zahlungsmethode=? WHERE id=?");
$update->bind_param("sssssssi", $vorname, $nachname, $email, $adresse, $plz, $ort, $zahlung, $userId);
$success = $update->execute();
// Überprüfen, ob die Aktualisierung erfolgreich war
if ($success) {
    echo json_encode(["success" => true, "message" => "Daten wurden aktualisiert."]);
} else {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Fehler beim Speichern."]);
}
