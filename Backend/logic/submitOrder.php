<?php
session_start();
require_once("../config/dbacess.php");

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    echo json_encode(["success" => false, "message" => "Warenkorb ist leer."]);
    exit;
}

// Bestellung speichern
$userId = $_SESSION["user_id"] ?? null;
$total = 0;
foreach ($_SESSION["cart"] as $item) {
    $total += $item["price"] * $item["quantity"];
}

// Gutschein anwenden (falls vorhanden)
if (isset($_SESSION["voucher"])) {
    $total -= $_SESSION["voucher"]["value"];
    if ($total < 0) $total = 0;
}

// Bestellung in DB speichern
mysqli_query($conn, "INSERT INTO orders (user_id, total_price, created_at) VALUES ($userId, $total, NOW())");
$orderId = mysqli_insert_id($conn);

// Bestellpositionen speichern
foreach ($_SESSION["cart"] as $item) {
    $pid = $item["id"];
    $title = $item["title"];
    $price = $item["price"];
    $quantity = $item["quantity"];

    mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, title, price, quantity) VALUES ($orderId, $pid, '$title', $price, $quantity)");
}

// Gutschein als verwendet markieren
if (isset($_SESSION["voucher"])) {
    $voucherId = $_SESSION["voucher"]["id"];
    mysqli_query($conn, "UPDATE vouchers SET used = 1 WHERE id = $voucherId");
}

// Warenkorb leeren
unset($_SESSION["cart"]);
unset($_SESSION["voucher"]);

echo json_encode(["success" => true]);
?>
