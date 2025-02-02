<?php

// Fonction pour récupérer le critère de tri, avec une protection contre les injections SQL.
function getTri(string $tri = ''): string
{
  $validSortColumns = ['stock', 'prix']; // Colonnes autorisées pour le tri.
  // Vérifier si le critère est valide, sinon on trie par défaut par le nom.
  $tri = in_array($tri, $validSortColumns, true) ? $tri : 'nom';
  return "ORDER BY $tri ";
}

// Fonction pour obtenir les informations de pagination, avec filtrage optionnel de la catégorie.
function getPaginationInfo(PDO $pdo, int $page, int $perPage = 1, string $filtre_categorie = '', bool $promotion = false): array
{
  $offset = ($page - 1) * $perPage;

  // Construire la requête pour compter les articles correspondant à la promotion.
  $query = "
        SELECT COUNT(*)
        FROM articles
        LEFT JOIN promotions ON articles.id_promotion = promotions.id_promotion
        WHERE articles.id_promotion IS NOT NULL
        AND promotions.debut_promotion <= NOW()
        AND promotions.fin_promotion >= NOW()"; // Ajout des conditions pour valider la promotion.

  // Ajouter un filtre de catégorie si spécifié.
  if ($filtre_categorie) {
    $query .= " AND articles.id_categorie = :filtre_categorie";
  }

  // Exécution de la requête.
  $stmt = $pdo->prepare($query);

  // Lier le paramètre de filtre de catégorie si présent.
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

// Fonction pour récupérer les articles avec des promotions valides, avec pagination et tri.
function getArticles(PDO $pdo, int $page, string $tri = '', string $filtre_categorie = ''): array
{
  // Récupération des informations de pagination.
  $pagination = getPaginationInfo($pdo, $page, 6, $filtre_categorie);

  // Construire la requête pour récupérer les articles avec promotions valides.
  $query = "
        SELECT articles.id_article,
               articles.nom,
               articles.image,
               articles.stock,
               articles.prix,
               articles.description,
               categories.nom AS categories_nom,
               discount_percentage AS pourcentage
        FROM articles
        LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
        LEFT JOIN promotions ON articles.id_promotion = promotions.id_promotion
        WHERE articles.id_promotion IS NOT NULL
        AND promotions.debut_promotion <= NOW()
        AND promotions.fin_promotion >= NOW()"; // Filtrage des promotions valides.

  // Ajouter un filtre pour la catégorie si précisé.
  if ($filtre_categorie) {
    $query .= " AND articles.id_categorie = :filtre_categorie";
  }

  // Appliquer le tri et la pagination.
  $query .= " " . getTri($tri) . " LIMIT :perpage OFFSET :offset";

  // Préparation et exécution de la requête.
  $stmt = $pdo->prepare($query);

  // Lier les paramètres pour la catégorie, la pagination.
  if ($filtre_categorie) {
    $stmt->bindParam(':filtre_categorie', $filtre_categorie, PDO::PARAM_INT);
  }

  $stmt->bindParam(':perpage', $pagination['perPage'], PDO::PARAM_INT);
  $stmt->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);

  $stmt->execute();

  // Retourner les articles et les informations de pagination.
  return [
    'articles' => $stmt->fetchAll(PDO::FETCH_ASSOC),
    'totalPages' => $pagination['totalPages'],
  ];
}

// Fonction pour récupérer toutes les catégories associées à des articles en promotion.
function getCategories(PDO $pdo): array
{
  // Requête pour récupérer les catégories des articles en promotion.
  $stmt = $pdo->query("
        SELECT DISTINCT categories.id_categorie, categories.nom
        FROM categories
        INNER JOIN articles ON categories.id_categorie = articles.id_categorie
        INNER JOIN promotions ON articles.id_promotion = promotions.id_promotion
        WHERE articles.id_promotion IS NOT NULL
        AND promotions.debut_promotion <= NOW()
        AND promotions.fin_promotion >= NOW()"); 

  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

