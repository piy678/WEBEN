<?php
session_start();
require_once '../../Backend/config/db.php'; 
//Admin-Check
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(["error" => "Nicht erlaubt"]);
    exit;
}

$itemId = isset($_GET['item_id']) ? intval($_GET['item_id']) : 0;
//Fehlerbehandlung
if ($itemId <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Ungültige ID"]);
    exit;
}
//löschen
$stmt = $mysqli->prepare("DELETE FROM order_items WHERE id = ?");
$stmt->bind_param("i", $itemId);
$stmt->execute();

echo json_encode(["success" => true]);
exit;
