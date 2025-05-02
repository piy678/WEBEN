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

// Verbindung aufbauen
$conn = new mysqli($host, $user, $pass, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
    die("Verbindungsfehler: " . $conn->connect_error);
}

// Sicheres Statement vorbereiten
$stmt = $conn->prepare("SELECT id, benutzername, email, passwort, is_admin FROM benutzer WHERE benutzername = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['passwort'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

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
