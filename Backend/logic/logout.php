<?php
session_start();

// Alle Session-Daten löschen
$_SESSION = [];
session_destroy();

// Cookie "remember_me" löschen
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, "/");
}

// Weiterleitung zur Login-Seite oder Startseite
header("Location: ../../Frontend/index.html");
exit;
?>
