<?php
session_start();
require_once 'config.php';

// Vérifier si l'ID de l'employé est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'employé depuis l'URL
    $employe_id = $_GET['id'];

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    
// Vérifier si l'ID de l'employé est passé en paramètre
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'employé depuis l'URL
    $employe_id = $_GET['id'];

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    // Vérifier si le formulaire de suppression a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
        // Récupérer l'ID du contrat à supprimer
        $contrat_id = $_POST['delete_id'];

        // Requête pour supprimer le contrat de la table Contrat
        $sql_delete_contrat = "DELETE FROM Contrat WHERE Id = ?";
        $stmt_delete_contrat = $conn->prepare($sql_delete_contrat);
        $stmt_delete_contrat->bind_param("i", $contrat_id);
        $stmt_delete_contrat->execute();

        // Requête pour supprimer les entrées associées dans la table EmployeContrat
        $sql_delete_employe_contrat = "DELETE FROM EmployeContrat WHERE IdContrat = ?";
        $stmt_delete_employe_contrat = $conn->prepare($sql_delete_employe_contrat);
        $stmt_delete_employe_contrat->bind_param("i", $contrat_id);
        $stmt_delete_employe_contrat->execute();

        // Rediriger vers la page de gestion des contrats de l'employé
        header("Location: gestion_contrats.php?id=$employe_id");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur si aucun ID d'employé n'est fourni
    header("Location: erreur.php");
    exit();
}

    // Vérifier si le formulaire a été soumis
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données du formulaire
        $type_contrat = $_POST['type_contrat'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $salaire_brut = $_POST['salaire_brut'];

        // Insérer les données du contrat dans la table Contrat
        $sql_contrat = "INSERT INTO Contrat (TypeContrat, DateDebut, DateFin, SalaireBrut) VALUES (?, ?, ?, ?)";
        $stmt_contrat = $conn->prepare($sql_contrat);
        $stmt_contrat->bind_param("sssd", $type_contrat, $date_debut, $date_fin, $salaire_brut);
        $stmt_contrat->execute();
        $contrat_id = $stmt_contrat->insert_id; // Récupérer l'ID du contrat inséré

        // Insérer les données dans la table EmployeContrat
        $sql_employe_contrat = "INSERT INTO EmployeContrat (IdEmploye, IdContrat, DateDebut, DateFin) VALUES (?, ?, ?, ?)";
        $stmt_employe_contrat = $conn->prepare($sql_employe_contrat);
        $stmt_employe_contrat->bind_param("iiss", $employe_id, $contrat_id, $date_debut, $date_fin);
        $stmt_employe_contrat->execute();

        // Rediriger vers la page de détails de l'employé
        header("Location: detailsEmploye.php?id=$employe_id");
        exit();
    }
} else {
    // Rediriger vers une page d'erreur si aucun ID d'employé n'est fourni
    header("Location: url=gestion_contrats.php?id=$employee_id");
    exit();
}


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des contrats</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        /* CSS pour définir une hauteur fixe et activer le défilement */
        .scrollable-card {
            max-height: 500px; /* Hauteur maximale de la carte */
            overflow-y: auto; /* Activer le défilement vertical si nécessaire */
        }
        
    </style>
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
          <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>
        <!-- Navbar -->
        <?php include_once 'navbar.php'; ?>
        <!-- Sidebar -->
        <?php include_once 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Gestion contrat de travail</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Ajouter un contrat -->
                <div class="card h-100">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter un contrat</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Formulaire d'ajout de contrat -->
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="type_contrat">Type de contrat:</label>
                                <input type="text" id="type_contrat" name="type_contrat" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date_debut">Date de début:</label>
                                <input type="date" id="date_debut" name="date_debut" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="date_fin">Date de fin:</label>
                                <input type="date" id="date_fin" name="date_fin" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="salaire_brut">Salaire brut:</label>
                                <input type="number" id="salaire_brut" name="salaire_brut" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter Contrat</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h3 class="card-title">Contrat en cours</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body scrollable-card"> <!-- Ajoutez la classe CSS "scrollable-card" -->
            <!-- Contenu des contrats -->
            <?php
            // Requête SQL pour récupérer les contrats en cours de l'employé
            $sql_contrats_en_cours = "SELECT Contrat.* FROM Contrat
                                    INNER JOIN EmployeContrat ON Contrat.Id = EmployeContrat.IdContrat
                                    WHERE EmployeContrat.IdEmploye = ?";
            $stmt_contrats_en_cours = $conn->prepare($sql_contrats_en_cours);
            $stmt_contrats_en_cours->bind_param("i", $employe_id);
            $stmt_contrats_en_cours->execute();
            $result_contrats_en_cours = $stmt_contrats_en_cours->get_result();

            // Vérifier s'il y a des contrats en cours
            if ($result_contrats_en_cours->num_rows > 0) {
                while ($row = $result_contrats_en_cours->fetch_assoc()) {
                    // Afficher les détails de chaque contrat
                    echo "<p><strong>Type de contrat:</strong> " . $row['TypeContrat'] . "</p>";
                    echo "<p><strong>Date de début:</strong> " . $row['DateDebut'] . "</p>";
                    echo "<p><strong>Date de fin:</strong> " . $row['DateFin'] . "</p>";
                    echo "<p><strong>Salaire brut:</strong> " . $row['SalaireBrut'] . "</p>";
                    
                    // Edit link/button
                    echo "<a href='edit_contrat.php?id=" . $row['Id'] . "' class='btn btn-sm btn-primary'>Modifier</a>";
                    
                  // Delete link/button
                    echo "<form method='POST' style='display: inline;'>
                    <input type='hidden' name='delete_id' value='" . $row['Id'] . "'>
                    <button type='submit' class='btn btn-sm btn-danger'>Supprimer</button>
                    </form>";

                }
            } else {
                // Afficher un message si aucun contrat en cours n'est trouvé
                echo "Aucun contrat en cours trouvé.";
            }
            ?>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>

        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include_once 'footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
    <!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>
