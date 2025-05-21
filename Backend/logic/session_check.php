<?php
session_start();
require_once '../../Backend/config/db.php';

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if (!$conn->connect_error) {
        $token = $_COOKIE['rememberme'];
        $stmt = $conn->prepare("SELECT user_id FROM login_tokens WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $_SESSION['user_id'] = $row['user_id'];
        }
    }
}

// Benutzername aus DB nachladen, falls noch nicht in Session
if (isset($_SESSION['user_id']) && !isset($_SESSION['username'])) {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT benutzername FROM benutzer WHERE id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            $_SESSION['username'] = $user['benutzername'];
        }
    }
}
