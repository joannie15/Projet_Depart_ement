<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $message = 'Vous devez vous connecter pour accéder à vos favoris.';
    $message_type = 'warning';
} else {
    $user_id = $_SESSION['user_id'];
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');
        $stmt = $pdo->prepare("
            SELECT d.code_dep, d.nom_dep
            FROM departement d
            INNER JOIN favoris f ON d.code_dep = f.code_dep
            WHERE f.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_POST['remove_code_dep'])) {
            $remove_code_dep = $_POST['remove_code_dep'];
            $remove_stmt = $pdo->prepare("DELETE FROM favoris WHERE user_id = ? AND code_dep = ?");
            $remove_stmt->execute([$user_id, $remove_code_dep]);
        }
    } catch (PDOException $e) {
        $error_message = 'Erreur : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris - Départ(ement)</title>
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
            <li  class="active">Mes favoris</li>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Se déconnecter</a></li>
            <?php else: ?>
                <li><a href="login.php">Se connecter</a></li>
                <li><a href="signup.php">S'inscrire</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main class="container">
    <section class="hero">
        <h1>Mes départements favoris</h1>

        <?php if (isset($message)): ?>
            <div class="message <?= $message_type ?>"><?= $message ?> <a href="login.php">Se connecter</a></div>
        <?php elseif (!empty($favoris)): ?>
            <ul>
                <?php foreach ($favoris as $favori): ?>
                    <li id="fav-<?= $favori['code_dep'] ?>" style="color: white;">
    					<?= htmlspecialchars($favori['nom_dep']) ?> (Code : <?= $favori['code_dep'] ?>)
                        <form method="POST" style="display:inline;">
    						<input type="hidden" name="remove_code_dep" value="<?= $favori['code_dep'] ?>">
    						<button type="submit" class="btn remove-fav" data-code="<?= $favori['code_dep'] ?>" style="font-size: 0.6rem; padding: 5px 5px;">
        						Retirer des favoris
    						</button>
						</form>

                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Vous n'avez aucun département favori pour le moment.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; 2025 Départ(ement). Tous droits réservés.</p>
</footer>

<script>
    document.querySelectorAll('.remove-fav').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const code_dep = this.getAttribute('data-code');
            const listItem = document.getElementById(`fav-${code_dep}`);

            // Envoi AJAX pour retirer du favoris
            fetch('toggle_favori.php', {
                method: 'POST',
                body: new URLSearchParams({
                    'code_dep': code_dep,
                    'action': 'remove'
                })
            })
            .then(response => response.text())
            .then(data => {
                // Supprimer l'élément de la liste sans afficher l'alerte
                listItem.remove();
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });
</script>

</body>
</html>
