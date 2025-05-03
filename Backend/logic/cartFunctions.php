<?php
session_start();
header('Content-Type: application/json');
require_once("../config/db.php"); // enthält $mysqli

$data = json_decode(file_get_contents("php://input"), true);
$action = $_GET['action'] ?? '';

// 1. Menge eines Produkts aktualisieren
if ($action === 'updateQuantity') {
    $id = $data["id"] ?? null;
    $quantity = $data["quantity"] ?? null;

    if ($id === null || $quantity < 1) {
        echo json_encode(["success" => false, "message" => "Ungültige Daten."]);
        exit;
    }

    if (isset($_SESSION["cart"][$id])) {
        $_SESSION["cart"][$id]["quantity"] = $quantity;
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Produkt nicht im Warenkorb."]);
    }
    exit;
}

// 2. Produkt entfernen
if ($action === 'removeFromCart') {
    $id = $data["id"] ?? null;

    if ($id !== null && isset($_SESSION["cart"][$id])) {
        unset($_SESSION["cart"][$id]);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Produkt nicht gefunden."]);
    }
    exit;
}

// 3. Gesamtanzahl zurückgeben
if ($action === 'getCartCount') {
    $count = 0;
    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $item) {
            $count += $item["quantity"];
        }
    }
    echo json_encode(["count" => $count]);
    exit;
}

// Ungültige Aktion
echo json_encode(["success" => false, "message" => "Keine gültige Aktion."]);
