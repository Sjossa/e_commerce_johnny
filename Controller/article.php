<?php
require 'Model/article.php';

$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;
$create = isset($_GET['create']);

$categories = recupcategorie($pdo);

if ($id > 0) {

  // Vérifier si l'article existe
  $stmt = validitéArticle($pdo, $id);

  if ($stmt->fetchColumn() > 0) {

    // Récupérer l'article
    $article = RecupArticle($pdo, $id);

    // Vérification de la méthode POST pour mise à jour
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $nom = trim($_POST['nom'] ?? '');
      $description = trim($_POST['description'] ?? '');
      $prix = floatval($_POST['prix'] ?? 0);
      $stock = intval($_POST['stock'] ?? 0);
      $categorie = intval($_POST['id_categorie'] ?? 0);
      $image = $_POST['image'] ?? '';

      // Mise à jour de l'article
      UpdateArticle($pdo, $id, $nom, $description, $image, $prix, $stock, $categorie);

      // Optionnel : rediriger après la mise à jour pour éviter un resubmit du formulaire en actualisant la page
      header("Location: index.php?component=articles");
      exit();
    }
  } else {
    // Si l'article n'existe pas, redirection vers la liste des articles
    header('Location: index.php?component=articles');
    exit();
  }

} elseif ($create) {

  // Vérification de la méthode POST pour ajout d'un article
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categorie = intval($_POST['id_categorie'] ?? 0);
    $image = $_POST['image'] ?? '';


    AjoutArticle($pdo, $nom, $description, $image, $prix, $stock, $categorie);

    header("Location: index.php?component=article");
    exit();
  }

} else {

  header('Location: index.php?component=home');
  exit();
}

require 'View/article.php';
