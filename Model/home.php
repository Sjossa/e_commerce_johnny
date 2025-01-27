<?php
function getArticles(PDO $pdo)
{

  $query = "SELECT * FROM articles limit 6";

  try {

    $stmt = $pdo->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    error_log("Erreur lors de la récupération des articles : " . $e->getMessage());
    return [];
  }
}
