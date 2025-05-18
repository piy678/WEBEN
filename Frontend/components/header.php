<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$is_admin = $_SESSION['is_admin'] ?? false;
?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Meine Seite'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../sites/index.html">
                <img src="../res/img/logo.png" alt="Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Navigation ein-/ausblenden">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (!$is_logged_in): ?>
                        <li class="nav-item"><a class="nav-link" href="../sites/tickets.html">Tickets</a></li>
                        <li class="nav-item">
  <a class="nav-link" href="../sites/cart.html">
    🛒<span id="cart-count" class="badge bg-light text-dark">0</span>
  </a>
</li>

                    <?php else: ?>
                        <?php if ($is_admin): ?>
                            <li class="nav-item"><a class="nav-link" href="../sites/products_admin.php">Produkte bearbeiten</a></li>
                            <li class="nav-item"><a class="nav-link" href="../sites/admin_userliste.php">Kunden bearbeiten</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="../sites/tickets.html">Tickets</a></li>
                            <li class="nav-item">
  <a class="nav-link" href="../sites/cart.html">
    🛒<span id="cart-count" class="badge bg-light text-dark">0</span>
  </a>
</li>
                            <li class="nav-item"><a class="nav-link" href="../sites/myorders.html">Mein Konto</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link" href="../../Backend/logic/logout.php">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
