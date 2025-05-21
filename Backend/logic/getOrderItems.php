<?php
session_start();
header("Content-Type: application/json");
require_once("../config/db.php");

$userId = $_SESSION["user_id"] ?? null;
$orderId = $_GET["order_id"] ?? null;

if (!$userId || !$orderId) {
  http_response_code(403);
    echo json_encode([]);
    exit;
}

$stmt = $mysqli->prepare("
  SELECT oi.title, oi.quantity, oi.price
  FROM order_items oi
  JOIN orders o ON oi.order_id = o.id
  WHERE oi.order_id = ? AND o.user_id = ?
");
$stmt->bind_param("ii", $orderId, $userId);
$stmt->execute();

$result = $stmt->get_result();
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
