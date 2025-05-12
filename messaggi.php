<?php
include("link/connessione.php");
session_start();
$is_admin = (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@libreria.it');
$utente_loggato = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;
$result = $conn->query("SELECT * FROM Messaggi ORDER BY data_invio DESC");
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Messaggi</title>
    <link rel="icon" type="image/x-icon" href="link/libro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="link/messaggi.js"></script>
</head>
<body class="bg-light">
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
                <li class="nav-item me-3"><a class="nav-link" href="noleggi_admin.php">Gestione noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link active" href="admin_messaggi.php">Messaggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="aggiungi_libro.php">Aggiungi libro</a></li>
              <?php else: ?>
                <li class="nav-item me-3"><a class="nav-link" href="miei_noleggi.php">I miei noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="contatti.php">Contatti</a></li>
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
    <h2 class="mb-4">Messaggi Ricevuti</h2>
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Oggetto</th>
                <th>Messaggio</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="anteprima">
                <td><?= $row['id_messaggio'] ?></td>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['oggetto']) ?></td>
                <td colspan="2">
                    <button class="btn btn-sm btn-primary visualizza-btn" data-id="<?= $row['id_messaggio'] ?>">Visualizza</button>
                </td>
            </tr>
            <tr class="dettagli bg-white" id="dettagli-<?= $row['id_messaggio'] ?>" style="display: none;">
                <td colspan="6">
                    <strong>Messaggio:</strong><br>
                    <?= nl2br(htmlspecialchars($row['messaggio'])) ?><br><br>
                    <strong>Data invio:</strong> <?= $row['data_invio'] ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="index.php" class="btn btn-secondary mt-3">Torna alla Home</a><br>
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

<?php $conn->close(); ?>