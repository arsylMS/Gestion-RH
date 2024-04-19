<?php
session_start();
require_once 'config.php';

if (isset($_GET['id'])) {
    $contrat_id = $_GET['id'];

  
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $type_contrat = $_POST['type_contrat'];
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $salaire_brut = $_POST['salaire_brut'];

        $sql_update_contrat = "UPDATE Contrat SET TypeContrat=?, DateDebut=?, DateFin=?, SalaireBrut=? WHERE Id=?";
        $stmt_update_contrat = $conn->prepare($sql_update_contrat);
        $stmt_update_contrat->bind_param("ssssi", $type_contrat, $date_debut, $date_fin, $salaire_brut, $contrat_id);
        $stmt_update_contrat->execute();

        echo '<div class="alert alert-success" role="alert">Le contrat a été modifié avec succès!</div>';
    }

    $sql_contrat = "SELECT * FROM Contrat WHERE Id=?";
    $stmt_contrat = $conn->prepare($sql_contrat);
    $stmt_contrat->bind_param("i", $contrat_id);
    $stmt_contrat->execute();
    $result_contrat = $stmt_contrat->get_result();

 if ($result_contrat->num_rows === 1) {
    $row_contrat = $result_contrat->fetch_assoc();
} else {
    $_SESSION['error_message'] = 'Contrat non trouvé!';
    echo "<script>window.location.href='gestion_contrats.php';</script>";
    exit;
}
} else {
echo "<script>window.location.href='index.php';</script>";
exit;
}
?>
        <!DOCTYPE html>
        <html lang="fr">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Modifier le contrat</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
            <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
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
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0 text-dark">Modifier le contrat</h1>
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
                                            <h3 class="card-title">Formulaire de modification</h3>
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <!-- Formulaire de modification de contrat -->
                                            <form action="" method="post">
                                                <div class="form-group">
                                                    <label for="type_contrat">Type de contrat:</label>
                                                    <input type="text" id="type_contrat" name="type_contrat" class="form-control" required value="<?php echo $row_contrat['TypeContrat']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="date_debut">Date de début:</label>
                                                    <input type="date" id="date_debut" name="date_debut" class="form-control" required value="<?php echo $row_contrat['DateDebut']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="date_fin">Date de fin:</label>
                                                    <input type="date" id="date_fin" name="date_fin" class="form-control" required value="<?php echo $row_contrat['DateFin']; ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="salaire_brut">Salaire brut:</label>
                                                    <input type="number" id="salaire_brut" name="salaire_brut" class="form-control" required value="<?php echo $row_contrat['SalaireBrut']; ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Modifier Contrat</button>
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
                <?php include_once 'footer.php'; ?>
            </div>
            <!-- ./wrapper -->

            <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/js/adminlte.min.js"></script>
             <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function showSuccessNotification() {
            var notification = document.getElementById('successNotification');
            $(notification).fadeIn();
            setTimeout(function() {
                $(notification).fadeOut();
            }, 2000); 
        }


        $(document).ready(function() {
            showSuccessNotification();
        });
    </script>
    
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

