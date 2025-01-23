<?php
require "Model/info_article.php";

// Initialisation des variables
$id = isset($_GET['id_article']) && is_numeric($_GET['id_article']) ? (int) $_GET['id_article'] : 0;
$errorMessage = '';
$categories = RecupCategorie($pdo);
$promotion = RecupPromotion($pdo);


// Vérifie si l'article existe pour un ID donné
if ($id > 0) {
  if (ValiditeArticle($pdo, $id)) {
    $article = RecupArticle($pdo, $id);

  } else {
    // Redirection si l'article est invalide
    header('Location: index.php?component=articles');
    exit();
  }
}


require "View/info_article.php";
