<?php
header('Content-Type: application/json');
ini_set('display_errors', 1); // Fehler sichtbar machen
error_reporting(E_ALL);

require_once __DIR__ . '/../config/db.php';
//Post Daten empfangen prüfen
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Nur POST erlaubt"]);
    exit;
}

// JSON-Daten empfangen
$data = json_decode(file_get_contents("php://input"), true);

// Prüfen ob JSON korrekt empfangen wurde
if (!$data) {
    http_response_code(400); 
    echo json_encode(["success" => false, "message" => "Keine oder ungültige Daten empfangen"]);
    exit;
}

// Pflichtfelder prüfen
$required = ['vorname','nachname','adresse','plz','ort','email','benutzername','password','zahlung'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(["success" => false, "message" => "Bitte alle Pflichtfelder ausfüllen."]);
        exit;
    }
}

// Passwort hashen
$hash = password_hash($data['password'], PASSWORD_DEFAULT);

// SQL vorbereiten um Benutzer zu registrieren in die Datenbank hinzuzufügen
$stmt = $mysqli->prepare("INSERT INTO benutzer (vorname, nachname, adresse, plz, ort, email, benutzername, passwort, zahlungsmethode) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    http_response_code(500); 
    echo json_encode(["success" => false, "message" => "SQL-Fehler: " . $mysqli->error]);
    exit;
}

$stmt->bind_param(
  "sssssssss",
  $data['vorname'],
  $data['nachname'],
  $data['adresse'],
  $data['plz'],
  $data['ort'],
  $data['email'],
  $data['benutzername'],
  $hash,
  $data['zahlung']
);

// Ausführen
$success = $stmt->execute();
//wenn erfolgreich dann json zurückgeben
if ($success) {
    echo json_encode(["success" => true, "message" => "Registrierung erfolgreich"]);
exit;
} else {
    http_response_code(500); // Interner Serverfehler
    echo json_encode(["success" => false, "message" => "Fehler beim Einfügen: " . $stmt->error]);
}

