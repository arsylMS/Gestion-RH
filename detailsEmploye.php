<?php
session_start();
if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
    header("Location: connexion.php");
    exit();
}

require_once 'config.php';


if (isset($_GET['id'])) {

    $employe_id = $_GET['id'];
    $sql = "SELECT * FROM Employe WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employe_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $employe = $result->fetch_assoc();
    } else {

        header("Location: erreur.php");
        exit();
    }
    $stmt->close();
    $conn->close();
} else {
    header("Location: erreur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'employé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">

    <style>
        .image-container {
            width: 200px;
            /* Définir la largeur souhaitée du cadre */
            height: 200px;
            /* Définir la hauteur souhaitée du cadre */
            overflow: hidden;
            /* Empêcher le débordement du contenu */
            margin: 0 auto;
            /* Centrer horizontalement le cadre */
            border-radius: 50%;
            /* Rendre le cadre circulaire */
            border: 2px solid #ccc;
            /* Ajouter une bordure */
        }

        .profile-image {
            width: 100%;
            /* Assurer que l'image occupe toute la largeur du cadre */
            height: auto;
            /* Adapter la hauteur en fonction de la largeur */
            display: block;
            /* Assurer que l'image est centrée verticalement */
            margin: 0 auto;
            /* Centrer l'image horizontalement */
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
                            <h1 class="m-0 text-dark">Détails de l'employé</h1>
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Informations de l'employé</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Afficher la photo de l'employé -->
                                    <div class="text-center">
                                        <div class="image-container">
                                            <img src="<?php echo $employe['PhotoIdentite']; ?>" class="profile-image"
                                                alt="Photo de l'employé">
                                        </div>
                                    </div>
                                    <p><strong>Matricule:</strong> <?php echo $employe['Matricule']; ?></p>
                                    <p><strong>Code CNSS:</strong> <?php echo $employe['CodeCNSS']; ?></p>
                                    <p><strong>Nom:</strong> <?php echo $employe['Nom']; ?></p>
                                    <p><strong>Prénom:</strong> <?php echo $employe['Prenom']; ?></p>
                                    <p><strong>Date de Naissance:</strong> <?php echo $employe['DateNaissance']; ?></p>
                                    <p><strong>Téléphone:</strong> <?php echo $employe['Telephone']; ?></p>
                                    <p><strong>Adresse:</strong> <?php echo $employe['Adresse']; ?></p>
                                    <p><strong>Situation Familiale:</strong>
                                        <?php echo $employe['SituationFamiliale']; ?></p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Autres actions</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Liens stylisés avec des icônes -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="gestion_contrats.php?id=<?php echo $employe_id; ?>"
                                            class="text-decoration-none">
                                            <div>
                                                <i class="fas fa-file-contract mr-2"></i>
                                                <span>Gestion Contrat</span>
                                            </div>
                                        </a>
                                        </a>
                                        <a href="gestionConge.php?id=<?php echo $employe_id; ?>"
                                            class="text-decoration-none">
                                            <div>
                                                <i class="fas fa-file-contract mr-2"></i>
                                                <span>Gestion Congé</span>
                                            </div>
                                        </a>
                                        <a href="gestion_employes.php?id=<?php echo $employe_id; ?>"
                                            class="text-decoration-none">
                                            <div>
                                                <i class="fas fa-users mr-2"></i>
                                                <span>Gestion Employé</span>
                                            </div>
                                        </a>
                                    </div>
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
        <?php include_once 'footer.php'; ?>
    </div>
    <!-- ./wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>

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