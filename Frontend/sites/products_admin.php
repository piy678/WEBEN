<?php
session_start(); // Startet die PHP-Session, um Benutzerdaten aus der Session zu lesen

// Überprüft, ob der Benutzer eingeloggt und ein Admin ist
if (!isset($_SESSION['user_id']) || $_SESSION['is_admin'] != 1) {
    // Falls nicht, Weiterleitung zur Login-Seite mit Fehlerparameter
    header("Location: login.php?error=unauthorized");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de"> <!-- Dokumentensprache: Deutsch -->
<head>
  <meta charset="UTF-8"> <!-- Zeichencodierung: UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsives Layout -->
  <meta name="description" content="Login-Seite für SmartTicketing. Melden Sie sich an, um Tickets zu kaufen und Ihre Bestellungen zu verwalten."> <!-- Beschreibung für SEO -->

  <title>Admin Produkte hinzufügen</title> <!-- Titel der Seite im Browser-Tab -->

  <!-- Bootstrap CSS für Styling -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

  <!-- Eigene CSS-Datei -->
  <link rel="stylesheet" href="../res/css/style.css"> 
</head>

<body>
  <!-- Hauptcontainer mit Abstand -->
  <div class="container mt-5">
    <!-- Karte zur Formular-Darstellung -->
    <div class="card p-4 mx-auto" style="max-width: 400px;">
      <h2>Admin Produkte hinzufügen</h2> <!-- Überschrift -->

      <!-- Formular zum Hinzufügen eines neuen Produkts -->
      <form id="productForm" enctype="multipart/form-data"> <!-- multipart erlaubt Datei-Upload -->
        <!-- Eingabefeld für Produktname -->
        <input name="name" placeholder="Name" class="form-control mb-2" required>

        <!-- Eingabefeld für Beschreibung -->
        <textarea name="description" placeholder="Beschreibung" class="form-control mb-2"></textarea>

        <!-- Dropdown für Kategorieauswahl -->
        <select name="category" class="form-select mb-2" required>
          <option value="">Kategorie wählen...</option>
          <option value="Konzert">Konzert</option>
          <option value="Theater">Theater</option>
          <option value="Comedy">Comedy</option>
          <option value="Sport">Sport</option>
        </select>

        <!-- Bewertungseingabe -->
        <input type="number" step="0.1" name="rating" placeholder="Bewertung" class="form-control mb-2">

        <!-- Preiseingabe -->
        <input type="number" step="0.01" name="price" placeholder="Preis" class="form-control mb-2" required>

        <!-- Bild-Upload -->
        <input type="file" name="image" accept="image/*" class="form-control mb-2">

        <!-- Absende-Button -->
        <button type="submit" class="btn btn-primary">Produkt speichern</button>
      </form>

      <!-- Feedbackbereich für Nachrichten (z. B. Erfolgs- oder Fehlermeldungen) -->
      <div id="feedback"></div>

      <hr>

      <!-- Bereich für Ticketverwaltung -->
      <h3>Tickets verwalten</h3>
      <div id="ticketList"></div> <!-- Hier werden bestehende Tickets eingeblendet -->

      <!-- Zweites Feedback-Div (optional, aber vermutlich versehentlich doppelt) -->
      <div id="feedback"></div>
    </div>
  </div>

  <!-- Bootstrap Bundle mit Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- jQuery für DOM-Interaktion -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <!-- JavaScript für Admin-Produkt-Logik -->
  <script src="../js/productAdmin.js"></script>

  <!-- Allgemeines Script für Funktionen auf der Seite -->
  <script src="../js/script.js"></script>
</body>
</html>
