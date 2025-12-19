<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_POST['code_dep'])) {
    echo "Erreur: vous devez être connecté et spécifier un département.";
    exit;
}

$user_id = $_SESSION['user_id'];
$code_dep = $_POST['code_dep'];

try {
    $pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');

    // Vérifier si le département est déjà dans les favoris
    $checkStmt = $pdo->prepare("SELECT * FROM favoris WHERE user_id = ? AND code_dep = ?");
    $checkStmt->execute([$user_id, $code_dep]);
    $favoriExist = $checkStmt->rowCount() > 0;

    if ($favoriExist) {
        // Retirer du favoris
        $stmt = $pdo->prepare("DELETE FROM favoris WHERE user_id = ? AND code_dep = ?");
        $stmt->execute([$user_id, $code_dep]);
        echo "Département retiré des favoris.";
    } else {
        // Ajouter au favoris
        $stmt = $pdo->prepare("INSERT INTO favoris (user_id, code_dep) VALUES (?, ?)");
        $stmt->execute([$user_id, $code_dep]);
        echo "Département ajouté aux favoris.";
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
