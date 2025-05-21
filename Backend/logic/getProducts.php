<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/db.php';
//Alle Produkte holen
$sql = "SELECT * FROM tickets";
$result = $mysqli->query($sql);

$produkte = [];
// Alle Produkte in ein Array speichern
while ($row = $result->fetch_assoc()) {
    $produkte[] = [
        "id" => $row["id"],
        "titel" => $row["title"],
        "beschreibung" => $row["description"],
        "preis" => $row["price"],
        "bild" => "../../Backend/productpictures/" . $row["image"]
    ];
}
//Json-Response zurückgeben
echo json_encode(["success" => true, "produkte" => $produkte]);
