<?php
if (isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    // Verbindung zur Datenbank
    $conn = new mysqli("localhost", "root", "", "webshop");

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    // Benutzer deaktivieren
    $stmt = $conn->prepare("UPDATE benutzer SET is_active = 0 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Weiterleitung zurück zur Admin-Seite
    header("Location: admin_userliste.php");
    exit();
} else {
    echo "Ungültiger Zugriff.";
}
?>
