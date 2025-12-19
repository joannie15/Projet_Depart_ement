<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté pour ajouter un favori.";
    exit;
}

$user_id = $_SESSION['user_id'];
$ville_id = $_GET['ville_id']; // L'ID de la ville que l'utilisateur veut ajouter ou retirer

// Connexion à la base de données
$pdo = new PDO('mysql:host=localhost;dbname=depart_ement', 'root', 'root');

// Vérifier si cette ville est déjà un favori
$stmt = $pdo->prepare("SELECT * FROM favoris WHERE user_id = ? AND ville_id = ?");
$stmt->execute([$user_id, $ville_id]);
$favori = $stmt->fetch(PDO::FETCH_ASSOC);

if ($favori) {
    // Retirer du favoris
    $stmt = $pdo->prepare("DELETE FROM favoris WHERE user_id = ? AND ville_id = ?");
    $stmt->execute([$user_id, $ville_id]);
    echo "Ville retirée des favoris.";
} else {
    // Ajouter au favoris
    $stmt = $pdo->prepare("INSERT INTO favoris (user_id, ville_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $ville_id]);
    echo "Ville ajoutée aux favoris.";
}
?>
