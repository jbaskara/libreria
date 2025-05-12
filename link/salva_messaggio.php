<?php
include("connessione.php");
session_start();

$nome = $email = $oggetto = $messaggio = "";
$errore = "";
$successo = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $oggetto = trim($_POST["oggetto"]);
    $messaggio = trim($_POST["messaggio"]);

    if (empty($nome) || empty($email) || empty($oggetto) || empty($messaggio)) {
        $errore = "Tutti i campi sono obbligatori.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errore = "Inserisci un'email valida.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM Utenti WHERE nome = ? AND email = ?");
        $stmt->bind_param("ss", $nome, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $errore = "Nome ed email sconosciuto!";
        } else {
            $stmt = $conn->prepare("INSERT INTO Messaggi (nome, email, oggetto, messaggio) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nome, $email, $oggetto, $messaggio);
            if ($stmt->execute()) {
                $successo = "Messaggio inviato con successo!";
                $nome = $email = $oggetto = $messaggio = "";
            } else {
                $errore = "Errore durante l'invio del messaggio.";
            }
            $stmt->close();
        }
    }
}

$conn->close();

if ($errore) {
    echo json_encode(['status' => 'error', 'message' => $errore]);
} elseif ($successo) {
    echo json_encode(['status' => 'success', 'message' => $successo]);
}
?>