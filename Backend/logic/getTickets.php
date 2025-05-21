<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../Backend/config/db.php'; 
//Kategorie und Filter-Parameter
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$search = $_GET['search'] ?? '';
$minPrice = $_GET['minPrice'] ?? '';
$maxPrice = $_GET['maxPrice'] ?? '';
$rating = $_GET['rating'] ?? 0;
$available = $_GET['available'] ?? 0;

$tickets = [];
$params = [];
$types = "";

// Basis-SQL
$sql = "SELECT id, title, category, price, image, rating FROM tickets WHERE 1=1";

// Filter dynamisch anhängen
if ($category !== 'all') {
    $sql .= " AND LOWER(category) = ?";
    $params[] = strtolower($category);
    $types .= "s";
}
// Suchbegriff
if (!empty($search)) {
    $sql .= " AND title LIKE ?";
    $params[] = '%' . $search . '%';
    $types .= "s";
}

if ($minPrice !== '') {
    $sql .= " AND price >= ?";
    $params[] = floatval($minPrice);
    $types .= "d";
}

if ($maxPrice !== '') {
    $sql .= " AND price <= ?";
    $params[] = floatval($maxPrice);
    $types .= "d";
}

if ($rating > 0) {
    $sql .= " AND rating >= ?";
    $params[] = floatval($rating);
    $types .= "d";
}

if ($available == 1) {
    $sql .= " AND available = 1";
}

// Ausführung
$stmt = $mysqli->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
// Überprüfen, ob die Abfrage erfolgreich war und wenn ja, die Ergebnisse speichern
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
} else {
    http_response_code(403);
    echo json_encode(["error" => $mysqli->error]);
    exit;
}

echo json_encode($tickets);
?>
