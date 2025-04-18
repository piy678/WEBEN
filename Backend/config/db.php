<?php
$host = 'localhost';
$user = 'root'; 
$pass = '';      
$dbname = 'webshop';

$mysqli = new mysqli($host, $user, $pass, $dbname);

if ($mysqli->connect_error) {
    die("Verbindung fehlgeschlagen: " . $mysqli->connect_error);
}
?>
