<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Libreria");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($nome) || empty($cognome) || empty($email) || empty($password)) {
        header("Location: registra.php?error=compilare_tutti_i_campi");
        exit;
    }

    $sql = "SELECT * FROM Utenti WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            header("Location: /registra.php?error=email_gia_registrata");
            exit;
        }
        $stmt->close();
    }

    $password = md5($password);

    $sql = "INSERT INTO Utenti (nome, cognome, email, password, ruolo) VALUES (?, ?, ?, ?, 'utente')";
    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("ssss", $nome, $cognome, $email, $password);

        if ($stmt->execute()) {
            header("Location: /accedi.php?successo=registrazione_completata");
        } else {
            header("Location: /registra.php?error=errore_nella_registrazione");
        }

        $stmt->close();
    } else {
        header("Location: /registra.php?error=errore_query");
    }

    $conn->close();
}
?>