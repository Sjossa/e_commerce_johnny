<?php

require "Model/articles.php";

$posts = listeArticles($pdo);

$delete = isset($_GET['id']) ? $_GET['id'] : '';
$upCategorie = isset(($_GET['categorie']));

if ($delete) {
  DeleteArticles($pdo);
  header('Location: index.php?component=articles');
  exit;
}

if ($upCategorie) {
  $categorie = trim($_POST['nom'] ?? '');

  // Vérifie que la catégorie n'est pas vide
  if (empty($categorie)) {
    die("Erreur : le champ 'nom' est requis.");
  }

  UpCategorie($pdo, $categorie);
  header('Location: index.php?component=articles');
  exit;
}



require "View/articles.php";

