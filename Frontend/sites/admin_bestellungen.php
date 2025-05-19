<?php
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Zugriff verweigert");
}
require_once '../../Backend/config/db.php';

$user_id = $_GET['user_id'] ?? 0;
$user_id = intval($user_id);

$stmt = $mysqli->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Bestellungen des Nutzers</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">
  <h2>Bestellungen von Nutzer #<?= $user_id ?></h2>
  <a href="admin_userliste.php" class="btn btn-secondary mb-3">Zurück</a>
<?php while ($order = $orders->fetch_assoc()): ?>
  <div class="card mb-3 p-3">
    <strong>Bestellung #<?= $order['id'] ?></strong><br>
    Datum: <?= $order['created_at'] ?> – Gesamt: <?= $order['total_price'] ?> €<br>
    <button class="btn btn-sm btn-outline-primary" onclick="loadOrderItems(<?= $order['id'] ?>)">Details</button>

    <div id="items-<?= $order['id'] ?>" class="ms-3 mt-2"></div>
  </div>
<?php endwhile; ?>


<script>
function loadOrderItems(orderId) {
  fetch(`../../Backend/logic/getOrderItemsAdmin.php?order_id=${orderId}`)
    .then(res => res.json())
    .then(items => {
      const container = document.getElementById("items-" + orderId);
      if (!items || items.length === 0) {
        container.innerHTML = "<em>Keine Positionen gefunden</em>";
        return;
      }

     let html = "<ul>";
items.forEach(item => {
  html += `
    <li>
      ${item.title} × ${item.quantity} = ${item.price} €
      <button class="btn btn-sm btn-danger ms-2" onclick="deleteOrderItem(${item.id}, ${orderId})">Entfernen</button>
    </li>
  `;
});
html += "</ul>";
      container.innerHTML = html;
    });
}
function deleteOrderItem(itemId, orderId) {
  if (!itemId || itemId === undefined) {
    alert("Fehler: Keine gültige item_id übergeben.");
    return;
  }

  fetch(`../../Backend/logic/deleteOrderItem.php?item_id=${itemId}`)
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        loadOrderItems(orderId);
      } else {
        alert("Löschen fehlgeschlagen.");
      }
    })
    .catch(() => alert("Fehler beim Löschen."));
}


</script>
<script src="../js/script.js"></script>
</body>
</html>
