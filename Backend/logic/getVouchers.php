<?php
require_once("../config/db.php");
//Alle Gutscheine holen
$result = mysqli_query($mysqli, "SELECT * FROM vouchers ORDER BY id DESC");
$vouchers = [];
//Array für alle Gutscheine erstellen
while ($row = mysqli_fetch_assoc($result)) {
    $row["status"] = $row["used"] ? "Eingelöst" : (strtotime($row["valid_until"]) < time() ? "Abgelaufen" : "Einlösbar");
    $vouchers[] = $row;
}
//Json-Response zurückgeben
echo json_encode($vouchers);
