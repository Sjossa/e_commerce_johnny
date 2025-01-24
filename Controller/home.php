<?php
// Inclure le modèle pour récupérer les articles
require 'Model/home.php';

// Vérifier si la connexion à la base de données est définie
if (isset($pdo)) {
  $posts = getArticles($pdo);

  if (empty($posts)) {
    $_SESSION['error_message']= "Aucun article trouvé ou erreur lors de la récupération des articles.";
  }
} else {
  $_SESSION['error_message'] = "Connexion à la base de données non définie.";
  $posts = [];
}

require 'View/home.php';
?>

