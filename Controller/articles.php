<?php

// Vérification de rôle de l'utilisateur

  require "Model/articles.php";

  // Pagination
  $page = isset($_GET['articles']) && is_numeric($_GET['articles']) ? (int) $_GET['articles'] : 1;
  $tri = isset($_GET['tri']) ? $_GET['tri'] : '';



  if($page){
    $postsData = listeArticles($pdo, $page);
    $posts = $postsData['articles'];
    $totalPages = $postsData['totalPages'];
    $upCategorie = isset($_GET['categorie']);

    $delete = isset($_GET['id_article']) && is_numeric($_GET['id_article']) ? (int) $_GET['id_article'] : '';

    if ($delete) {
    DeleteArticles($pdo, $delete);
    header('Location: index.php?component=articles');
    exit;
  }

  if ($upCategorie) {

    $categorie = trim($_POST['nom'] ?? '');

    if (empty($categorie)) {
      echo "Erreur : Le champ 'nom' est requis.";
      exit;
    }

    if (!preg_match("/^[a-zA-Z0-9\s]+$/", $categorie)) {
      echo "Erreur : Le nom de la catégorie contient des caractères non valides.";
      exit;
    }


    UpCategorie($pdo, $categorie);
    header('Location: index.php?component=articles');
    exit;
  }
if ($tri) {
      $postsData = listeArticles($pdo, $page, $tri);
      $posts = $postsData['articles'];
      $totalPages = $postsData['totalPages'];
    }

}


  // Inclure la vue
  require "View/articles.php";

