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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Libri</title>
  <link rel="icon" type="image/x-icon" href="link/libro.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <link href="link/libri.css" rel="stylesheet">
  <script src="link/libri.js"></script>
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
            <li class="nav-item me-3"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
            <li class="nav-item me-3"><a class="nav-link active" href="libri.php">Libri</a></li>
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
  <div class="container py-4">
    <h1 class="text-center mb-4">📚Catalogo Libri</h1>
    <input type="text" class="form-control mb-4" id="filtroCard" placeholder="🔍 Cerca libro...">
    <p id="contatore"></p>
    <div class="row row-cols-1 row-cols-md-3 g-4" id="cardContainer">
      <?php
      $query = $pdo->query("SELECT * FROM Libri");
      while ($libro = $query->fetch(PDO::FETCH_ASSOC)) {
        $titolo = htmlspecialchars($libro['titolo']);
        $autore = htmlspecialchars($libro['autore']);
        $copertina = htmlspecialchars($libro['copertina']);
        $genere = htmlspecialchars($libro['genere']);
        $lingua = htmlspecialchars($libro['lingua']);
        $disponibile = $libro['disponibile'];
        $id = $libro['id_libro'];
        ?>
        <div class='col'>
          <div class='card h-100 libro' id='libro<?php echo $id; ?>'>
            <img src='<?php echo $copertina; ?>' class='card-img-top' alt='<?php echo $titolo; ?>'>
            <div class='card-body'>
              <h5 class='card-title'><?php echo $titolo; ?></h5>
              <p class='card-text'><?php echo $autore; ?></p>
              <button class='btn btn-info btn-sm' type='button' data-bs-toggle='collapse' data-bs-target='#dettagli<?php echo $id; ?>' aria-expanded='false' aria-controls='dettagli<?php echo $id; ?>'>Dettagli</button>
              <div class='collapse' id='dettagli<?php echo $id; ?>'>
                <p>Genere: <?php echo $genere; ?><br>Lingua: <?php echo $lingua; ?></p>
                <?php
                  $recQuery = $pdo->prepare("SELECT AVG(voto) AS media_voto, COUNT(*) AS totale FROM Recensioni WHERE id_libro = ?");
                  $recQuery->execute([$id]);
                  $recensione = $recQuery->fetch(PDO::FETCH_ASSOC);
                  $media_voto = round($recensione['media_voto'], 1);
                  $totale = $recensione['totale'];

                  echo "<div id='message' class='alert' style='display:none'></div>";
                  if ($totale > 0) {
                    echo "<p class='mt-2'><strong>⭐ Voto medio:</strong> $media_voto/5 su $totale recensioni</p>";
                  } else {
                    echo "<p class='mt-2 text-muted'><em>Nessuna recensione ancora</em></p>";
                  }

                  $commentiQuery = $pdo->prepare("SELECT utente, voto, commento, data_pubblicazione FROM Recensioni WHERE id_libro = ? ORDER BY data_pubblicazione DESC LIMIT 3");
                  $commentiQuery->execute([$id]);
                  while ($rec = $commentiQuery->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div class='border rounded p-2 mb-2'>
                            <strong>" . htmlspecialchars($rec['utente']) . "</strong> 
                            <span class='text-warning'>({$rec['voto']}/5)</span><br>
                            <small class='text-muted'>{$rec['data_pubblicazione']}</small>
                            <p>" . nl2br(htmlspecialchars($rec['commento'])) . "</p>
                          </div>";
                  }

                  if ($utente_loggato && !$is_admin) {
                    echo "
                    <form method='POST' action='link/invia_recensione.php' class='mt-3'>
                      <input type='hidden' name='id_libro' value='$id'>
                      <label for='voto$id'>Voto:</label>
                      <div class='star-rating mb-2'>
                        <input type='hidden' name='voto' value=''>";
                    
                        for ($i = 1; $i <= 5; $i++) {
                          echo "<i class='fa fa-star' data-val='$i'></i>";
                        }
                  
                      echo "</div>
                      <label for='commento$id'>Recensione:</label>
                      <textarea name='commento' id='commento$id' class='form-control mb-2' rows='2'></textarea>
                      <button type='submit' class='btn btn-primary btn-sm'>Invia</button><br><br>
                    </form>";
                  }                  
                ?>
              </div>
              <?php
          if (!$is_admin) {
            if ($disponibile) {
              echo "<button class='btn btn-success btn-sm noleggia' data-id='$id'>Noleggia</button>";
            } else {
              echo "<button class='btn btn-secondary btn-sm' disabled>Noleggiato</button>";
            }
          }
          echo "<div class='alert alert-success mt-2 d-none noleggio-confermato' role='alert'>Libro Noleggiato!</div>
            </div>
          </div>
        </div>";
      }
      ?>
    </div>
  </div>
  <footer class="text-center py-4 bg-dark text-white">
    <p class="mb-2">&copy; 2025 Libreria XYZ. Tutti i diritti riservati.</p>
    <ul class="list-inline">
      <li class="list-inline-item me-3"><a href="https://www.facebook.com/?locale=it_IT" target="_blank" class="text-white text-decoration-none">Facebook</a></li>
      <li class="list-inline-item me-3"><a href="https://x.com/" target="_blank" class="text-white text-decoration-none">Twitter</a></li>
      <li class="list-inline-item"><a href="https://www.instagram.com/" target="_blank" class="text-white text-decoration-none">Instagram</a></li>
    </ul>
  </footer>
</body>
</html>

