<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    // Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $erreur = 'Il y a déjà un compte associé à cet email.';
        } else {
            // Hachage du mot de passe
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insérer le nouvel utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO utilisateur (email, mot_de_passe, nom, prenom) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, $hashed_password, $nom, $prenom]);

            // Connexion réussie
            $_SESSION['email'] = $email;
            $_SESSION['id_utilisateur'] = $pdo->lastInsertId();
            header('Location: accueil.php'); // Redirection vers l'accueil après une inscription réussie
            exit;
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
    <title>S'inscrire - Départ(ement)</title>
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
                <li><a href="login.php">Se connecter</a></li> 
                <li class="active">S'inscrire</li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <h1>Inscription</h1>

            <?php if (!empty($erreur)): ?>
                <div style="color: red;"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="post">
                <label>Nom :</label>
                <input type="text" name="nom" required><br>

                <label>Prénom :</label>
                <input type="text" name="prenom" required><br>

                <label>Email :</label>
                <input type="email" name="email" required><br>

                <label>Mot de passe :</label>
                <input type="password" name="password" required><br>

                <button type="submit">S'inscrire</button>
            </form>

            <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Départ(ement). Tous droits réservés. | Projet réalisé par des étudiantes de l'Université Paul Valéry</p>
    </footer>
</body>
</html>
