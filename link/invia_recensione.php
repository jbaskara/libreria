<?php
include("connessione.php");
session_start();
header('Content-Type: application/json');

if (isset($_POST['id_libro'], $_POST['voto'], $_POST['commento']) &&
    !empty($_POST['voto']) && !empty(trim($_POST['commento']))) {

    $id_libro = $_POST['id_libro'];
    $voto = $_POST['voto'];
    $commento = trim($_POST['commento']);
    $utente = $_SESSION['nome'];

    $stmt = $pdo->prepare("INSERT INTO Recensioni (id_libro, utente, voto, commento, data_pubblicazione) VALUES (?, ?, ?, ?, NOW())");

    if ($stmt->execute([$id_libro, $utente, $voto, $commento])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Errore nel salvataggio"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Campi mancanti"]);
}