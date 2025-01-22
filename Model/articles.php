<?php
function listeArticles(PDO $pdo, $page, $tri = '')
{
  $perPage = 5; // Nombre d'articles par page
  $offset = ($page - 1) * $perPage; // Calcul de l'offset pour la pagination

  // Si $tri existe et que c'est une colonne valide (nom ou stock), applique le tri
  $triColonne = '';
  $colonne = array('nom', 'stock','categories_nom'); // Colonnes valides pour le tri
  if (in_array($tri, $colonne)) {
    $triColonne = "ORDER BY $tri";
  }

  // Requête pour récupérer les articles en fonction du tri et de la pagination
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
             LEFT JOIN promotions ON  articles.id_promotion = promotions.id_promotion
             $triColonne
             LIMIT :perpage OFFSET :offset;";

  try {
    // Préparation et exécution de la requête
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':perpage', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer tous les articles
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer le total d'articles pour la pagination
    $totalArticles = $pdo->query("SELECT COUNT(*) FROM articles")->fetchColumn();
    $totalPages = ceil($totalArticles / $perPage); // Calcul du nombre total de pages

    // Retourner les articles ainsi que le total de pages
    return [
      'articles' => $articles,
      'totalPages' => $totalPages
    ];

  } catch (PDOException $e) {
    // En cas d'erreur, afficher l'erreur ou la loguer
    echo "Erreur SQL : " . $e->getMessage();
    return [];
  }
}





function DeleteArticles(PDO $pdo, $articleId)
{
  if ($articleId) {
    // Vérification de l'existence de l'article
    $checkQuery = "SELECT COUNT(*) FROM articles WHERE id_article = :id";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
    $stmt->execute();
    $articleExists = $stmt->fetchColumn();

    if ($articleExists) {
      // Si l'article existe, procéder à la suppression
      $query = "DELETE FROM articles WHERE id_article = :id";
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);
      $stmt->execute();
    } else {
      echo "Erreur : L'article avec l'ID $articleId n'existe pas.";
      return;
    }
  }
}


function UpCategorie(PDO $pdo, $categorie)
{
  $promotion = isset($_POST['promotion_creation']) && $_POST['promotion_creation'] !== ""
    ? $_POST['promotion_creation'] // Si une promotion manuelle est définie
    : $_POST['promotion']; // Sinon, prendre la promotion existante

  if ($promotion > 0) {
    // Si c'est un pourcentage, il peut falloir insérer une nouvelle promotion
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM promotions WHERE discount_percentage = :promotion");
    $stmt->bindParam(':promotion', $promotion);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
      // Insertion d'une nouvelle promotion avec ce pourcentage
      $queryInsert = "INSERT INTO promotions (discount_percentage) VALUES (:promotion)";
      $stmtInsert = $pdo->prepare($queryInsert);
      $stmtInsert->bindParam(':promotion', $promotion);
      $stmtInsert->execute();

      // Récupérer l'ID de la nouvelle promotion insérée
      $newPromotionId = $pdo->lastInsertId();
    } else {
      // Récupérer l'ID de la promotion existante
      $querySelect = "SELECT id_promotion FROM promotions WHERE discount_percentage = :promotion";
      $stmtSelect = $pdo->prepare($querySelect);
      $stmtSelect->bindParam(':promotion', $promotion);
      $stmtSelect->execute();
      $newPromotionId = $stmtSelect->fetchColumn();
    }
  } else {
    // Si aucune promotion sélectionnée ou définie, promotion sera NULL ou 0
    $newPromotionId = null;
  }

}





