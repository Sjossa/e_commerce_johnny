<?php
// Inclure le modèle
require 'Models/home.php';

// Appeler la fonction pour récupérer les articles
$posts = getnom($pdo);
var_dump('lol');
// Inclure la vue en passant les articles en tant que variable
require 'Views/home.php';
?>

