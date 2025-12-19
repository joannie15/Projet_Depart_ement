<?php
session_start();  // Démarrer la session pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Départ(ement)</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
    <header>
        <nav>
            <h1 class="logo">Départ(ement)</h1>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="carte.php">Carte</a></li>
                <li><a href="apropos.php">À propos</a></li>
                <li class="active">Contact</a></li>
                <li><a href="mes_favoris.php">Mes favoris</a></li> <!-- Lien "Mes favoris" -->
                <?php 
                if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php">Se déconnecter</a></li> <!-- Si l'utilisateur est connecté, afficher "Se déconnecter" -->
                <?php else: ?>
                    <li><a href="login.php">Se connecter</a></li> <!-- Si l'utilisateur n'est pas connecté, afficher "Se connecter" -->
                    <li><a href="signup.php">S'inscrire</a></li> <!-- Et "S'inscrire" -->
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="hero">
            <h1>Contactez-Nous</h1>
            <p>Une question ? Une suggestion ? N'hésitez pas à nous contacter, nous serons ravies de vous répondre !</p>
        </div>

        <div class="content">
            <h2>📬 Plusieurs façons de nous joindre</h2>
            <p>
                Nous sommes à votre écoute pour toute question concernant notre plateforme, les données affichées, 
                ou pour nous faire part de vos suggestions d'amélioration. Choisissez le moyen de communication 
                qui vous convient le mieux.
            </p>

            <div class="contact-grid">
                <div class="contact-info">
                    <h3>📧 Email</h3>
                    <p style="font-weight: 600; color: #0077b6; margin-top: 0.5rem;">contact@departement.fr</p>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                        Pour toute demande d'information ou suggestion
                    </p>
                </div>
                
                <div class="contact-info">
                    <h3>📞 Téléphone</h3>
                    <p style="font-weight: 600; color: #0077b6; margin-top: 0.5rem;">+33 1 23 45 67 89</p>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem;">
                        Du lundi au vendredi<br>9h00 - 18h00
                    </p>
                </div>
                
                <div class="contact-info">
                    <h3>📍 Adresse</h3>
                    <p style="font-weight: 600; color: #0077b6; margin-top: 0.5rem;">
                        Université Paul Valéry<br>
                        Route de Mende<br>
                        34090 Montpellier, France
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Départ(ement). Tous droits réservés. | Projet réalisé par des étudiantes de l'Université Paul Valéry</p>
    </footer>
</body>
</html>
