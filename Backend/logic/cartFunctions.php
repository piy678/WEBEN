<?php
session_start();
header('Content-Type: application/json');

$cart = $_SESSION["cart"] ?? [];
echo json_encode(array_values($cart));
// Produktdetails holen 
require_once("../config/db.php"); 

function getProductById($id) {
    global $conn; // mysqli-Verbindung

    $id = intval($id); 

    $query = "SELECT id, title, price FROM tickets WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }

    return null;
}


// 1. Menge eines Produkts im Warenkorb aktualisieren, wenn Link ?action=updateQuantity,wird diese Funktion ausgeführt
if (isset($_GET['action']) && $_GET['action'] === 'updateQuantity') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"] ?? null;
    $quantity = $data["quantity"] ?? 1;

    if (!$id || $quantity < 1) {
        echo json_encode(["success" => false]);
        exit;
    }

    $_SESSION["cart"][$id]["quantity"] = $quantity;

    echo json_encode(["success" => true]);
}

// 2. Produkt aus dem Warenkorb entfernen
if (isset($_GET['action']) && $_GET['action'] === 'removeFromCart') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data["id"] ?? null;

    if (isset($_SESSION["cart"][$id])) {
        unset($_SESSION["cart"][$id]);
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
}

// 3. Anzahl der Artikel im Warenkorb abrufen
if (isset($_GET['action']) && $_GET['action'] === 'getCartCount') {
    $count = 0;

    if (isset($_SESSION["cart"])) {
        foreach ($_SESSION["cart"] as $item) {
            $count += $item["quantity"];
        }
    }

    echo json_encode(["count" => $count]);
}
?>
