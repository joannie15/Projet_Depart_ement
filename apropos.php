<?php
session_start();  // Démarrer la session pour accéder aux variables de session
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À Propos - Départ(ement)</title>
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
</head>
<body>
    <header>
        <nav>
            <h1 class="logo">Départ(ement)</h1>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="carte.php">Carte</a></li>
                <li class="active">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="mes_favoris.php">Mes favoris</a></li> <!-- Lien "Mes favoris" -->

                <?php if (isset($_SESSION['user_id'])): ?>
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
            <h1>À Propos de Nous</h1>
            <p>Découvrez qui nous sommes et notre mission pour vous aider à trouver votre lieu de vie idéal en France</p>
        </div>

        <div class="content">
            <h2>🎓 Qui sommes-nous ?</h2>
            <p>
                Nous sommes une équipe d'étudiantes en Licence MIASHS (Mathématiques et Informatique Appliquées aux Sciences Humaines et Sociales) 
                à l'Université Paul Valéry de Montpellier. Passionnées par l'analyse de données et le développement web, 
                nous avons créé ce projet dans le cadre de notre formation.
            </p>

            <h2 style="margin-top: 2rem;">🎯 Notre Mission</h2>
            <p>
                Notre objectif est d'aider les personnes, qu'elles soient françaises ou étrangères, à choisir le meilleur département 
                ou la meilleure ville pour s'installer en France. Nous savons que déménager peut être une décision difficile, 
                c'est pourquoi nous mettons à disposition des données objectives et faciles à comparer.
            </p>

            <h2 style="margin-top: 2rem;">💡 Notre Vision</h2>
            <p>
                Nous croyons que chaque personne mérite de trouver un lieu où elle se sentira chez elle. Que vous recherchiez 
                un département dynamique avec beaucoup d'opportunités d'emploi, une région calme avec un faible coût de la vie, 
                ou encore une zone avec de nombreux établissements d'enseignement supérieur, notre plateforme vous aide à prendre 
                une décision éclairée basée sur vos critères personnels.
            </p>

            <h2 style="margin-top: 2rem;">📊 Nos Données</h2>
            <p>
                Toutes nos données proviennent de sources officielles françaises et sont régulièrement mises à jour. 
                Nous analysons des critères variés tels que le taux de chômage, le taux de pauvreté, la densité de population, 
                le pourcentage de logements sociaux, et bien d'autres indicateurs pour vous offrir une vue d'ensemble complète 
                de chaque département français.
            </p>

            <div style="background: #e0f2fe; padding: 1.5rem; border-radius: 12px; margin-top: 2rem; border-left: 4px solid #0077b6;">
                <h3 style="color: #0077b6; margin-bottom: 0.5rem;">✨ Projet Universitaire 2025</h3>
                <p style="margin: 0; color: #0c4a6e;">
                    Ce site a été développé dans le cadre d'un projet pédagogique visant à combiner nos compétences en 
                    bases de données, développement web et analyse statistique pour créer un outil utile à la communauté.
                </p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Départ(ement). Tous droits réservés. | Projet réalisé par des étudiantes de l'Université Paul Valéry</p>
    </footer>
</body>
</html>
