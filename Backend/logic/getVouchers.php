<?php
require_once("../config/db.php");

$result = mysqli_query($mysqli, "SELECT * FROM vouchers ORDER BY id DESC");
$vouchers = [];

while ($row = mysqli_fetch_assoc($result)) {
    $row["status"] = $row["used"] ? "Eingelöst" : (strtotime($row["valid_until"]) < time() ? "Abgelaufen" : "Einlösbar");
    $vouchers[] = $row;
}

echo json_encode($vouchers);
