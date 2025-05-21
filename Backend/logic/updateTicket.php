<?php
header('Content-Type: application/json');
require_once('../config/db.php');
//Try-Catch-Block für Fehlerbehandlung
try {
    //Post Anfrage prüfen
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Ungültige Anfrage.");
    }

    // Pflichtfelder prüfen
    if (!isset($_POST['id'], $_POST['name'], $_POST['price'], $_POST['category'])) {
        throw new Exception("Pflichtfelder fehlen.");
    }

    $id = $_POST['id'];
    $title = $_POST['name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $rating = $_POST['rating'] ?? 0;
    $description = $_POST['description'] ?? '';
    $imageName = $_POST['currentImage'];

    // Bild hochladen, wenn neu ausgewählt
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $imageName = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "../productpictures/" . $imageName);
    }

    // SQL vorbereiten
    $stmt = $mysqli->prepare("UPDATE tickets SET title = ?, description = ?, category = ?, rating = ?, price = ?, image = ? WHERE id = ?");
    if (!$stmt) {
        throw new Exception("SQL-Fehler: " . $mysqli->error);
    }
// Bind-Parameter
    $stmt->bind_param("sssddsi", $title, $description, $category, $rating, $price, $imageName, $id);
    $stmt->execute();
// Überprüfen, ob die Aktualisierung erfolgreich war
    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'rows_updated' => $stmt->affected_rows]);
    } else {
        http_response_code(403);
        echo json_encode(['status' => 'warning', 'message' => 'Kein Datensatz geändert.']);
    }

    $stmt->close();
    // Verbindung schließen
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}