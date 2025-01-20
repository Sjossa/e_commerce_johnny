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
                    articles.description,
                    categories.nom AS categories_nom
             FROM articles
             LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
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
    $query = "INSERT INTO categories (nom) VALUES (:nom)";
    $stmt = $pdo->prepare($query);

    // Lier le paramètre à la variable $categorie
    $stmt->bindParam(':nom', $categorie);

    // Exécuter la requête
    $stmt->execute();
}





