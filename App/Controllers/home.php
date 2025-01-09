<?php
require 'Models/home.php';


$posts = getArticles($pdo);


require 'Views/home.php';

?>

