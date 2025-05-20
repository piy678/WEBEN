<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Bestellungen des Nutzers</title>
      <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../res/css/style.css" />
</head>
<body class="container-fluid mt-4">

  <h2>Bestellungen</h2>
  <a href="admin_userliste.php" class="btn btn-secondary mb-3">Zurück</a>

  <div id="order-container"></div>

  <script>
    // Übergabe per URL: ?user_id=123
    const userId = new URLSearchParams(window.location.search).get("user_id");
    if (!userId) {
      document.getElementById("order-container").innerHTML = "<p>Kein Benutzer ausgewählt.</p>";
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="../js/script.js"></script>
<script src="../js/adminOrders.js"></script>
</body>
</html>
