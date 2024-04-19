<?php
include_once 'config.php';
// Nombre d'employés à afficher par page
$employeesPerPage = 20;

// Récupérer le numéro de page actuel à partir de l'URL
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculer l'offset
$offset = ($page - 1) * $employeesPerPage;

if ($conn !== null) {
  // Requête SQL pour récupérer les employés paginés
  $sql = "SELECT Id, Matricule, Nom, Prenom, Telephone FROM Employe LIMIT ?, ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $offset, $employeesPerPage);
  $stmt->execute();
  $result = $stmt->get_result();

  // Requête SQL pour obtenir le nombre total d'employés
  $countSql = "SELECT COUNT(*) AS total FROM Employe";
  $countResult = $conn->query($countSql);
  $totalCount = $countResult->fetch_assoc()['total'];
} else {
  echo "Erreur de connexion à la base de données.";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Employés</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
  <style>
    .highlight-row {
      background-color: #cce5ff !important;
    }

    .content-wrapper {
      overflow: auto;
      max-height: calc(100vh - 200px);
      /* ajustez la hauteur selon vos besoins */
    }
  </style>
</head>

<body class="hold-transition sidebar-mini overflow-hidden">
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
              <h1 class="m-0 text-dark">Liste des Employés</h1>
            </div>
            <!-- Ajouter un bouton de recherche -->
            <div class="col-sm-6">
              <div class="float-right">
                <input type="text" id="searchInput" placeholder="Rechercher...">
                <button onclick="searchEmployee()" class="btn btn-primary">Rechercher</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.content-header -->
      <div class="pagination">
        <?php if ($page > 1): ?>
          <a href="?page=<?php echo ($page - 1); ?>" class="page-link">&laquo; Précédent</a>
        <?php endif; ?>
        <?php if ($result->num_rows > 0): ?>
          <span class="page-link"><?php echo "Page $page sur " . ceil($totalCount / $employeesPerPage); ?></span>
        <?php endif; ?>
        <?php if (($page * $employeesPerPage) < $totalCount): ?>
          <a href="?page=<?php echo ($page + 1); ?>" class="page-link">Suivant &raquo;</a>
        <?php endif; ?>
      </div>
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body table-responsive p-0">
              <table id="employeeTable" class="table table-head-fixed text-nowrap">
                <thead>
                  <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row["Matricule"] . "</td>";
                      echo "<td>" . $row["Nom"] . "</td>";
                      echo "<td>" . $row["Prenom"] . "</td>";
                      echo "<td>" . $row["Telephone"] . "</td>";
                      echo "<td><a href='detailsEmploye.php?id=" . $row["Id"] . "'>Détails</a></td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='5'>Aucun employé trouvé.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </section>
      <!-- /.content -->


      <!-- Ajoutez le script JavaScript pour la recherche -->
      <script>
        function searchEmployee() {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById("searchInput");
          filter = input.value.toUpperCase();
          table = document.getElementById("employeeTable");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            tdMatricule = tr[i].getElementsByTagName("td")[0];
            tdNom = tr[i].getElementsByTagName("td")[1];
            tdPrenom = tr[i].getElementsByTagName("td")[2];
            if (tdMatricule || tdNom || tdPrenom) {
              txtValueMatricule = tdMatricule.textContent || tdMatricule.innerText;
              txtValueNom = tdNom.textContent || tdNom.innerText;
              txtValuePrenom = tdPrenom.textContent || tdPrenom.innerText;
              if (txtValueMatricule.toUpperCase().indexOf(filter) > -1 || txtValueNom.toUpperCase().indexOf(filter) > -1 || txtValuePrenom.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }
      </script>

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
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
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

</body>

</html>