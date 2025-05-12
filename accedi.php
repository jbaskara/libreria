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
    <title>Accedi</title>
    <link href="link/libro.png" rel="icon" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="link/login.js"></script>
    <script src="link/registrazione.js"></script>
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
                <li class="nav-item me-3"><a class="nav-link active" href="accedi.php">Accedi</a></li>
                <li class="nav-item me-3"><a class="nav-link" href="registra.php">Registra</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
    <div id="log" class="container py-4">
        <h2 class="mb-4">Login Utente</h2>
        <div id="message" class="alert" style="display:none"></div>
        <form action="link/login.php" method="POST" class="mb-4">
            <div class="col-md-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="nome@example.com" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Inserisci la tua password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button><br><br>
            <a href="registra.php">Non hai un account? Registrati</a>
        </form>
    </div><br>
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
