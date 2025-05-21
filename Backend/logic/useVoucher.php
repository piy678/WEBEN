<?php
session_start();
//Json Daten holen
$data = json_decode(file_get_contents("php://input"), true);
$code = $data["code"] ?? '';
//Gesamtpreis holen
$total = floatval($data["total"] ?? 0.0);
//Datenbankverbindung
require_once("../config/db.php");
//Code prüfen
if (!$code) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Kein Gutscheincode angegeben."]);
    exit;
}
//SQL für alle Gutscheine ausgeben
$result = mysqli_query($mysqli, "SELECT * FROM vouchers WHERE code = '$code' AND valid_until >= NOW() AND used = 0");
//Wert Aktualisren nach abziehen von dem Gutschein Preis
if ($voucher = mysqli_fetch_assoc($result)) {
    $discount = floatval($voucher["value"]);
    $newTotal = max(0, $total - $voucher["value"]); // niemals < 0
//Session setzten
    $_SESSION["voucher"] = $voucher;
//Json-Response zurückgeben
    echo json_encode([
        "success" => true,
        "newTotal" => number_format($newTotal, 2, '.', '') 
    ]);
} else {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "Ungültiger oder abgelaufener Gutschein."]);
}
?>

