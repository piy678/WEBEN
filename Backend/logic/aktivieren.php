<?php
if (isset($_POST["id"])) {
    $id = intval($_POST["id"]);

    $conn = new mysqli("localhost", "root", "", "webshop");

    if ($conn->connect_error) {
        die("Verbindung fehlgeschlagen: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("UPDATE benutzer SET is_active = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
header("Location: ../../Frontend/sites/admin_userliste.php");
exit;

} else {
    echo "Ungültiger Zugriff.";
}
?>
