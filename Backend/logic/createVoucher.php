<?php
// Backend/logic/createVoucher.php
require_once("../config/db.php");

function generateCode($length = 5) {
    return substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}

$data = json_decode(file_get_contents("php://input"), true);
$value = floatval($data["value"] ?? 0);
$validUntil = $data["valid_until"] ?? null;

if ($value <= 0 || !$validUntil) {
    echo json_encode(["success" => false, "message" => "Ungültige Eingabe."]);
    exit;
}

$code = generateCode();
$stmt = $mysqli->prepare("INSERT INTO vouchers (code, value, valid_until, used) VALUES (?, ?, ?, 0)");
$stmt->bind_param("sds", $code, $value, $validUntil);
$stmt->execute();

echo json_encode(["success" => true, "code" => $code]);
