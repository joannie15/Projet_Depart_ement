<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Départ(ement)</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <h1 class="logo">Départ(ement)</h1>
      <ul>
        <li class="active">Accueil </li>
        <li><a href="carte.php">Carte</a></li>
        <li><a href="apropos.php">À propos</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="mes_favoris.php">Mes favoris</a></li> <!-- Lien "Mes favoris" -->
        
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="logout.php">Se déconnecter</a></li> <!-- Si connecté, afficher "Se déconnecter" -->
        <?php else: ?>
          <li><a href="login.php">Se connecter</a></li> <!-- Sinon afficher "Se connecter" -->
          <li><a href="signup.php">S'inscrire</a></li> <!-- Et "S'inscrire" -->
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div class="overlay"></div>
      <div class="content">
        <h1>Trouve ton futur “chez toi”</h1>
        <p>Comparez les départements selon vos critères : logement, sécurité, culture, qualité de vie...</p>
        <div class="buttons">
          <a href="carte.php" class="btn">Explorer la carte</a>
          <a href="criteres.php" class="btn">Choisir ses critères</a>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Départ(ement). Tous droits réservés. | Projet réalisé par des étudiantes de l'Université Paul Valéry</p>
  </footer>
</body>
</html>
