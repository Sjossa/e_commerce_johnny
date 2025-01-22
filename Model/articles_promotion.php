<?php
function getArticles(PDO $pdo)
{
  $query = "SELECT * FROM articles";
  $stmt = $pdo->prepare($query);

  try {
    $stmt->execute();
  } catch (PDOException $e) {

    return [];
  }

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
