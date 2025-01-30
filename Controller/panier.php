<?php
require "Model/panier.php";

// Vérifie si le panier est vide
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
} else {
    // Traitement du formulaire si la méthode est POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['quantity'])) {
            foreach ($_POST['quantity'] as $productId => $newQuantity) {
                if ($newQuantity <= 0) {
                    unset($_SESSION['cart'][$productId]);
                } else {
                    $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
                }
            }
        }

        if (isset($_POST['remove'])) {
            foreach ($_POST['remove'] as $productId => $value) {
                unset($_SESSION['cart'][$productId]);
            }
        }
    }

    // Initialisation du tableau des articles du panier
    $cartItems = [];
    foreach ($_SESSION['cart'] as $productId => $item) {
        $article = RecupArticle($pdo, $productId);

        $promotion_valid = false;
        if ($article['id_promotion']) {
            $promotion_valid = isPromotionValid($pdo, $article['id_promotion']);
        }


        if ($article) {
            $cartItems[] = array_merge($article, [
                'quantity' => $item['quantity'],
                'promotion_valid' => $promotion_valid
            ]);
        }
    }
}

// Chargement de la vue du panier
require 'View/panier.php';
?>

