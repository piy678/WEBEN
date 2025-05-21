<?php
require_once('../config/db.php');
//Post-Request zum Löschen eines Tickets
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stmt = $mysqli->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo json_encode(['status' => 'deleted']);
}
