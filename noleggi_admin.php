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
  <title>Tutti i noleggi</title>
  <link rel="icon" type="image/x-icon" href="link/libro.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <li class="nav-item me-3"><a class="nav-link" href="libri.php">Libri</a></li>
            <?php if ($utente_loggato): ?>
              <?php if ($is_admin): ?>
                <li class="nav-item me-3"><a class="nav-link active" href="noleggi_admin.php">Gestione noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="messaggi.php">Messaggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="aggiungi_libro.php">Aggiungi libro</a></li>
              <?php endif; ?>
              <li class="nav-item"><span class="nav-link">Benvenuto, <?php echo htmlspecialchars($utente_loggato); ?>!</span></li>
              <li class="nav-item"><a class="nav-link" href="link/logout.php">Logout</a></li>
              <?php else: ?>
                <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>
<div class="container py-4">
  <h1 class="mb-4">📖 Tutti i Noleggi</h1>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Libro</th>
        <th>Utente</th>
        <th>Data Noleggio</th>
        <th>Restituito</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $stmt = $pdo->query("
        SELECT 
          Libri.titolo,
          Utenti.nome,
          Utenti.cognome,
          Noleggi.data_noleggio,
          Noleggi.data_restituzione
        FROM Noleggi
        JOIN Libri ON Noleggi.id_libro = Libri.id_libro
        JOIN Utenti ON Noleggi.id_utente = Utenti.id_utente
        ORDER BY Noleggi.data_noleggio DESC
      ");

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $titolo = htmlspecialchars($row['titolo']);
        $utente = htmlspecialchars($row['nome'] . ' ' . $row['cognome']);
        $noleggio = htmlspecialchars($row['data_noleggio']);
        $restituzione = $row['data_restituzione'] ? htmlspecialchars($row['data_restituzione']) : "<span class='text-danger'>Non restituito</span>";

        echo "<tr>
                <td>$titolo</td>
                <td>$utente</td>
                <td>$noleggio</td>
                <td>$restituzione</td>
              </tr>";
      }
      ?>
    </tbody>
  </table>

  <a href="index.php" class="btn btn-secondary mt-3">Torna alla Home</a>
</div>
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