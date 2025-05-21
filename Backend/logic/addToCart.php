<?php
// Backend/logic/addToCart.php
session_start();
//liest den Post-Body aus und dekodiert ihn als JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? null;

if (!$id) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Kein Produkt angegeben."]);
    exit;
}
//leerer Warenkorb
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}
//hinzufügen oder aktualisieren
if (!isset($_SESSION["cart"][$id])) {
    $_SESSION["cart"][$id] = [
        "id" => $id,
        "title" => $data["title"],
        "price" => $data["price"],
        "quantity" => 1
      ];
} else {
    $_SESSION["cart"][$id]["quantity"]++;
}

echo json_encode(["success" => true]);
