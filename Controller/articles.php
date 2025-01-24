<?php

require "Model/articles.php";

// Gestion de la pagination, du filtre et du tri
$page = isset($_GET['articles']) && is_numeric($_GET['articles']) ? (int) $_GET['articles'] : 1;
$page = max($page, 1);

$tri = isset($_GET['tri']) ? $_GET['tri'] : '';
$filtre_categorie = isset($_GET['filtre_categorie']) ? (int) $_GET['filtre_categorie'] : '';


$filtres = RecupCategorie($pdo);

// Gestion de la suppression d'article
$delete = isset($_GET['id_article']) && is_numeric($_GET['id_article']) ? (int) $_GET['id_article'] : '';
if ($delete) {
  DeleteArticles($pdo, $delete);
  header('Location: index.php?component=articles');
  exit;
}

// Gestion de l'ajout ou modification de catégorie
$upCategorie = isset($_GET['categorie']);
if ($upCategorie) {
  $categorie = trim($_POST['nom'] ?? '');
  if (empty($categorie)) {
    $_SESSION['error_message'] = "Erreur : Le champ 'nom' est requis.";
    exit;
  }
  if (!preg_match("/^[a-zA-Z0-9\s]+$/", $categorie)) {
    $_SESSION['error_message'] = "Erreur : Le nom de la catégorie contient des caractères non valides.";
    exit;
  }

  UpCategorie($pdo, $categorie);
  header('Location: index.php?component=articles');
  exit;
}

// Récupérer les articles avec ou sans filtre
if ($filtre_categorie) {


  $postsData = FiltreArticles($pdo, $page, $tri, $filtre_categorie);

  if($tri){
    $page = 1;
  }



} else {
  $postsData = FiltreArticles($pdo, $page, $tri);
}

$posts = $postsData['articles'];
$totalPages = $postsData['totalPages'];

// Inclure la vue
require "View/articles.php";
?>

