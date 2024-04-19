<?php
require_once 'config.php';

if (isset($_GET['matricule'])) {
    $matricule = $_GET['matricule'];

    $sql = "SELECT * FROM employe WHERE Matricule = '$matricule'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $employe = mysqli_fetch_assoc($result);
    } else {
        $message = "L'employé avec le matricule '$matricule' n'existe pas.";
    }
} else {
    header("Location: bulletin_paie.php");
    exit();
}

$sql = "SELECT SalaireBrut FROM contrat WHERE Id IN (SELECT IdContrat FROM employecontrat WHERE IdEmploye IN (SELECT Id FROM employe WHERE Matricule = '$matricule'))";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $SalaireBrut = $row['SalaireBrut'];
} else {
    $SalaireBrut = 0;
}

$nbJoursAnnee = 253; 
$tauxHoraire = $SalaireBrut / $nbJoursAnnee;

$netAPayer = 0;
$cotisationCNSS = isset($_POST['cotisationCNSS']) ? $_POST['cotisationCNSS'] : 0;
$cotisationAMO = isset($_POST['cotisationAMO']) ? $_POST['cotisationAMO'] : 0;
$prevelementIGR = isset($_POST['prevelementIGR']) ? $_POST['prevelementIGR'] : 0;
$congesSansSolde = isset($_POST['congesSansSolde']) ? $_POST['congesSansSolde'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cotisationCNSS = isset($_POST['cotisationCNSS']) ? $_POST['cotisationCNSS'] : 0;
    $cotisationAMO = isset($_POST['cotisationAMO']) ? $_POST['cotisationAMO'] : 0;
    $prevelementIGR = isset($_POST['prevelementIGR']) ? $_POST['prevelementIGR'] : 0;
    $congesSansSolde = isset($_POST['congesSansSolde']) ? $_POST['congesSansSolde'] : 0;

    $SalaireBrutCalcul = ($nbJoursAnnee - $congesSansSolde) * $tauxHoraire;

    $netAPayer = $SalaireBrutCalcul - $cotisationCNSS - $cotisationAMO - $prevelementIGR;
}

?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcul du Bulletin de Paie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }

        .image-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto 10px;
        }

        .profile-image {
            width: 100%;
            height: auto;
            border-radius: 50%;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
     <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
<div class="wrapper">
    <!-- Navbar -->
    <?php include_once 'navbar.php'; ?>
    <!-- Main Sidebar Container -->
    <?php include_once 'sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Colonne gauche pour le formulaire de calcul -->
                    <div class="col-md-6">
                        <!-- Card pour le formulaire de calcul du bulletin de paie -->
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Formulaire de calcul du bulletin de paie</h3>
                            </div>
                            <div class="card-body">
                                <!-- Formulaire pour le calcul du bulletin de paie -->
                                <form id="calculForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <!-- Champs cachés pour l'ID de l'employé et le matricule -->
                                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                                    <input type="hidden" name="matricule" value="<?php echo $matricule; ?>">

                                    <!-- Autres champs du formulaire -->
                                    <div class="form-group">
                                        <label for="SalaireBrut">Salaire brut :</label>
                                        <input type="text" class="form-control" id="SalaireBrut" name="SalaireBrut" value="<?php echo number_format($SalaireBrut, 2, ',', ' '); ?> DH" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="tauxHoraire">Taux horaire :</label>
                                        <input type="text" class="form-control" id="tauxHoraire" name="tauxHoraire" value="<?php echo number_format($tauxHoraire, 2, ',', ' '); ?> DH" readonly>
                                    </div>


                                    <div class="form-group">
                                        <label for="nbJoursTravailles">Nombre de jours travaillés :</label>
                                        <input type="number" class="form-control" id="nbJoursTravailles" name="nbJoursTravailles" value="253" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="cotisationCNSS">Cotisation CNSS :</label>
                                        <input type="number" class="form-control" id="cotisationCNSS" name="cotisationCNSS" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="cotisationAMO">Cotisation AMO :</label>
                                        <input type="number" class="form-control" id="cotisationAMO" name="cotisationAMO" value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="prevelementIGR">Prélèvement IGR :</label>
                                        <input type="number" class="form-control" id="prevelementIGR" name="prevelementIGR" value="" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="congesPayes">Congés payés :</label>
                                        <input type="number" class="form-control" id="congesPayes" name="congesPayes" value="Valeur par défaut" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="congesSansSolde">Congés sans solde :</label>
                                        <input type="number" class="form-control" id="congesSansSolde" name="congesSansSolde" value="" required>
                                    </div>

                                    <button id="calculButton" type="button" class="btn btn-primary">Calculer le bulletin de paie</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->

                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Détails du Calcul</h3>
                            </div>
                            <div class="card-body">
                            <div id="notificationContainer"></div>
                                <p>Voici les détails du calcul effectué :</p>
                                <table id="resultTable" class="table">
                                    <thead>
                                    <tr>
                                        <th>Élément</th>
                                        <th>Montant</th>
                                        <th>Calcul</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Salaire brut</td>
                                        <td><?php echo number_format($SalaireBrut, 2, ',', ' '); ?> DH</td>
                                        <td>253 * <?php echo number_format($tauxHoraire, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    <tr>
                                        <td>Cotisation CNSS</td>
                                        <td><?php echo number_format($cotisationCNSS, 2, ',', ' '); ?> DH</td>
                                        <td><?php echo number_format($cotisationCNSS, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    <tr>
                                        <td>Cotisation AMO</td>
                                        <td><?php echo number_format($cotisationAMO, 2, ',', ' '); ?> DH</td>
                                        <td><?php echo number_format($cotisationAMO, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    <tr>
                                        <td>Prélèvement IGR</td>
                                        <td><?php echo number_format($prevelementIGR, 2, ',', ' '); ?> DH</td>
                                        <td><?php echo number_format($prevelementIGR, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    <tr>
                                        <td>Total cotisation</td>
                                        <td> -- </td>
                                        <td> -- </td>
                                    </tr>

                                    <tr>
                                        <td>Congés sans solde</td>
                                        <td><?php echo number_format($congesSansSolde * $tauxHoraire, 2, ',', ' '); ?> DH</td>
                                        <td><?php echo $congesSansSolde; ?> * <?php echo number_format($tauxHoraire, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    <tr>
                                        <td>Net à payer</td>
                                        <td id="netAPayer">0,00 DH</td>
                                        <td><?php echo number_format($SalaireBrut, 2, ',', ' '); ?> - <?php echo number_format($cotisationCNSS, 2, ',', ' '); ?> - <?php echo number_format($cotisationAMO, 2, ',', ' '); ?> - <?php echo number_format($prevelementIGR, 2, ',', ' '); ?> DH</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.card -->
                    
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Historique des bulletins de paie</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="align-middle">Bulletin numéro</th>
                                                <th class="align-middle">Salaire Net</th>
                                                <th class="align-middle">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Supposons que vous ayez déjà établi une connexion à la base de données $conn

                                            // Requête SQL pour récupérer l'ID de l'employé en fonction de son matricule
                                            $sql_id_employe = "SELECT Id FROM employe WHERE Matricule = '$matricule'";
                                            $result_id_employe = mysqli_query($conn, $sql_id_employe);

                                            if ($result_id_employe && mysqli_num_rows($result_id_employe) > 0) {
                                                $row_id_employe = mysqli_fetch_assoc($result_id_employe);
                                                $idEmploye = $row_id_employe['Id'];

                                                // Requête SQL pour récupérer l'historique des bulletins de paie de l'employé en fonction de son ID
                                                $sql_bulletin_paie = "SELECT idBulletin, netAPayer, date FROM bulletinpaie WHERE idEmploye = $idEmploye";
                                                $result_bulletin_paie = mysqli_query($conn, $sql_bulletin_paie);

                                                if ($result_bulletin_paie && mysqli_num_rows($result_bulletin_paie) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result_bulletin_paie)) {
                                                        echo "<tr>";
                                                        echo "<td class='align-middle'># " . $row['idBulletin'] . "</td>";
                                                        echo "<td class='align-middle'>" . number_format($row['netAPayer'], 2, ',', ' ') . " DH</td>";
                                                        echo "<td class='align-middle'>" . $row['date'] . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3'>Aucun bulletin de paie trouvé.</td></tr>";
                                                }
                                            } else {
                                                echo "<tr><td colspan='3'>Employé non trouvé.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Informations sur l'employé</h3>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="image-container">
                                        <img src="<?php echo $employe['PhotoIdentite']; ?>" class="profile-image" alt="Photo de l'employé">
                                    </div>
                                </div>
                                <p><strong>Matricule:</strong> <?php echo $employe['Matricule']; ?></p>
                                <p><strong>Code CNSS:</strong> <?php echo $employe['CodeCNSS']; ?></p>
                                <p><strong>Nom:</strong> <?php echo $employe['Nom']; ?></p>
                                <p><strong>Prénom:</strong> <?php echo $employe['Prenom']; ?></p>
                                <p><strong>Date de Naissance:</strong> <?php echo $employe['DateNaissance']; ?></p>
                                <p><strong>Téléphone:</strong> <?php echo $employe['Telephone']; ?></p>
                                <p><strong>Adresse:</strong> <?php echo $employe['Adresse']; ?></p>
                                <p><strong>Situation Familiale:</strong> <?php echo $employe['SituationFamiliale']; ?></p>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include_once 'footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<script>
$(document).ready(function() {
    $("#calculButton").click(function() {
        var nbJoursTravailles = $("#nbJoursTravailles").val();
        var congesSansSolde = $("#congesSansSolde").val();
        var cotisationCNSS = $("#cotisationCNSS").val(); 
        var cotisationAMO = $("#cotisationAMO").val(); 
        var prevelementIGR = $("#prevelementIGR").val(); 
        
        var congesSansSoldeMontant = (10 * congesSansSolde) * <?php echo $tauxHoraire; ?>;
        var SalaireBrut = (nbJoursTravailles - congesSansSolde) * <?php echo $tauxHoraire; ?>;
        var netAPayer = SalaireBrut - cotisationCNSS - cotisationAMO - prevelementIGR - congesSansSoldeMontant;
        
        $("#netAPayerValue").val(netAPayer.toFixed(2));
        $("#resultTable tbody").empty().append(
            "<tr><td>Salaire brut</td><td><?php echo number_format($SalaireBrut, 2, ',', ' '); ?> DH</td><td>253 * <?php echo number_format($tauxHoraire, 2, ',', ' '); ?> DH</td></tr>" +
            "<tr><td>Cotisation CNSS</td><td>" + cotisationCNSS + " DH</td><td>" + cotisationCNSS + " DH</td></tr>" +
            "<tr><td>Cotisation AMO</td><td>" + cotisationAMO + " DH</td><td>" + cotisationAMO + " DH</td></tr>" +
            "<tr><td>Prélèvement IGR</td><td>" + prevelementIGR + " DH</td><td>" + prevelementIGR + " DH</td></tr>" +
            "<tr><td>Total cotisation IGR</td><td>" + -- + " DH</td><td>" + -- + " DH</td></tr>" +
            "<tr><td>Congés sans solde</td><td>" + congesSansSoldeMontant.toFixed(2) + " DH</td><td>" + (congesSansSolde) + " * <?php echo number_format($tauxHoraire, 2, ',', ' '); ?> DH</td></tr>" +
            "<tr><td>Net à payer</td><td id='netAPayer'>" + netAPayer.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td><td><?php echo number_format($SalaireBrut, 2, ',', ' '); ?> - " + cotisationCNSS + " - " + cotisationAMO + " - " + prevelementIGR + " - " + congesSansSoldeMontant + " DH</td></tr>"
        );
        $("#netAPayer").text(netAPayer.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH");
    });
});
</script>
<input type="hidden" id="netAPayerValue" name="netAPayerValue" value="0.00">
<input type="hidden" id="idEmploye" name="idEmploye" value="<?php echo $employe['Id']; ?>">
<input type="hidden" id="tauxHoraireValue" name="tauxHoraireValue" value="<?php echo $tauxHoraire; ?>">
<input type="hidden" id="SalaireBrutValue" name="SalaireBrutValue" value="<?php echo $SalaireBrut; ?>">

<script>
$(document).ready(function() {
    $("#calculButton").click(function() {
        var idEmploye = $("#idEmploye").val();

var tauxHoraire = parseFloat($("#tauxHoraireValue").val());
var SalaireBrut = parseFloat($("#SalaireBrutValue").val());

        if (isNaN(tauxHoraire)) {
            console.error("Erreur : La valeur de tauxHoraire n'est pas valide.");
            return; 
        }

        var nbJoursTravailles = $("#nbJoursTravailles").val();
        var congesSansSolde = $("#congesSansSolde").val();
        var cotisationCNSS = $("#cotisationCNSS").val(); 
        var cotisationAMO = $("#cotisationAMO").val(); 
        var prevelementIGR = $("#prevelementIGR").val(); 

      //  var cotis = $("#cotisationCNSS").val();  + $("#cotisationAMO").val(); + $("#prevelementIGR").val(); 
        
        var congesSansSoldeMontant = (congesSansSolde * 10) * tauxHoraire;
        var SalaireBrutCalcul = (nbJoursTravailles - congesSansSolde) * tauxHoraire;
        var cotis = parseFloat(cotisationCNSS) + parseFloat(cotisationAMO) + parseFloat(prevelementIGR);
        var netAPayer = SalaireBrutCalcul - cotisationCNSS - cotisationAMO - prevelementIGR - congesSansSoldeMontant;

        $("#netAPayerValue").val(netAPayer.toFixed(2));
        $("#resultTable tbody").empty().append(
            "<tr><td>Salaire brut</td><td>" + SalaireBrut.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td><td>" + nbJoursTravailles + " * " + tauxHoraire.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td></tr>" +
            "<tr><td>Cotisation CNSS</td><td>" + cotisationCNSS + " DH</td><td>" + cotisationCNSS + " DH</td></tr>" +
            "<tr><td>Cotisation AMO</td><td>" + cotisationAMO + " DH</td><td>" + cotisationAMO + " DH</td></tr>" +
            "<tr><td>Prélèvement IGR</td><td>" + prevelementIGR + " DH</td><td>" + prevelementIGR + " DH</td></tr>" +
            "<tr><td>Total Cotisation</td><td>" + cotis + " DH</td><td>" +  cotisationCNSS + " - " + cotisationAMO + " - " + prevelementIGR  + " DH</td></tr>" +
            "<tr><td>Congés sans solde</td><td>" + congesSansSoldeMontant.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td><td>" + (congesSansSolde * 10) + " * " + tauxHoraire.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td></tr>" +
            "<tr><td>Net à payer</td><td id='netAPayer'>" + netAPayer.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH</td><td>" + SalaireBrut.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " - " + cotis + " - " +congesSansSoldeMontant.toFixed(2)+" DH</td></tr>"
        );

        $("#netAPayer").text(netAPayer.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,') + " DH");

        $.ajax({
            type: "POST",
            url: "enregistrer_bulletin.php",
            data: { 
                idEmploye: $("#idEmploye").val(),
                nbJoursTravailles: nbJoursTravailles,
                congesSansSoldeMontant: congesSansSoldeMontant.toFixed(2),
                cotisationCNSS: cotisationCNSS,
                cotisationAMO: cotisationAMO,
                prevelementIGR: prevelementIGR,
                tauxHoraire: tauxHoraire.toFixed(2),
                netAPayer: netAPayer.toFixed(2),
                SalaireBrut: SalaireBrut.toFixed(2),
                congesPayes: $("#congesPayes").val()
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    $("#notificationContainer").html('<div class="alert alert-success" role="alert">' + result.message + '</div>');

                    setTimeout(function() {
                        $("#notificationContainer").html('');
                    }, 5000); 
                } else {
                    $("#notificationContainer").html('<div class="alert alert-danger" role="alert">' + result.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    });
});
</script>
</body>
</html>
