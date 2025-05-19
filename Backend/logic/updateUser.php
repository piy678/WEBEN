<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Nicht eingeloggt."]);
    exit;
}

$userId = $_SESSION['user_id'];
$pw = $_POST['passwort'] ?? '';

$stmt = $mysqli->prepare("SELECT passwort FROM benutzer WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$record = $result->fetch_assoc();

if (!$record || !password_verify($pw, $record['passwort'])) {
    echo json_encode(["success" => false, "message" => "asswort ist falsch."]);
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

if ($success) {
    echo json_encode(["success" => true, "message" => "Daten wurden aktualisiert."]);
} else {
    echo json_encode(["success" => false, "message" => "Fehler beim Speichern."]);
}
