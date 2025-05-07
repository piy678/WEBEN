<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $imageName = $_POST['currentImage'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../productpictures/" . $imageName);
    }

    $stmt = $mysqli->prepare("UPDATE tickets SET title=?, category=?, price=?, image=? WHERE id=?");
    $stmt->bind_param("ssdsi", $title, $category, $price, $imageName, $id);
    $stmt->execute();

    echo json_encode(['status' => 'updated']);
}
