<?php
function listeArticles(PDO $pdo)
{

  $limit = 10;
  $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
  $start = ($page - 1) * $limit;

  
  $query = "SELECT articles.id_article,
                  articles.nom,
                  articles.image,
                  articles.stock,
                  articles.description,
                  categories.nom AS categories_nom
           FROM articles
           LEFT JOIN categories ON articles.id_categorie = categories.id_categorie   ;";

  try {
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Récupérer tous les résultats
    return $stmt->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // En cas d'erreur, afficher l'erreur ou la loguer
    echo "Erreur SQL : " . $e->getMessage();
    return [];
  }
}

function DeleteArticles(PDO $pdo)
{
  if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    $query = "DELETE FROM articles WHERE id_article = :id";
    $stmt = $pdo->prepare($query);


    $stmt->bindValue(':id', $articleId, PDO::PARAM_INT);


    $stmt->execute();
    header('Location: aaaaaa.php');
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





