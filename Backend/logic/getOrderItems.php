<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../config/db.php');

$orderId = isset($_GET['orderId']) ? intval($_GET['orderId']) : 0;

if (!$orderId) {
    echo json_encode([]);
    exit;
}

$stmt = $mysqli->prepare("SELECT title, price, quantity FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $orderId);
$stmt->execute();

$result = $stmt->get_result();
$items = [];

while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

echo json_encode($items);
?>