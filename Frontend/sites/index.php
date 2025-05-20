<?php
session_start();
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>SmartTicketing</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"/>
    <link rel="stylesheet" href="../res/css/style.css" />
 
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }
  </style>
</head>
<body class="d-flex flex-column min-vh-100" style="color: black;">

  <main class="flex-grow-1" style="color: black;">
    <header class="bg-light py-5 text-center" style="color: black;">
      <div class="container">
        <h1 class="display-4">SmartTicketing</h1>
        <p class="lead">Finden Sie den passenden Event für Ihre Interessen</p>
</p>
        <?php if ($username): ?>
          <h2 class="mt-4">Willkommen, <strong><?= htmlspecialchars($username) ?></strong>!</h2>
          <a href="tickets.html" class="btn btn-success btn-lg mt-3">Zu den Tickets</a> <br>
          <a href="../../Backend/logic/logout.php" class="btn btn-danger btn-lg mt-3">Abmelden</a>
        <?php else: ?>
          <p class="lead">Jetzt anmelden oder registrieren</p>
          <a href="registration.html" class="btn btn-primary btn-lg mt-3">Registrierung</a> <br>
          <a href="login.html" class="btn btn-primary btn-lg mt-3">Login</a>
        <?php endif; ?>
      </div>
      
    </header>
  </main>
<div class="container mt-5">
    <h3 class="mb-4">Unsere Produkte</h3>

    <div id="carouselContainer"></div>
</div>
    <script>
fetch('../../Backend/logic/getProducts.php')
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      const carouselContainer = document.getElementById('carouselContainer');
      let carouselInner = '';
      let indicators = '';

      data.produkte.forEach((produkt, index) => {
        indicators += `
          <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></button>
        `;

        carouselInner += `
          <div class="carousel-item ${index === 0 ? 'active' : ''}">
            <img src="${produkt.bild}" class="d-block w-100" alt="${produkt.titel}">
            <div class="carousel-caption d-none d-md-block">
              <h5>${produkt.titel}</h5>
            </div>
          </div>
        `;
      });

      carouselContainer.innerHTML = `
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">${indicators}</div>
          <div class="carousel-inner">${carouselInner}</div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      `;
    } else {
      alert("Fehler beim Laden der Produkte: " + data.message);
    }
  });
</script>
<section class="bg-light text-center py-4 mt-5">
  <div class="container">
    <h4 class="mb-3">Was wir bieten</h4>
    <p class="lead mb-0">
      Top-Events &nbsp; | &nbsp; Schnelle Buchung &nbsp; | &nbsp; Faire Preise
    </p>
  </div>
</section>

    <!-- Bootstrap + Custom JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
    <script src="../js/script.js"></script>
    <script src="../js/logout.js"></script>
    <div id="footer-container"></div>
  </body>
</html>