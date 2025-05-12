<?php
include("link/connessione.php");
session_start();
$utente_loggato = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;

$email = $_SESSION['email'];
$nome = $_SESSION['nome'];

$stmt = $pdo->prepare("SELECT id_utente FROM Utenti WHERE email = ?");
$stmt->execute([$email]);
$utente = $stmt->fetch();

$id_utente = $utente['id_utente'];

$stmt = $pdo->prepare("
    SELECT L.titolo, L.autore, L.copertina, N.data_noleggio, N.data_restituzione
    FROM Noleggi N
    JOIN Libri L ON N.id_libro = L.id_libro
    WHERE N.id_utente = ?
    ORDER BY N.data_noleggio DESC
");
$stmt->execute([$id_utente]);
$noleggi = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>I tuoi noleggi</title>
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
              <li class="nav-item me-3"><a class="nav-link active" href="noleggi_utente.php">I miei noleggi</a></li>
              <li class="nav-item me-3"><a class="nav-link" href="contatti.php">Contattaci</a></li>
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
    <h2 class="mb-4">📖 I tuoi noleggi, <?php echo htmlspecialchars($nome); ?></h2>

    <?php if (count($noleggi) === 0): ?>
      <p>Non hai ancora noleggiato nessun libro.</p>
    <?php else: ?>
      <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($noleggi as $n): ?>
          <div class="col">
            <div class="card h-100">
              <img src="<?php echo htmlspecialchars($n['copertina']); ?>" class="card-img-top" alt="Copertina">
              <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($n['titolo']); ?></h5>
                <p class="card-text"><?php echo htmlspecialchars($n['autore']); ?></p>
                <p class="card-text">
                    <strong>Noleggiato il:</strong> <?php echo $n['data_noleggio']; ?><br>
                    <?php if ($n['data_restituzione']): ?>
                        <strong>Restituito:</strong> <?php echo $n['data_restituzione']; ?>
                    <?php else: ?>
                        <form method="POST" action="link/restituisci_libro.php">
                        <input type="hidden" name="titolo" value="<?php echo htmlspecialchars($n['titolo']); ?>">
                        <button type="submit" class="btn btn-warning btn-sm mt-2">Restituisci</button>
                        </form>
                    <?php endif; ?>
                </p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
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
