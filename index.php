<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Page d'Accueil - Gestion RH</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="content">
  <nav>
    <div class="container">
      <div class="logo">
        <img src="img/logo.png" alt="Logo de l'entreprise">
      </div>
      <div class="nav-buttons">
        <ul>
          <li><a href="recrutement.html">Recrutement</a></li>
          <li><a href="formation.html">Formation</a></li>
          <li><a href="gestion-personnel.html">Gestion du Personnel</a></li>
          <li><a href="politiques-rh.html">Politiques RH</a></li>
          <li><a href="contact.html">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <header>
    <h1>Bienvenue sur le Site de Gestion RH</h1>
  </header>
  <main>
    <div class="login-form">
      <h2>Connexion</h2>
      <?php

      if (isset($_GET['error'])) {
          echo "<p class='error-message'>Erreur : les informations de connexion sont incorrectes.</p>";
      }
      ?>
      <form action="process_login.php" method="POST">
        <div class="form-group">
          <label for="email">Adresse e-mail :</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Se connecter</button>
      </form>
    </div>
  </main>
</div>
</body>
</html>
