<?php
session_start();
require_once '../config/db.php'; 

$identifier = $_POST['login'] ?? ''; 
$password = $_POST['password'] ?? '';
$remember = isset($_POST['remember']); 

if (!$identifier || !$password) {
    header("Location: ../../Frontend/sites/login.html?error=empty");
    exit;
}

// Verbindung zur Datenbank
$conn = new mysqli($host, $user, $pass, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindungsfehler: " . $conn->connect_error);
}

// Statement vorbereiten: hole auch is_active
$stmt = $conn->prepare("SELECT id, benutzername, email, passwort, is_admin, is_active FROM benutzer WHERE benutzername = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {

    // Prüfen ob deaktiviert
    if ($user["is_active"] == 0) {
        header("Location: ../../Frontend/sites/login.html?error=deactivated");
        exit;
    }

    if (password_verify($password, $user['passwort'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['benutzername'];
        $_SESSION['role'] = $user['is_admin'] ? "admin" : "user";

        if ($remember) {
            setcookie('remember_me', $user['id'], time() + (86400 * 30), "/");
        }

        header("Location: ../../Frontend/sites/tickets.html");
        exit;
    } else {
        header("Location: ../../Frontend/sites/login.html?error=invalid");
        exit;
    }
} else {
    header("Location: ../../Frontend/sites/login.html?error=invalid");
    exit;
}

$stmt->close();
$conn->close();
?>
