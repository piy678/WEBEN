<?php

error_reporting(0); // oder: error_reporting(E_ERROR);
@session_start();
header("Content-Type: application/json");
echo json_encode($_SESSION['cart'] ?? []);




// Session-Warenkorb prüfen
$cart = $_SESSION["cart"] ?? [];

$result = [];

foreach ($cart as $item) {
    if (
        isset($item["id"], $item["title"], $item["price"], $item["quantity"])
    ) {
        $result[] = $item;
    }
}

// Gültiges JSON ausgeben
echo json_encode($result);
