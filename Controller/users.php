<?php
// Inclure le modèle pour les utilisateurs
require "Model/users.php";


$page = isset($_GET['users']) && is_numeric($_GET['users']) ? (int) $_GET['users'] : 1;


// Tri et suppression
$tri = isset($_GET['tri']) ? trim($_GET['tri']) : '';
$delete = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;

// Suppression d'un utilisateur
if ($delete > 0) {
  if (!deleteUsers($pdo, $delete)) {
    $_SESSION['error_message'] = "Échec de la suppression de l'utilisateur.";
  }
  header('Location: index.php?component=users');
  exit;
}


// Récupération des données utilisateurs
$postsData = listeUsers($pdo, $page, $tri);
if (empty($postsData)) {
  $_SESSION['error_message'] = "Erreur lors de la récupération des utilisateurs.";
  exit;
}




$posts = $postsData['users'];
$totalPages = $postsData['totalPages'];

// Inclure la vue
require "View/users.php";
?>

