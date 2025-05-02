<?php
// Backend/logic/addToCart.php
session_start();
//liest den Post-Body aus und dekodiert ihn als JSON
$data = json_decode(file_get_contents("php://input"), true);
$id = $data["id"] ?? null;

if (!$id) {
    echo json_encode(["success" => false, "message" => "Kein Produkt angegeben."]);
    exit;
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

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
