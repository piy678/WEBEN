<?php
header('Content-Type: application/json');
require_once '../Backend/config/db.php'; 

$category = isset($_GET['category']) ? $_GET['category'] : 'all';

$tickets = [];

if ($category === 'all') {
    $sql = "SELECT title, price FROM tickets";
    $result = $conn->query($sql);
} else {
    $stmt = $conn->prepare("SELECT title, price FROM tickets WHERE category = ?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
}

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
}

echo json_encode($tickets);
?>
