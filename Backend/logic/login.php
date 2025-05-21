<?php
session_start();
require_once '../config/db.php';

// JSON-Daten einlesen
$data = json_decode(file_get_contents('php://input'), true);
$identifier = $data['login'] ?? '';
$password = $data['password'] ?? '';
$remember = $data['remember'] ?? false;

// Fehler bei leeren Eingaben
if (!$identifier || !$password) {
    echo json_encode(['success' => false, 'message' => 'Login-Daten unvollständig.']);
    exit;
}

// Verbindung zur Datenbank
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Verbindungsfehler.']);
    exit;
}

// Benutzer anhand E-Mail oder Benutzername suchen
$stmt = $conn->prepare("SELECT id, benutzername, passwort, is_admin, is_active FROM benutzer WHERE benutzername = ? OR email = ?");
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if ($user['is_active'] == 0) {
        echo json_encode(['success' => false, 'message' => 'Benutzerkonto deaktiviert.']);
        exit;
    }

    // Passwort prüfen
    if (password_verify($password, $user['passwort'])) {
        // Session starten
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['benutzername'];
        $_SESSION['is_admin'] = $user['is_admin'];

        // Cookie setzen (Login merken)
        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $insertToken = $conn->prepare("INSERT INTO login_tokens (user_id, token) VALUES (?, ?)");
            $insertToken->bind_param("is", $user['id'], $token);
            $insertToken->execute();
            setcookie("rememberme", $token, time() + (86400 * 30), "/", "", false, true);
        }

        // Erfolgreiche Antwort
        echo json_encode([
            'success' => true,
            'redirect' => $user['is_admin'] 
                ? '../../Frontend/sites/products_admin.html'
                : '../../Frontend/sites/tickets.html'
        ]);
        exit;
    }
}

// Login fehlgeschlagen
echo json_encode(['success' => false, 'message' => 'Login fehlgeschlagen.']);
exit;
