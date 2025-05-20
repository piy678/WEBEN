<?php
error_reporting(0); // Warnungen unterdrücken
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

// Nur EINMAL ausgeben:
echo json_encode($result);

