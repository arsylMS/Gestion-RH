<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("Location: connexion.php");
    exit();
}

if (isset($_GET['id'])) {
    $employee_id = $_GET['id'];

    $sql = "SELECT * FROM Employe WHERE Id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
        
        $stmt->close();
    } else {
        header("Location: erreur.php");
        exit();
    }
} else {
    header("Location: erreur.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['contrat_id'], $_POST['type_contrat'], $_POST['date_debut'], $_POST['date_fin'], $_POST['salaire_brut'])) {
        $contrat_id = $_POST['contrat_id'];
        $type_contrat = $_POST['type_contrat'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $salaire_brut = $_POST['salaire_brut'];

        $sql = "UPDATE Contrat SET TypeContrat = ?, DateDebut = ?, DateFin = ?, SalaireBrut = ? WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $type_contrat, $date_debut, $date_fin, $salaire_brut, $contrat_id);
        if ($stmt->execute()) {
            echo "Les modifications ont été enregistrées avec succès.";

            echo "ID de l'employé: $employee_id";

            header("refresh:2; url=gestion_contrats.php?id=$employee_id");
            exit();

        } else {
            echo "Erreur lors de la mise à jour du contrat.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
?>
