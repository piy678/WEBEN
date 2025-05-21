<?php
session_start();
require_once '../config/db.php';
// Überprüfen, ob die Eingaben vorhanden sind
$identifier = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']);
// Überprüfen, ob die Eingaben leer sind
if (!$identifier || !$password) {
    header("Location: ../../Frontend/sites/login.html?error=invalid");
    exit;
}
// Verbindung zur Datenbank
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Verbindungsfehler: " . $conn->connect_error);
}
// SQL-Abfrage vorbereiten um alle Benutzer zu finden, die entweder den Benutzernamen oder die E-Mail-Adresse haben
$stmt = $conn->prepare("SELECT id, benutzername, passwort, is_admin, is_active FROM benutzer WHERE benutzername = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();
// Überprüfen, ob ein Benutzer gefunden wurde
if ($user = $result->fetch_assoc()) {
    if ($user["is_active"] == 0) {
        header("Location: ../../Frontend/sites/login.php?error=deactivated");
        exit;
    }
     // Login merken – Token erzeugen und Cookie setzen
        if ($remember) {
            $token = bin2hex(random_bytes(32)); // sicheres Token

            // Token in die Datenbank speichern
            $insertToken = $conn->prepare("INSERT INTO login_tokens (user_id, token) VALUES (?, ?)");
            $insertToken->bind_param("is", $user['id'], $token);
            $insertToken->execute();

            // Cookie setzen (30 Tage gültig)
            setcookie("rememberme", $token, time() + (86400 * 30), "/", "", false, true);
        }
// Passwort überprüfen
    if (password_verify($password, $user['passwort'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['benutzername'];
        $_SESSION['is_admin'] = $user['is_admin'];

        if ($user['is_admin']) {
            header("Location: ../../Frontend/sites/products_admin.php");
        } else {
            header("Location: ../../Frontend/sites/tickets.html");
        }
        exit;
    }
}
// Wenn die Anmeldedaten ungültig sind, zurück zur Login-Seite
header("Location: ../../Frontend/sites/login.html?error=invalid");
exit;
