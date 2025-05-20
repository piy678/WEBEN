<?php
require_once '../../Backend/config/db.php';
require_once '../../Backend/logic/session_check.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $_SESSION['is_admin'] ?? false;
$username = $_SESSION['username'] ?? 'Benutzer';
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? 'Meine Seite' ?></title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../res/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
  <div class="container-fluid">
    <a class="navbar-brand" href="../sites/index.html">
      <img src="../res/img/logo.png" alt="Logo" style="height: 40px;">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <!-- Tickets immer sichtbar -->
        <li class="nav-item">
          <a class="nav-link" href="../sites/tickets.html">Tickets</a>
        </li>

        <!-- Warenkorb immer sichtbar -->
        <li class="nav-item">
          <a href="../sites/cart.html" class="nav-link position-relative">
            🛒
            <span id="cart-count" class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">0</span>
          </a>
        </li>

        <!-- Benutzer-Menü -->
        <?php if ($is_logged_in): ?>
          <li class="nav-item dropdown position-relative">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><span class="dropdown-item-text">Hallo, <strong><?= htmlspecialchars($username) ?></strong></span></li>
              <li><hr class="dropdown-divider"></li>

              <?php if ($is_admin): ?>
                <li><a class="dropdown-item" href="../sites/products_admin.php">Produkte bearbeiten</a></li>
                <li><a class="dropdown-item" href="../sites/admin_userliste.php">Kunden bearbeiten</a></li>
              <?php else: ?>
                <li><a class="dropdown-item" href="../sites/myorders.html">Meine Bestellungen</a></li>
                <li><a class="dropdown-item" href="../sites/account.html">Mein Konto</a></li>
              <?php endif; ?>

              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="../../Backend/logic/logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Login/Registrieren wenn nicht eingeloggt -->
          <li class="nav-item"><a class="nav-link" href="../sites/login.html">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="../sites/registration.html">Registrieren</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS (für Dropdown-Funktionalität) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
