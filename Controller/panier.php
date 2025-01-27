<?php
require "Model/panier.php";
// Vérifie si le panier est vide
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $errorMessage = "Votre panier est vide.";
    header('Location: index.php?component=articles');
    exit();
}

// Récupère l'ID des actions : mettre à jour ou supprimer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mise à jour de la quantité d'un article
    if (isset($_POST['quantity'])) {
        foreach ($_POST['quantity'] as $productId => $newQuantity) {
            if ($newQuantity <= 0) {
                unset($_SESSION['cart'][$productId]);
            } else {
                $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
            }
        }
    }

    // Suppression d'un article du panier
    if (isset($_POST['remove'])) {
        foreach ($_POST['remove'] as $productId => $value) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

// Récupérer tous les articles dans le panier
$cartItems = [];
foreach ($_SESSION['cart'] as $productId => $item) {
    // Récupérer l'article complet depuis la base de données
    $article = RecupArticle($pdo, $productId);
    if ($article) {
        $cartItems[] = array_merge($article, [
            'quantity' => $item['quantity']
        ]);
    }
}

require 'View/panier.php'; // Affiche la page panier


?>

