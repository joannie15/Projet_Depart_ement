<?php
session_start();
session_unset(); // On vide toutes les variables de session
session_destroy(); // On détruit la session

header('Location: accueil.php'); // On redirige vers l'accueil après la déconnexion
exit;
?>
