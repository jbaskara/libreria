<?php
include("link/connessione.php");
session_start();
$utente_loggato = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;

$nome = isset($_SESSION['nome']) ? $_SESSION['nome'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Contattaci</title>
    <link rel="icon" type="image/x-icon" href="link/libro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="link/contatti.js"></script>
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
                <li class="nav-item me-3"><a class="nav-link" href="noleggi_utente.php">I miei noleggi</a></li>
                <li class="nav-item me-3"><a class="nav-link active" href="contatti.php">Contattaci</a></li>
                <li class="nav-item"><span class="nav-link">Benvenuto, <?= htmlspecialchars($utente_loggato); ?>!</span></li>
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
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Contattaci</h4>
                </div>
                <div class="card-body">
                    <div id="messaggio-risposta"></div>

                    <form id="form-contatto">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($nome) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="oggetto" class="form-label">Oggetto</label>
                            <input type="text" class="form-control" id="oggetto" name="oggetto" required>
                        </div>

                        <div class="mb-3">
                            <label for="messaggio" class="form-label">Messaggio</label>
                            <textarea class="form-control" id="messaggio" name="messaggio" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Invia Messaggio</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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