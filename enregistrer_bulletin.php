<?php

require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idEmploye = $_POST['idEmploye'];
    $date = date('Y-m-d');
    $nbHeuresTravailles = $_POST['heuresParMois'];
    $tauxHoraire = $_POST['tauxHoraire'];
    $SalaireBrut = $_POST['SalaireBrut'];
    $cotisationCNSS = $_POST['cotisationCNSS'];
    $cotisationAMO = $_POST['cotisationAMO'];
    $prevelementIGR = $_POST['prevelementIGR'];
    $congesPayes = $_POST['congesPayes'];
    $congesSansSoldeMontant = $_POST['congesSansSoldeMontant'];
    $heuresSupplementaires = $_POST['heuresSupp'];
    $netAPayer = $_POST['netAPayer'];

    $sql = "INSERT INTO bulletinpaie (idEmploye, date, nbHeuresTravailles, tauxHoraire, SalaireBrut, cotisationCNSS, cotisationAMO, prevelementIGR, congesPayes, congesSansSoldeMontant, heuresSupplementaires, netAPayer) VALUES ('$idEmploye', '$date', '$nbHeuresTravailles', '$tauxHoraire', '$SalaireBrut', '$cotisationCNSS', '$cotisationAMO', '$prevelementIGR', '$congesPayes', '$congesSansSoldeMontant', '$heuresSupplementaires', '$netAPayer')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("success" => true, "message" => "Les données ont été enregistrées avec succès."));
    } else {
        echo json_encode(array("success" => false, "message" => "Erreur: " . $sql . "<br>" . mysqli_error($conn)));
    }
    mysqli_close($conn);
}
?>