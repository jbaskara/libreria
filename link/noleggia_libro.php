<?php
include("connessione.php");
session_start();

if (!isset($_SESSION['email'])) {
    echo 'Devi effettuare il login per noleggiare un libro.';
    exit;
}

$id_libro = isset($_POST['id_libro']) ? intval($_POST['id_libro']) : 0;
$email = $_SESSION['email'];

$stmt = $pdo->prepare("SELECT id_utente FROM Utenti WHERE email = ?");
$stmt->execute([$email]);
$utente = $stmt->fetch();

$id_utente = $utente['id_utente'];

$stmt = $pdo->prepare("SELECT disponibile FROM Libri WHERE id_libro = ?");
$stmt->execute([$id_libro]);
$libro = $stmt->fetch();

$stmt = $pdo->prepare("INSERT INTO Noleggi (id_utente, id_libro, data_noleggio) VALUES (?, ?, CURDATE())");
$stmt->execute([$id_utente, $id_libro]);

$stmt = $pdo->prepare("UPDATE Libri SET disponibile = FALSE WHERE id_libro = ?");
$stmt->execute([$id_libro]);

echo 'success';
?>