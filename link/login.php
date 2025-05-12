<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Libreria");

if (!isset($_POST['email'], $_POST['password'])) {
    die("Dati mancanti.");
}

$email = $_POST['email'];
$password = md5($_POST['password']);

$stmt = $conn->prepare("SELECT id_utente, nome, ruolo FROM Utenti WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($utente = $result->fetch_assoc()) {
    $_SESSION['id_utente'] = $utente['id_utente'];
    $_SESSION['email'] = $email;
    $_SESSION['ruolo'] = $utente['ruolo'];
    $_SESSION['nome'] = $utente['nome'];
    header("Location: /index.php");
} else {
    header("Location: /accedi.php?errore=1");
}
?>
