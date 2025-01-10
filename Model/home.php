<?php
function getArticles(PDO $pdo)
{
  $query = "SELECT * FROM articles";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

