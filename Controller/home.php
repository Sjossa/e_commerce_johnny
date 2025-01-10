<?php
require 'Model/home.php';

$posts = getArticles($pdo);

require 'View/home.php';

?>
