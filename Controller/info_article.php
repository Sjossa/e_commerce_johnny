<?php
require "Model/info_article.php";

$id = isset($_GET['id_article']) && is_numeric($_GET['id_article']) ? (int) $_GET['id_article'] : 0;
$errorMessage = '';
$categories = RecupCategorie($pdo);
$promotion = RecupPromotion($pdo);

if ($id > 0) {
  if (ValiditeArticle($pdo, $id)) {
    $article = RecupArticle($pdo, $id);
  } else {
    header('Location: index.php?component=articles');
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['quantity'])) {
    // Logique pour ajouter au panier
    $quantity = (int) $_POST['quantity'];
    if ($quantity <= 0) {
      $errorMessage = "La quantité doit être positive.";
    } else {
      if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
      }

      $productId = $id;
      if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += $quantity;
      } else {
        $_SESSION['cart'][$productId] = [
          'name' => $article['nom'],
          'quantity' => $quantity,
          'id' => $article['id_article'],
          'prix' => $article['prix']


        ];
      }
      header("Location: index.php?component=info_article&id_article=" . urlencode($id));
      exit();
    }
  } else {
    $errorMessage = "Des données sont manquantes dans le formulaire.";
  }
}

require "View/info_article.php"; // Affichage de la page avec les détails de l'article
?>

