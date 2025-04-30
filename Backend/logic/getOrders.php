<?php
session_start();
require_once(__DIR__ . "/../config/db.php"); 

header('Content-Type: application/json');
$_SESSION["user_id"] = 1; 

$userId = $_SESSION["user_id"] ?? null;
if (!$userId) {
    echo json_encode([]);
    exit;
}


$res = $mysqli->query("SELECT id, total_price, created_at FROM orders WHERE user_id = $userId ORDER BY created_at DESC");

$orders = [];

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode($orders);
?>