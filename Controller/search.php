<?php
require_once 'Model/search.php';

$searchTerm = isset($_GET['q']) ? $_GET['q'] : '';

if ($searchTerm) {
    $posts = getArticlesBySearch($pdo, $searchTerm);
} else {
    $posts = [];
}

require_once 'View/search.php';


