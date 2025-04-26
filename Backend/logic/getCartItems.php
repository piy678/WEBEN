<?php
session_start();
require_once("Backend\logic\cartFunctions.php"); // enthält getProductById()

$cart = $_SESSION["cart"] ?? [];
$result = [];

foreach ($cart as $item) {
    $product = getProductById($item["id"]); // Funktion, die Produktdetails zurückgibt 
    if ($product) {
        $result[] = [
            "id" => $item["id"],
            "title" => $product["title"],
            "price" => $product["price"],
            "quantity" => $item["quantity"]
        ];
    }
}

header("Content-Type: application/json");
echo json_encode($result);
