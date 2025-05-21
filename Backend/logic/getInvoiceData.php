<?php
require_once '../config/db.php';
session_start();

$orderId = intval($_GET['order_id'] ?? 0);
$userId = $_SESSION['user_id'] ?? null;
// Fehlerbehandlung
if (!$orderId || !$userId) {
  http_response_code(400);
  echo json_encode(["error" => "Ungültiger Zugriff"]);
  exit;
}

// Bestellung + Benutzer-Daten
$stmt = $mysqli->prepare("
  SELECT o.created_at, b.vorname, b.nachname, b.adresse, b.plz, b.ort
  FROM orders o
  JOIN benutzer b ON o.user_id = b.id
  WHERE o.id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $orderId, $userId);
$stmt->execute();
$meta = $stmt->get_result()->fetch_assoc();

// Bestellpositionen laden
$stmt2 = $mysqli->prepare("
  SELECT title, quantity, price
  FROM order_items
  WHERE order_id = ?
");
$stmt2->bind_param("i", $orderId);
$stmt2->execute();
$items = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
// Bestellpositionen formatieren
echo json_encode([
  "rechnungsnummer" => "R-" . date("Ymd") . "-$orderId",
  "datum" => $meta['created_at'],
  "anschrift" => $meta,
  "artikel" => $items
]);
