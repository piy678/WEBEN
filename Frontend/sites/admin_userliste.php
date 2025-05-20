<?php
// Optional: Session-Check für Admin
session_start();
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    die("Zugriff verweigert");
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kundenverwaltung</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css">
      <style>
    body {
      margin: 0;
    }
    main {
      flex-grow: 1;
    }
  
  </style>
<body class="d-flex flex-column min-vh-100">
    <h1>Kundenverwaltung</h1>

  <main class="container my-4"></main>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>E-Mail</th>
        <th>Status</th>
        <th>Aktion</th>
      </tr>
    </thead>
    <tbody id="user-table">
      <!-- JavaScript füllt das dynamisch -->
    </tbody>
  </table>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="../js/script.js"></script>
    <script src="../js/userAdmin.js"></script>
</body>
</html>
