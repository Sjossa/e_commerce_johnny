<?php
require "Model/panier.php";

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

}else{


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

    // Suppression d'un article du panier
    if (isset($_POST['remove'])) {
        foreach ($_POST['remove'] as $productId => $value) {
            unset($_SESSION['cart'][$productId]);
        }
    }
}


$cartItems = [];
foreach ($_SESSION['cart'] as $productId => $item) {

    $article = RecupArticle($pdo, $productId);
        $promotion_valid = isPromotionValid($article['id_promotion']);

        if ($article['id_promotion']) {
    } else {
        $promotion_valid = false;
    }
    if ($article) {
        $cartItems[] = array_merge($article, [
            'quantity' => $item['quantity']
        ]);
    }
}
}
require 'View/panier.php';


?>

