<?php 
include("link/connessione.php");
session_start();
$is_admin = (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@libreria.it');
$utente_loggato = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Libreria XYZ</title>
  <link href="link/libro.png" rel="icon" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="link/index.css">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-bold fst-italic" href="index.php">Libreria XYZ</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
        aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item me-3"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
            <li class="nav-item me-3"><a class="nav-link" href="libri.php">Libri</a></li>
            <?php if ($utente_loggato): ?>
              <?php if ($is_admin): ?>
                <li class="nav-item me-3"><a class="nav-link" href="noleggi_admin.php">Gestione noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="messaggi.php">Messaggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="aggiungi_libro.php">Aggiungi libro</a></li>
              <?php else: ?>
                <li class="nav-item me-3"><a class="nav-link" href="noleggi_utente.php">I miei noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="contatti.php">Contattaci</a></li>
              <?php endif; ?>
              <li class="nav-item"><span class="nav-link">Benvenuto, <?php echo htmlspecialchars($utente_loggato); ?>!</span></li>
              <li class="nav-item"><a class="nav-link" href="link/logout.php">Logout</a></li>
              <?php else: ?>
                <li class="nav-item me-3"><a class="nav-link" href="accedi.php">Accedi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="registra.php">Registra</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  <section class="hero text-center py-5 bg-light">
    <div class="container">
      <h1 class="display-5 fw-bold">Benvenuti nella nostra libreria</h1>
      <p class="lead">Scopri un vasto catalogo di libri per ogni tua esigenza e passione.</p>
      <a href="libri.php" class="btn btn-primary btn-lg mt-3">Esplora il catalogo</a>
    </div>
  </section>
  <section class="novita py-5 bg-light">
    <div class="container text-center">
      <h2 class="mb-5">Novità</h2>
      <div id="libro" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
        <div class="carousel-inner">
          <?php
          $query = $pdo->query("SELECT * FROM Libri ORDER BY id_libro DESC LIMIT 9");
          $libri = $query->fetchAll(PDO::FETCH_ASSOC);
          $chunks = array_chunk($libri, 3);
          $first = true;
          foreach ($chunks as $gruppo) {
            $attivo = $first ? 'active' : '';
            $first = false;
            echo "<div class='carousel-item $attivo'><div class='row justify-content-center'>";
            foreach ($gruppo as $libro) {
              $titolo = htmlspecialchars($libro['titolo']);
              $autore = htmlspecialchars($libro['autore']);
              $copertina = htmlspecialchars($libro['copertina']);
              echo "
              <div class='col-md-4'>
                <div class='card mb-4 border-0 bg-light'>
                  <img src='$copertina' class='card-img-top' alt='$titolo' style='height: 300px; object-fit: contain;'>
                  <div class='card-body'>
                    <h5 class='card-title'>$titolo</h5>
                    <p class='card-text'>$autore</p>
                    <a href='libri.php?id=" . $libro['id_libro'] . "' class='btn btn-outline-primary btn-sm'>Dettagli</a>
                  </div>
                </div>
              </div>";
              }
              echo "</div></div>";
            }
            ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#libro" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#libro" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
    </div>
  </section>
    <footer class="text-center py-4 bg-dark text-white">
      <p class="mb-2">&copy; 2025 Libreria XYZ. Tutti i diritti riservati.</p>
      <ul class="list-inline">
        <li class="list-inline-item me-3"><a href="https://www.facebook.com/" target="_blank" class="text-white text-decoration-none">Facebook</a></li>
        <li class="list-inline-item me-3"><a href="https://x.com/" target="_blank" class="text-white text-decoration-none">Twitter</a></li>
        <li class="list-inline-item"><a href="https://www.instagram.com/" target="_blank" class="text-white text-decoration-none">Instagram</a></li>
      </ul>
    </footer>
</body>
</html>
