<?php
session_start();
header("Content-Type: application/json");
require_once("../config/db.php");

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    http_response_code(403);
    echo json_encode(["error" => "Nicht erlaubt"]);
    exit;
}

$orderId = isset($_GET["order_id"]) ? intval($_GET["order_id"]) : 0;

if ($orderId <= 0) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id, title, quantity, price FROM order_items WHERE order_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $orderId);
$stmt->execute();
$result = $stmt->get_result();

echo json_encode($result->fetch_all(MYSQLI_ASSOC));
