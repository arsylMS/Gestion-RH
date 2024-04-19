<?php
session_start();
require_once 'config.php';

// Vérifier si l'ID de l'employé est passé en paramètre dans l'URL
if (isset($_GET['id'])) {
    // Récupérer l'ID de l'employé depuis l'URL
    $employe_id = $_GET['id'];

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION["user_logged_in"]) || $_SESSION["user_logged_in"] !== true) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: connexion.php");
        exit();
    }

    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les nouvelles valeurs des champs du formulaire
        $matricule = $_POST['matricule'];
        $code_cnss = $_POST['code_cnss'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $date_naissance = $_POST['date_naissance'];
        $telephone = $_POST['telephone'];
        $adresse = $_POST['adresse'];
        $situation_familiale = $_POST['situation_familiale'];

        // Mettre à jour les informations de l'employé dans la base de données
        $sql = "UPDATE employe SET Matricule=?, CodeCNSS=?, Nom=?, Prenom=?, DateNaissance=?, Telephone=?, Adresse=?, SituationFamiliale=? WHERE Id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssi", $matricule, $code_cnss, $nom, $prenom, $date_naissance, $telephone, $adresse, $situation_familiale, $employe_id);
        if ($stmt->execute()) {
            // Rediriger vers la page de détails de l'employé avec un message de succès
            header("Location: gestion_employes.php?id=$employe_id&success=1");
            exit();
        } else {
            // En cas d'erreur lors de la mise à jour, afficher un message d'erreur
            echo "Erreur lors de la mise à jour des informations de l'employé.";
        }
    }

    // Récupérer les informations actuelles de l'employé depuis la base de données
    $sql = "SELECT * FROM employe WHERE Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employe_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Récupérer les valeurs actuelles des champs pour pré-remplir le formulaire
        $matricule = $row['Matricule'];
        $code_cnss = $row['CodeCNSS'];
        $nom = $row['Nom'];
        $prenom = $row['Prenom'];
        $date_naissance = $row['DateNaissance'];
        $telephone = $row['Telephone'];
        $adresse = $row['Adresse'];
        $situation_familiale = $row['SituationFamiliale'];
    } else {
        // Si aucun employé avec cet ID n'est trouvé, rediriger vers une page d'erreur
        header("Location: erreur.php");
        exit();
    }
} else {
    // Si aucun ID d'employé n'est fourni dans l'URL, rediriger vers une page d'erreur
    header("Location: erreur.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de l'employé</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.2.0/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="img/logo.png" alt="AdminLTELogo" height="60" width="60">
        </div> -->
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
                            <h1 class="m-0 text-dark">Gestion de l'employé</h1>
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
                                    <h3 class="card-title">Modifier les informations de l'employé</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Formulaire pour modifier les informations de l'employé -->
                                    <form method="POST"
                                        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=" . $employe_id); ?>">
                                        <div class="form-group">
                                            <label for="matricule">Matricule:</label>
                                            <input type="text" class="form-control" id="matricule" name="matricule"
                                                value="<?php echo $matricule; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="code_cnss">Code CNSS:</label>
                                            <input type="text" class="form-control" id="code_cnss" name="code_cnss"
                                                value="<?php echo $code_cnss; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="nom">Nom:</label>
                                            <input type="text" class="form-control" id="nom" name="nom"
                                                value="<?php echo $nom; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="prenom">Prénom:</label>
                                            <input type="text" class="form-control" id="prenom" name="prenom"
                                                value="<?php echo $prenom; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="date_naissance">Date de naissance:</label>
                                            <input type="date" class="form-control" id="date_naissance"
                                                name="date_naissance" value="<?php echo $date_naissance; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="telephone">Numéro de téléphone:</label>
                                            <input type="text" class="form-control" id="telephone" name="telephone"
                                                value="<?php echo $telephone; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="adresse">Adresse:</label>
                                            <input type="text" class="form-control" id="adresse" name="adresse"
                                                value="<?php echo $adresse; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="situation_familiale">Situation familiale:</label>
                                            <input type="text" class="form-control" id="situation_familiale"
                                                name="situation_familiale" value="<?php echo $situation_familiale; ?>">
                                        </div>
                                        <!-- Ajoutez d'autres champs de formulaire pour les autres informations de l'employé -->

                                        <!-- Bouton de soumission du formulaire -->
                                        <button type="submit" class="btn btn-primary">Enregistrer les
                                            modifications</button>
                                    </form>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Autre action</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- Formulaire  -->
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
</body>

</html>