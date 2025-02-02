<?php
function getArticlesBySearch(PDO $pdo, $searchTerm)
{
    $query = "SELECT * FROM articles WHERE nom LIKE :searchTerm";

    try {
        $stmt = $pdo->prepare($query);

        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur lors de la recherche des articles : " . $e->getMessage());
        return [];
    }
}
?>

