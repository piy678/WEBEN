<?php
header('Content-Type: application/json');

require_once '../../Backend/config/db.php'; 

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$tickets = [];

if ($category === 'all') {
    $sql = "SELECT id, title, category, price, image, rating FROM tickets";

    $result = $mysqli->query($sql); 
} else {
    $stmt = $mysqli->prepare("SELECT id, title, category, price, image, rating FROM tickets WHERE LOWER(category) = LOWER(?)");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
} else {
    echo json_encode(["error" => $mysqli->error]); 
    exit;
}

echo json_encode($tickets);
?>
