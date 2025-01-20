<?php

// Vérification de rôle de l'utilisateur
if (!isset($_SESSION['role'])) {
  header('Location: index.php');
  exit;
} else {
  require "Model/users.php";

  // Pagination
  $page = isset($_GET['users']) && is_numeric($_GET['users']) ? (int) $_GET['users'] : 1;

  // Tri et suppression
  $tri = isset($_GET['tri']) ? trim($_GET['tri']) : '';
  $delete = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;

  // Suppression d'un utilisateur
  if ($delete > 0) {
    DeleteUsers($pdo, $delete);
    header('Location: index.php?component=users');
    exit;
  }

  // Récupération des données utilisateurs
  $postsData = listeUsers($pdo, $page, $tri);
  $posts = $postsData['users'];
  $totalPages = $postsData['totalPages'];

  // Inclure la vue
  require "View/users.php";
}
