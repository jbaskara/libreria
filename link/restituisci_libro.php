<?php
include("connessione.php");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

$titolo = $_POST['titolo'];
$email = $_SESSION['email'];

$stmt = $pdo->prepare("SELECT id_utente FROM Utenti WHERE email = ?");
$stmt->execute([$email]);
$utente = $stmt->fetch();

if (!$utente) {
    echo "Utente non trovato.";
    exit;
}

$id_utente = $utente['id_utente'];

$stmt = $pdo->prepare("
    SELECT N.id_noleggio, L.id_libro
    FROM Noleggi N
    JOIN Libri L ON N.id_libro = L.id_libro
    WHERE N.id_utente = ? AND L.titolo = ? AND N.data_restituzione IS NULL
    LIMIT 1
");
$stmt->execute([$id_utente, $titolo]);
$noleggio = $stmt->fetch();

if (!$noleggio) {
    echo "Nessun noleggio attivo trovato.";
    exit;
}

$stmt = $pdo->prepare("UPDATE Noleggi SET data_restituzione = CURDATE() WHERE id_noleggio = ?");
$stmt->execute([$noleggio['id_noleggio']]);

$stmt = $pdo->prepare("UPDATE Libri SET disponibile = TRUE WHERE id_libro = ?");
$stmt->execute([$noleggio['id_libro']]);

header("Location: /noleggi_utente.php");
exit;
?>
