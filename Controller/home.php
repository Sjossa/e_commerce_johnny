<?php
require 'Model/home.php';

$page = isset($_GET['articles']) ? (int) $_GET['articles'] : 1;
$filtre_categorie = isset($_GET['filtre_categorie']) ? (int) $_GET['filtre_categorie'] : "";

$postsData = getArticles($pdo, $page,$filtre_categorie );
$categories = getCategories($pdo);

$posts = $postsData['articles'];
$totalPages = $postsData['totalPages'];

require 'View/home.php';
