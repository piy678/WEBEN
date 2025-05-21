<?php
if (isset($_POST["id"])) {
    $id = intval($_POST["id"]);
// Verbindung zur Datenbank
    $conn = new mysqli("localhost", "root", "", "webshop");

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }
//Tabelle benutzer aktualisieren
    $stmt = $conn->prepare("UPDATE benutzer SET is_active = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
header("Location: ../../Frontend/sites/admin_userliste.php");
exit;
//Fehlerbehandlung
} else {
    http_response_code(403);
    echo "Ungültiger Zugriff.";
}
?>
