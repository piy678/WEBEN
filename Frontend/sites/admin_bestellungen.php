<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Bestellungen des Nutzers</title>
      <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../res/css/style.css" />
<style>
    body {
      margin: 0;
    }
    main {
      flex-grow: 1;
    }
  </style>
  </head>
<body class="d-flex flex-column min-vh-100">
    <h2></h2><strong>Bestellungen</strong></h2>
  <a href="../sites/admin_userliste.php" class="btn btn-secondary mb-3">Zurück</a>
   <main class="container my-4 flex-grow-1">
  
<div id="order-container"></div>
  </main>


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
