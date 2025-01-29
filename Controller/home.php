<?php
require 'Model/home.php';

$page = isset($_GET['articles']) ? (int) $_GET['articles'] : 1;
$tri = isset($_GET['tri']) ? $_GET['tri'] : '';
$filtre_categorie = isset($_GET['filtre_categorie']) ? (int) $_GET['filtre_categorie'] : 0;

$postsData = getArticles($pdo, $page, $tri, $filtre_categorie);
$categories = getCategories($pdo);

$posts = $postsData['articles'];
$totalPages = $postsData['totalPages'];

require 'View/home.php';
