<?php
session_start();
header("Content-Type: application/json");

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
