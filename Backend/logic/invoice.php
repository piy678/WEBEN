<?php
require_once '../config/db.php';

session_start();

$orderId = $_GET['order_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if (!$orderId || !$userId) {
    die("Ungültiger Zugriff.");
}

// Bestelldaten abrufen
$stmt = $mysqli->prepare("
    SELECT oi.title, oi.quantity, oi.price, o.created_at
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    WHERE oi.order_id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $orderId, $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Keine Daten gefunden.");
}

// HTML-Inhalt für die PDF-Rechnung aufbauen
$html = "<h1>Rechnung #$orderId</h1>";
$html .= "<p>Datum: " . date("d.m.Y") . "</p>";
$html .= "<table border='1' cellspacing='0' cellpadding='5'>";
$html .= "<tr><th>Artikel</th><th>Menge</th><th>Preis</th></tr>";

$total = 0;
while ($row = $result->fetch_assoc()) {
    $line = $row['quantity'] * $row['price'];
    $html .= "<tr>
                <td>{$row['title']}</td>
                <td>{$row['quantity']}</td>
                <td>" . number_format($line, 2) . " €</td>
              </tr>";
    $total += $line;
}

$html .= "<tr><td colspan='2'><strong>Gesamt</strong></td><td><strong>" . number_format($total, 2) . " €</strong></td></tr>";
$html .= "</table>";

// PDF generieren
