<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json'); 

require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $rating = isset($_POST['rating']) ? $_POST['rating'] : 0; 
    $imageName = '';

    // Bild hochladen
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../productpictures/" . $imageName);
    }

    
    $stmt = $mysqli->prepare("INSERT INTO tickets (title, category, price, image, rating) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'SQL Error: ' . $mysqli->error]);
        exit;
    }

    $stmt->bind_param("ssdss", $title, $category, $price, $imageName, $rating); 
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
