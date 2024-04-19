<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'PFA'); 

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}
?>
