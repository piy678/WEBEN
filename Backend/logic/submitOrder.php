<?php
session_start();
require_once("../config/db.php");

if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Warenkorb ist leer."]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "message" => "Sie müssen eingeloggt sein, um eine Bestellung abzuschließen."
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$paymentMethod = $data['payment'] ?? '';

if (!$paymentMethod) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Zahlungsart fehlt."]);
    exit;
}

$userId = $_SESSION["user_id"];
$total = 0;

// Gesamtpreis berechnen
foreach ($_SESSION["cart"] as $item) {
    $total += $item["price"] * $item["quantity"];
}

// Gutschein anwenden
if (isset($_SESSION["voucher"])) {
    $total -= $_SESSION["voucher"]["value"];
    if ($total < 0) $total = 0;
}

$totalPrice = $total;

// Bestellung speichern
$stmt = $mysqli->prepare("INSERT INTO orders (user_id, total_price, payment_method, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("ids", $userId, $totalPrice, $paymentMethod);
$stmt->execute();
$orderId = $stmt->insert_id;

// Bestellpositionen speichern (sicher!)
$itemStmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, title, price, quantity) VALUES (?, ?, ?, ?, ?)");
//Schleife durch den Warenkorb
foreach ($_SESSION["cart"] as $item) {
    $pid = $item["id"];
    $title = $item["title"];
    $price = $item["price"];
    $quantity = $item["quantity"];

    $itemStmt->bind_param("iisdi", $orderId, $pid, $title, $price, $quantity);
    $itemStmt->execute();
}

// Gutschein als verwendet markieren
if (isset($_SESSION["voucher"])) {
    $voucherId = $_SESSION["voucher"]["id"];
    $mysqli->query("UPDATE vouchers SET used = 1 WHERE id = $voucherId");
}

// Session leeren
unset($_SESSION["cart"]);
unset($_SESSION["voucher"]);
//Json Antwort 
echo json_encode(["success" => true]);
?>
