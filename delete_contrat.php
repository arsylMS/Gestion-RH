<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("Location: connexion.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $contrat_id = $_GET['id'];


    $sql = "DELETE FROM Contrat WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $contrat_id);
    if ($stmt->execute()) {
        header("Location: detailsEmploye.php?id=$employee_id");
        exit();
    } else {
        echo "Erreur lors de la suppression du contrat.";
    }
} else {
    header("Location: erreur.php");
    exit();
}
?>
