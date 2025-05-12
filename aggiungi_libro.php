<?php
include("link/connessione.php");
session_start();
$is_admin = (isset($_SESSION['email']) && $_SESSION['email'] === 'admin@libreria.it');
$utente_loggato = isset($_SESSION['nome']) ? $_SESSION['nome'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $is_admin) {

    $titolo = $_POST['nome'];
    $autore = $_POST['autore'];
    $anno = $_POST['anno'];
    $genere = implode(",", $_POST['genere']); 
    $lingua = $_POST['lingua'];

    if (isset($_FILES['copertina']) && $_FILES['copertina']['error'] == 0) {
        $file_tmp = $_FILES['copertina']['tmp_name'];
        $file_name = $_FILES['copertina']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (in_array($file_ext, ['jpg', 'jpeg', 'png'])) {
            $file_path = 'link/copertine/' . $file_name;
            move_uploaded_file($file_tmp, $file_path);
        } else {
            echo "Formato file non valido. Usa un'immagine PNG o JPG.";
            exit;
        }
    } else {
        echo "Errore nel caricamento della copertina.";
        exit;
    }

    $query = "INSERT INTO Libri (titolo, autore, anno_pubblicazione, genere, copertina, lingua) 
              VALUES ('$titolo', '$autore', '$anno', '$genere', '$file_path', '$lingua')";

    header('Content-Type: application/json');

    if ($conn->query($query)) {
        echo json_encode([
            'success' => true,
            'message' => 'Libro aggiunto con successo!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Errore nell\'aggiunta del libro: ' . $conn->error
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Libro</title>
    <link rel="icon" type="image/x-icon" href="link/libro.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="link/aggiungi_libro.js"></script>
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
                                <li class="nav-item me-3"><a class="nav-link" href="noleggi_admin.php">Gestione noleggi</a></li>
                                <li class="nav-item me-3"><a class="nav-link" href="messaggi.php">Messaggi</a></li>
                                <li class="nav-item me-3"><a class="nav-link active" href="aggiungi_libro.php">Aggiungi libro</a></li>
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
        <h1 class="mb-4">Aggiungi un Nuovo Libro</h1>
        <div id="alert-container"></div>
            <form id="aggiungi-libro-form" action="aggiungi_libro.php" method="POST" enctype="multipart/form-data">
                <div class="col-md-4 mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="autore" class="form-label">Autore:</label>
                    <input type="text" id="autore" name="autore" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="anno" class="form-label">Anno:</label>
                    <input type="number" id="anno" name="anno" class="form-control" min="1000" max="2025" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Genere:</label><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Romanzo">
                        <label class="form-check-label">Romanzo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Saggio">
                        <label class="form-check-label">Saggio</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Biografia">
                        <label class="form-check-label">Biografia</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Fantasy">
                        <label class="form-check-label">Fantasy</label>
                    </div><br>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Giallo">
                        <label class="form-check-label">Giallo</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Horror">
                        <label class="form-check-label">Horror</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Storico">
                        <label class="form-check-label">Storico</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="genere[]" value="Altro">
                        <label class="form-check-label">Altro</label>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="lingua" class="form-label">Lingua:</label>
                    <select id="lingua" name="lingua" class="form-select" required>
                        <option value="italiano">Italiano</option>
                        <option value="inglese">Inglese</option>
                        <option value="francese">Francese</option>
                        <option value="tedesco">Tedesco</option>
                        <option value="spagnolo">Spagnolo</option>
                        <option value="altro">Altro</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="copertina" class="form-label">Copertina (png, jpg):</label>
                    <input type="file" id="copertina" name="copertina" class="form-control" accept="image/png, image/jpeg" required>
                </div>
                <button type="submit" class="btn btn-primary">Aggiungi Libro</button><br>
                <a href="index.php" class="btn btn-secondary mt-3">Torna alla Home</a>
            </form>
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