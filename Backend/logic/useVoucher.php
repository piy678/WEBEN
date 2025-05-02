<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
$code = $data["code"] ?? '';
$total = floatval($data["total"] ?? 0.0);

require_once("../config/db.php");

if (!$code) {
    echo json_encode(["success" => false, "message" => "Kein Gutscheincode angegeben."]);
    exit;
}

$result = mysqli_query($mysqli, "SELECT * FROM vouchers WHERE code = '$code' AND valid_until >= NOW() AND used = 0");

if ($voucher = mysqli_fetch_assoc($result)) {
    $discount = floatval($voucher["amount"]);
    $newTotal = max(0, $total - $discount); // niemals < 0

    $_SESSION["voucher"] = $voucher;

    echo json_encode([
        "success" => true,
        "newTotal" => number_format($newTotal, 2, '.', '') // z.B. 19.99
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Ungültiger oder abgelaufener Gutschein."]);
}
?>

