<?php
session_start();
require_once 'config.php';

if (isset($_GET['id'])) {
    $employe_id = $_GET['id'];

    if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {

        header("Location: connexion.php");
        exit();
    }

    mettreAJourStatutCongesTermines($conn);

    $sql_jours_conges_utilises = "SELECT SUM(DATEDIFF(DateFin, DateDebut) + 1) AS total_jours FROM Conge WHERE YEAR(DateDebut) = YEAR(CURDATE()) AND Id IN (SELECT IdConge FROM EmployeConge WHERE IdEmploye = ?)";
    $stmt_jours_conges_utilises = $conn->prepare($sql_jours_conges_utilises);
    $stmt_jours_conges_utilises->bind_param("i", $employe_id);
    $stmt_jours_conges_utilises->execute();
    $result_jours_conges_utilises = $stmt_jours_conges_utilises->get_result();
    $row_jours_conges_utilises = $result_jours_conges_utilises->fetch_assoc();
    $jours_conge_utilises = $row_jours_conges_utilises['total_jours'] ?? 0;
    $jours_conge_alloues = 45;
    $jours_conge_restants = $jours_conge_alloues - $jours_conge_utilises;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type_conge']) && isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
        $type_conge = $_POST['type_conge'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

        $start_date = new DateTime($date_debut);
        $end_date = new DateTime($date_fin);
        $interval = $start_date->diff($end_date);
        $jours_demandes = $interval->days + 1;

        if ($jours_demandes <= $jours_conge_restants) {
            $sql_insert_conge = "INSERT INTO Conge (TypeConge, DateDebut, DateFin, Statut) VALUES (?, ?, ?, 'En cours')";
            $stmt_insert_conge = $conn->prepare($sql_insert_conge);
            $stmt_insert_conge->bind_param("sss", $type_conge, $date_debut, $date_fin);
            $stmt_insert_conge->execute();
            $conge_id = $stmt_insert_conge->insert_id;

            $sql_insert_employe_conge = "INSERT INTO EmployeConge (IdEmploye, IdConge) VALUES (?, ?)";
            $stmt_insert_employe_conge = $conn->prepare($sql_insert_employe_conge);
            $stmt_insert_employe_conge->bind_param("ii", $employe_id, $conge_id);
            $stmt_insert_employe_conge->execute();

            $jours_conge_utilises += $jours_demandes;
            $jours_conge_restants -= $jours_demandes;
            header("Location: gestionConge.php?id=" . $employe_id);
            exit();

        } else {
            $error_message = "Le nombre de jours demandés dépasse les jours de congé restants.";
        }
    }
} else {

    header("Location: gestion_contrats.php");
    exit();
}

function mettreAJourStatutCongesTermines($conn)
{
    $sql_conges_termines = "SELECT Id FROM Conge WHERE Statut = 'En cours' AND DateFin < CURDATE()";
    $result_conges_termines = $conn->query($sql_conges_termines);
    if ($result_conges_termines->num_rows > 0) {
        while ($row = $result_conges_termines->fetch_assoc()) {
            $conge_id = $row['Id'];
            $sql_update_statut = "UPDATE Conge SET Statut = 'Terminé' WHERE Id = $conge_id";
            $conn->query($sql_update_statut);
        }
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des congés</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
    <style>
        /* CSS pour définir une hauteur fixe et activer le défilement */
        .scrollable-card {
            max-height: 500px;
            /* Hauteur maximale de la carte */
            overflow-y: auto;
            /* Activer le défilement vertical si nécessaire */
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
        <!-- Sidebar -->
        <?php include_once 'sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h3 class="card-title">Congés en cours</h3>
                                    <span
                                        class="<?php echo ($jours_conge_restants >= 0) ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo $jours_conge_restants; ?> jour(s) restant(s)
                                    </span>

                                </div>

                                <!-- /.card-header -->
                                <div class="card-body scrollable-card">
                                    <!-- Contenu des congés -->
                                    <?php
                                    // Vérifier s'il y a des congés en cours
                                    $sql_conges_en_cours = "SELECT Conge.* FROM Conge
                                                            INNER JOIN EmployeConge ON Conge.Id = EmployeConge.IdConge
                                                            WHERE EmployeConge.IdEmploye = ?";
                                    $stmt_conges_en_cours = $conn->prepare($sql_conges_en_cours);
                                    $stmt_conges_en_cours->bind_param("i", $employe_id);
                                    $stmt_conges_en_cours->execute();
                                    $result_conges_en_cours = $stmt_conges_en_cours->get_result();

                                    // Vérifier s'il y a des congés en cours
                                    if ($result_conges_en_cours !== null && $result_conges_en_cours->num_rows > 0) {
                                        while ($row = $result_conges_en_cours->fetch_assoc()) {
                                            // Afficher les détails de chaque congé avec la couleur appropriée pour le statut
                                            $statut_color = ($row['Statut'] === 'En cours') ? 'text-success' : 'text-danger';
                                            echo "<p><strong>Type de congé:</strong> " . $row['TypeConge'] . "</p>";
                                            echo "<p><strong>Date de début:</strong> " . $row['DateDebut'] . "</p>";
                                            echo "<p><strong>Date de fin:</strong> " . $row['DateFin'] . "</p>";
                                            echo "<p><strong>Statut:</strong> <span class='$statut_color'>" . $row['Statut'] . "</span></p>";
                                            echo "<hr>";
                                        }
                                    } else {
                                        // Afficher un message si aucun congé en cours n'est trouvé
                                        echo "Aucun congé en cours trouvé.";
                                    }
                                    ?>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title">Ajouter un congé</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Formulaire d'ajout de congé -->
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="type_conge">Type de congé:</label>
                                            <input type="text" id="type_conge" name="type_conge" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="date_debut">Date de début:</label>
                                            <input type="date" id="date_debut" name="date_debut" class="form-control"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label for="date_fin">Date de fin:</label>
                                            <input type="date" id="date_fin" name="date_fin" class="form-control"
                                                required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Ajouter Congé</button>
                                        <?php if (isset($error_message)): ?>
                                            <div class="text-danger"><?php echo $error_message; ?></div>
                                        <?php endif; ?>
                                    </form>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Footer</strong>
        </footer>
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