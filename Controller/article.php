<?php
require 'Model/article.php';

// Initialisation des variables
$id = isset($_GET['id_article']) && is_numeric($_GET['id_article']) ? (int) $_GET['id_article'] : 0;
$create = isset($_GET['create']);
$errorMessage = '';
$categories = RecupCategorie($pdo);
$promotion = RecupPromotion($pdo);
$article = null;

// Fonction pour gérer l'ajout de promotion
function handlePromotion($pdo, $newPromotion)
{
  if (AjoutPromotion($pdo, $newPromotion)) {
    return true;
  }
  return false;
}

// Vérifie si l'article existe pour un ID donné
if ($id > 0) {
  if (ValiditeArticle($pdo, $id)) {
    $article = RecupArticle($pdo, $id);

    // Gestion de l'ajout d'une promotion

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_promotion'])) {
      $newPromotion = intval($_POST['new_promotion']);
      if (handlePromotion($pdo, $newPromotion)) {
        header("Location: index.php?component=article&id_article=$id");
        exit();
      } else {
        $errorMessage = "Impossible d’ajouter la promotion.";
      }
    }

    // Gestion de la mise à jour de l'article
    elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Sécurisation et récupération des données
      $nom = htmlspecialchars(trim($_POST['nom'] ?? ''), ENT_QUOTES);
      $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES);
      $prix = floatval($_POST['prix'] ?? 0);
      $stock = intval($_POST['stock'] ?? 0);
      $categorie = intval($_POST['id_categorie'] ?? 0);
      $image = htmlspecialchars($_POST['image'] ?? '', ENT_QUOTES);
      $promotionId = isset($_POST['promotion']) && $_POST['promotion'] !== '' ? (int) $_POST['promotion'] : null;


      // Mise à jour de l'article
      if (UpdateArticle($pdo, $id, $nom, $description, $image, $prix, $stock, $categorie, $promotionId)) {
        header("Location: index.php?component=article&id_article=$id");
        exit();
      } else {
        $errorMessage = "Erreur lors de la mise à jour de l'article.";
      }
    }
  } else {
    // Redirection si l'article est invalide
    header('Location: index.php?component=articles');
    exit();
  }
}

// Gestion de la création d’un nouvel article
if ($create) {

  // Gestion de l'ajout d'une promotion
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_promotion'])) {
    $newPromotion = intval($_POST['new_promotion']);

    if (handlePromotion($pdo, $newPromotion)) {
      header("Location: index.php?component=article&id_article");
      exit();
    } else {
      $errorMessage = "Impossible d’ajouter la promotion.";
    }
  }

  // Création d'un nouvel article
  elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sécurisation et récupération des données
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''), ENT_QUOTES);
    $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES);
    $prix = floatval($_POST['prix'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);
    $categorie = intval($_POST['id_categorie'] ?? 0);
    $image = htmlspecialchars($_POST['image'] ?? '', ENT_QUOTES);
    $promotionId = intval($_POST['promotion'] ?? 0);

    // Création de l'article
    if (AjoutArticle($pdo, $nom, $description, $image, $prix, $stock, $categorie, $promotionId)) {
      header("Location: index.php?component=articles");
      exit();
    } else {
      $errorMessage = "Erreur lors de la création de l'article.";
    }
  }
}

// Charger la vue
require 'View/article.php';
