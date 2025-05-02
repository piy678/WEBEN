<?php
session_start();
session_unset();
session_destroy();

// Optional: remember_me Cookie löschen
setcookie("remember_me", "", time() - 3600, "/");

// WICHTIG: Nur JSON ausgeben!
header("Content-Type: application/json");
echo json_encode(["success" => true]);

