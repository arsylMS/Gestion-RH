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
} else {
    // Rediriger vers une page d'erreur si aucun ID d'employé n'est fourni
    header("Location: erreur.php");
    exit();
}
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
                            <h1 class="m-0 text-dark">Gestion de l'employé</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-header -->
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
