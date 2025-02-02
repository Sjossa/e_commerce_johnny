<?php
// Inclure le modèle pour la recherche
require_once 'Model/search.php';

// Récupérer le terme de recherche depuis l'URL
$searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';

// Vérifier si le terme de recherche est défini
if (!empty($searchTerm)) {
    $posts = getArticlesBySearch($pdo, $searchTerm);
} else {
    $posts = [];
}

// Inclure la vue pour afficher les résultats de la recherche
require_once 'View/search.php';
?>

