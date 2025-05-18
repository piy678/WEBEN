<?php
session_start();
require_once '../config/db.php';

$identifier = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

if (!$identifier || !$password) {
    header("Location: ../../Frontend/sites/login.html?error=invalid");
    exit;
}

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Verbindungsfehler: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT id, benutzername, passwort, is_admin, is_active FROM benutzer WHERE benutzername = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if ($user["is_active"] == 0) {
        header("Location: ../../Frontend/sites/login.php?error=deactivated");
        exit;
    }

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

header("Location: ../../Frontend/sites/login.html?error=invalid");
exit;
