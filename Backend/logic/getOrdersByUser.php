<?php
session_start();
//überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(["error" => "Zugriff verweigert"]);
    exit;
}

require_once '../config/db.php';
// Überprüfen, ob die Benutzer-ID übergeben wurde
$user_id = intval($_GET['user_id'] ?? 0);
$stmt = $mysqli->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
// Alle Bestellungen in ein Array speichern
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
