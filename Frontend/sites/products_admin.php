<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    header("Location: login.php?error=unauthorized");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login-Seite für SmartTicketing. Melden Sie sich an, um Tickets zu kaufen und Ihre Bestellungen zu verwalten.">
  <title>Admin Produkte hinzufügen</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/style.css"> 
</head>
<body>
  <div class="container mt-5">
  <div class="card p-4 mx-auto" style="max-width: 400px;">
  <h2>Admin Produkte hinzufügen</h2>
  <form id="productForm" enctype="multipart/form-data">
    <input name="name" placeholder="Name" class="form-control mb-2" required>
  
    <textarea name="description" placeholder="Beschreibung" class="form-control mb-2"></textarea>
  
    <select name="category" class="form-select mb-2" required>
      <option value="">Kategorie wählen...</option>
      <option value="Konzert">Konzert</option>
      <option value="Theater">Theater</option>
      <option value="Comedy">Comedy</option>
      <option value="Sport">Sport</option>
    </select>
  
    <input type="number" step="0.1" name="rating" placeholder="Bewertung" class="form-control mb-2">
  
    <input type="number" step="0.01" name="price" placeholder="Preis" class="form-control mb-2" required>
  
    <input type="file" name="image" accept="image/*" class="form-control mb-2">
  
    <button type="submit" class="btn btn-primary">Produkt speichern</button>
  </form>
  <div id="feedback"></div>
<hr>
<h3>Tickets verwalten</h3>
<div id="ticketList"></div>

  <div id="feedback"></div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="../js/productAdmin.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>