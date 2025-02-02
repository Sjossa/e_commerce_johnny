<?php

require "Model/Crud_categorie.php";
$page = isset($_GET['categorie']) && is_numeric($_GET['categorie']) ? (int) $_GET['categorie'] : 1;
$page = max($page, 1);

// Récupération des catégories
$categorie = GetCategorie($pdo,$page);

// Suppression d'une catégorie
if (isset($_GET['id_categorie']) && is_numeric($_GET['id_categorie'])) {
  $delete = (int) $_GET['id_categorie'];
  DeleteCategorie($pdo, $delete);
  header('Location: index.php?component=Crud_categorie');
  exit;
}

if (isset($_GET['AjoutCategorie'])) {
  $newCategory = trim($_POST['nom'] ?? '');

  if (empty($newCategory)) {
    $_SESSION['error_message'] = "Erreur : Le champ 'nom' est requis.";
    header('Location: index.php?component=Crud_categorie');
    exit;
  }

  if (!preg_match("/^[a-zA-Z0-9\s]+$/", $newCategory)) {
    $_SESSION['error_message'] = "Erreur : Le nom de la catégorie contient des caractères non valides.";
    header('Location: index.php?component=Crud_categorie');
    exit;
  }

  AjoutCategorie($pdo, $newCategory);
  header('Location: index.php?component=Crud_categorie');
  exit;
}

// Modification d'une catégorie
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id_categorie = $_POST['id_categorie'] ?? null;
  $nom = trim($_POST['nom'] ?? '');


  if (!$id_categorie || empty($nom)) {
    $_SESSION['error_message'] = "Erreur : Tous les champs sont requis pour modifier une catégorie.";
    header('Location: index.php?component=Crud_categorie');
    exit;
  }

  if (!preg_match("/^[a-zA-Z0-9\s]+$/", $nom)) {
    $_SESSION['error_message'] = "Erreur : Le nom de la catégorie contient des caractères non valides.";
    header('Location: index.php?component=Crud_categorie');
    exit;
  }

  ModiCategorie($pdo, $id_categorie, $nom);
  header('Location: index.php?component=Crud_categorie&categorie=' . $page);
  exit;
}
$categorieData = GetCategorie($pdo, $page);

// Accéder aux données retournées
$categorie = $categorieData['categories'];
$totalPages = $categorieData['totalPages'];

// Chargement de la vue
require "View/Crud_categorie.php";
