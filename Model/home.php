<?php

function getPaginationInfo(PDO $pdo,  $page,  $perPage = 15,  $filtre_categorie = ''): array
{
  $offset = ($page - 1) * $perPage;
  $query = $filtre_categorie
    ? "SELECT COUNT(*) FROM articles WHERE id_categorie = :filtre_categorie"
    : "SELECT COUNT(*) FROM articles";

  $stmt = $pdo->prepare($query);
  if ($filtre_categorie) {
    $stmt->bindParam(':filtre_categorie', $filtre_categorie, PDO::PARAM_INT);
  }
  $stmt->execute();
  $totalArticles = $stmt->fetchColumn();

  return [
    'offset' => $offset,
    'totalPages' => ceil($totalArticles / $perPage),
    'perPage' => $perPage,
  ];
}

function getArticles(PDO $pdo, $page, $filtre_categorie = '')
{
  $pagination = getPaginationInfo($pdo, $page, 6, $filtre_categorie);

  $query = "SELECT articles.id_article,
                        articles.nom,
                        articles.image,
                        articles.stock,
                        articles.prix,
                        articles.description,
                        categories.nom AS categories_nom,
                        discount_percentage AS pourcentage
              FROM articles
              LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
              LEFT JOIN promotions ON articles.id_promotion = promotions.id_promotion";

  if ($filtre_categorie) {
    $query .= " WHERE articles.id_categorie = :filtre_categorie";
  }

  // Ajout des clauses LIMIT et OFFSET pour la pagination
  $query .= " LIMIT :perpage OFFSET :offset";

  $stmt = $pdo->prepare($query);

  // Liaison des paramètres
  if ($filtre_categorie) {
    $stmt->bindParam(':filtre_categorie', $filtre_categorie, PDO::PARAM_INT);
  }

  $stmt->bindParam(':perpage', $pagination['perPage'], PDO::PARAM_INT);
  $stmt->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);

  $stmt->execute();

  return [
    'articles' => $stmt->fetchAll(PDO::FETCH_ASSOC),
    'totalPages' => $pagination['totalPages'],
  ];
}


function getCategories(PDO $pdo): array
{
  $stmt = $pdo->query("SELECT id_categorie, nom FROM categories");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
