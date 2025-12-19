<?php
session_start();

// Si l'utilisateur est déjà connecté, on le redirige vers la page d'accueil
if (isset($_SESSION['user_id'])) {
    header('Location: accueil.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id_utilisateur'];
            $_SESSION['email'] = $user['email'];
            header('Location: accueil.php'); // Redirection vers l'accueil après connexion réussie
            exit;
        } else {
            $erreur = 'Email ou mot de passe incorrect';
        }
    } catch (PDOException $e) {
        $erreur = 'Erreur de connexion : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter - Départ(ement)</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <h1 class="logo">Départ(ement)</h1>
            <ul>
                <li><a href="accueil.php">Accueil</a></li>
                <li><a href="carte.php">Carte</a></li>
                <li><a href="apropos.php">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="mes_favoris.php">Mes favoris</a></li>
                <li class="active">Se connecter</li> 
                <li><a href="signup.php">S'inscrire</a></li> 
            </ul>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <h1>Se connecter</h1>

            <?php if (!empty($erreur)): ?>
                <div class="error-message"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="post">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required><br>

                <label for="password">Mot de passe :</label>
                <input type="password" name="password" id="password" required><br>

                <button type="submit" class="btn-small">Se connecter</button>
            </form>

            <p>Pas encore de compte ? <a href="signup.php">S'inscrire</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Départ(ement). Tous droits réservés. | Projet réalisé par des étudiantes de l'Université Paul Valéry</p>
    </footer>
</body>
</html>
