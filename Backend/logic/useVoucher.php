<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$code = $data["code"] ?? '';

require_once("../config/db.php");

if (!$code) {
    echo json_encode(["success" => false, "message" => "Kein Gutscheincode angegeben."]);
    exit;
}

$result = mysqli_query($mysqli, "SELECT * FROM vouchers WHERE code = '$code' AND valid_until >= NOW() AND used = 0");

if ($voucher = mysqli_fetch_assoc($result)) {
    $_SESSION["voucher"] = $voucher;
    echo json_encode(["success" => true, "newTotal" => "berechneter_neuer_Gesamtpreis"]); 
} else {
    echo json_encode(["success" => false, "message" => "Ungültiger oder abgelaufener Gutschein."]);
}
?>
