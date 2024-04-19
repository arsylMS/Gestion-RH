<?php
session_start();

require_once 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM Users WHERE Mail = ? AND MotDePasse = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $_SESSION["user_logged_in"] = true;
            header("Location: accueil.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Adresse e-mail ou mot de passe incorrect.";
            header("Location: index.php");
            exit();
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $_SESSION["login_error"] = "Veuillez remplir tous les champs du formulaire.";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION["login_error"] = "La requête n'est pas valide.";
    header("Location: index.php");
    exit();
}
?>
