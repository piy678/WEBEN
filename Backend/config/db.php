<?php
$host = 'localhost';
$user = 'root'; 
$pass = '';      
$dbname = 'webshop';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}
?>
