<?php
session_start(); 

require_once ('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {

    $connexion = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASSWORD);

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $matricule = $_POST['matricule'];
    $codeCNSS = $_POST['code_cnss'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $dateNaissance = $_POST['date_naissance'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $situationFamiliale = $_POST['situation_familiale'];


    $photo_identite_path = '';
    if (isset($_FILES['photo_identite']) && $_FILES['photo_identite']['error'] === UPLOAD_ERR_OK) {
      $tmp_name = $_FILES['photo_identite']['tmp_name'];
      $upload_dir = './img/PI/';
      $file_name = uniqid() . '_' . $_FILES['photo_identite']['name'];
      if (move_uploaded_file($tmp_name, $upload_dir . $file_name)) {
        $photo_identite_path = $upload_dir . $file_name;
      } else {
        echo "Une erreur s'est produite lors du téléchargement de la photo d'identité.";
      }
    }


    $requete = $connexion->prepare('INSERT INTO Employe (Matricule, CodeCNSS, Nom, Prenom, DateNaissance, Telephone, Adresse, SituationFamiliale, PhotoIdentite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');


    $requete->execute([$matricule, $codeCNSS, $nom, $prenom, $dateNaissance, $telephone, $adresse, $situationFamiliale, $photo_identite_path]);


    header('Location: ajouter_employe.php');
    exit(); // 
  } catch (PDOException $e) {

    echo "Erreur : " . $e->getMessage();
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ajouter un employé</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <style>
    .highlight-row {
      background-color: #cce5ff !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="img/logo.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <?php include_once 'navbar.php'; ?>

    <?php include_once 'sidebar.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Ajouter un employé</h1>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card card-warning">
            <div class="card-header">
              <h3 class="card-title">General Elements</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Matricule</label>
                      <input type="text" name="matricule" class="form-control" placeholder="Matricule">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Code CNSS</label>
                      <input type="text" name="code_cnss" class="form-control" placeholder="Code CNSS">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Nom</label>
                      <input type="text" name="nom" class="form-control" placeholder="Nom">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Prénom</label>
                      <input type="text" name="prenom" class="form-control" placeholder="Prénom">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- date input -->
                    <div class="form-group">
                      <label>Date de Naissance</label>
                      <input type="date" name="date_naissance" class="form-control">
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Téléphone</label>
                      <input type="text" name="telephone" class="form-control" placeholder="Téléphone">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <!-- textarea -->
                    <div class="form-group">
                      <label>Adresse</label>
                      <textarea class="form-control" name="adresse" rows="3" placeholder="Adresse"></textarea>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <!-- select -->
                    <div class="form-group">
                      <label>Situation Familiale</label>
                      <select class="form-control" name="situation_familiale">
                        <option value="Célibataire">Célibataire</option>
                        <option value="Marié">Marié</option>
                        <option value="Divorcé">Divorcé</option>
                        <option value="Veuf">Veuf</option>
                      </select>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- file input -->
                        <div class="form-group">
                          <label>Photo d'identité</label>
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo_identite" name="photo_identite">
                            <label class="custom-file-label" for="photo_identite">Choisir un fichier</label>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Ajouter Employé</button>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
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
    <?php include ('footer.php'); ?>
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