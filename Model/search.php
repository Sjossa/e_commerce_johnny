<?php

function getArticlesBySearch(PDO $pdo, $searchTerm)
{
    $query = "SELECT * FROM articles WHERE nom LIKE :searchTerm ";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

