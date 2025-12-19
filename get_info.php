<?php
session_start();

// Vérifier si un code de département est passé via POST
if (!isset($_POST['code_dep'])) {
    echo "<p>Code département absent.</p>";
    exit;
}

$code_dep = $_POST['code_dep'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les informations du département
    $dep = $pdo->prepare("SELECT * FROM departement WHERE code_dep = ?");
    $dep->execute([$code_dep]);
    $d = $dep->fetch(PDO::FETCH_ASSOC);

    if (!$d) {
        echo "<p>Aucune donnée trouvée pour le département $code_dep.</p>";
        exit;
    }

    // Récupérer la région
    $reg = $pdo->prepare("SELECT nom_region FROM region WHERE code_region = ?");
    $reg->execute([$d['code_region']]);
    $region_nom = $reg->fetchColumn();

    // Récupérer les logements
    $log = $pdo->prepare("SELECT * FROM logement WHERE code_dep = ?");
    $log->execute([$code_dep]);
    $l = $log->fetch(PDO::FETCH_ASSOC);

    // Récupérer les établissements culturels
    $eta = $pdo->prepare("SELECT * FROM etablissement WHERE code_dep = ?");
    $eta->execute([$code_dep]);
    $e = $eta->fetch(PDO::FETCH_ASSOC);

    // Calcul du salaire moyen
    $salaire_moyen = null;
    if (!empty($d['montant_salarie']) && !empty($d['nbr_foyer_salarie']) && $d['nbr_foyer_salarie'] > 0) {
        $salaire_moyen = $d['montant_salarie'] / $d['nbr_foyer_salarie'];
    }

    // Enseignement supérieur
    $code_dep_int = (int)$code_dep;
    $sql_eta_sup = "
        SELECT 
            `type d'etablissement` AS type,
            COUNT(*) AS nb
        FROM eta_superieur
        WHERE code_dep = $code_dep_int
        GROUP BY `type d'etablissement`
        ORDER BY nb DESC
    ";
    $eta_sup_stmt = $pdo->query($sql_eta_sup);
    $eta_list = $eta_sup_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si l'utilisateur est connecté et si ce département est déjà dans ses favoris
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $is_favori = false;

    if ($user_id) {
        $favoriStmt = $pdo->prepare("SELECT * FROM favoris WHERE user_id = ? AND code_dep = ?");
        $favoriStmt->execute([$user_id, $code_dep]);
        $is_favori = $favoriStmt->rowCount() > 0;
    }

} catch (Exception $e) {
    echo "<p>Erreur : " . $e->getMessage() . "</p>";
    exit;
}
?>


<main>
    <section class="departement-info">
        <h1><?= htmlspecialchars($d['nom_dep']) ?></h1>
        <p><strong>📍 Région :</strong> <?= htmlspecialchars($region_nom) ?></p>
        <p><strong>🕵️ Population :</strong> <?= htmlspecialchars($d['nbr_hab']) ?> habitants</p>
        <p><strong>🏙️ Densité :</strong> <?= htmlspecialchars($d['densite']) ?> hab/km²</p>
        <p><strong>📉 Taux de chômage :</strong> <?= htmlspecialchars($d['taux_chomage']) ?>%</p>
        <p><strong>📊 Taux de pauvreté :</strong> <?= htmlspecialchars($d['taux_pauvrete']) ?>%</p>

        <?php if ($salaire_moyen !== null): ?>
            <p><strong>💰 Salaire moyen :</strong> <?= number_format($salaire_moyen, 0, ',', ' ') ?> € / foyer salarié / an</p>
        <?php endif; ?>

        <?php if ($l): ?>
            <p><strong>🏠 Logements :</strong> <?= $l['nbr_log'] ?> logements (sociaux : <?= $l['taux_log_sociaux'] ?>%, individuels : <?= $l['taux_log_ind'] ?>%)</p>
        <?php endif; ?>

        <?php if ($e): ?>
            <p><strong>🎭 Établissements culturels :</strong> <?= $e['nbr_t_eta'] ?> total (<?= $e['nbr_eta_2018'] ?> en 2018)</p>
        <?php endif; ?>

        <?php if (!empty($eta_list)): ?>
            <p><strong>🎓 Enseignement supérieur :</strong></p>
            <ul style="margin-left: 20px;">
                <?php foreach ($eta_list as $et): ?>
                    <li>— <?= $et['nb'] ?> <?= htmlspecialchars($et['type']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($user_id): ?>
            <!-- Formulaire pour Ajouter/Retirer aux favoris -->
            <form action="toggle_favori.php" method="POST" id="add-favori-form" style="display:inline;">
                <input type="hidden" name="code_dep" value="<?= $d['code_dep'] ?>">
                <button type="submit" class="btn <?= $is_favori ? 'active' : '' ?>" style="font-size: 0.7rem; padding: 6px 12px;">
    				<?= $is_favori ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>
				</button>

            </form>
        <?php endif; ?>
    </section>
</main>

<script>
    document.getElementById('add-favori-form').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêche la soumission du formulaire

        var formData = new FormData(this);
        fetch('toggle_favori.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Mettre à jour l'état du bouton
            const button = document.querySelector('button');
            button.textContent = (button.textContent === 'Ajouter aux favoris') ? 'Retirer des favoris' : 'Ajouter aux favoris';

            // Rafraîchir les favoris directement
            refreshFavorites();
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
    });

    // Fonction pour actualiser la liste des favoris dans mes_favoris.php
    function refreshFavorites() {
        fetch('mes_favoris.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('favoris-section').innerHTML = html;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des favoris:', error);
        });
    }
</script>

</body>
</html>
