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
      <div id="items-<?= $order['id'] ?>"></div>
    </div>
  <?php endwhile; ?>

  <script>
    function loadOrderItems(orderId) {
      fetch(`../../Backend/logic/getOrderItems.php?order_id=${orderId}`)
        .then(res => res.json())
        .then(items => {
          const container = document.getElementById("items-" + orderId);
          if (items.length === 0) {
            container.innerHTML = "<em>Keine Positionen</em>";
            return;
          }
          container.innerHTML = "<ul>" + items.map(i =>
            `<li>${i.title} × ${i.quantity} = ${i.price} €</li>`
          ).join('') + "</ul>";
        });
    }
  </script>
</body>
</html>
