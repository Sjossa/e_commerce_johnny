<?php
require 'model/articles_promotion.php';

$posts = getArticles($pdo);

require 'View/articles_promotion.php';
