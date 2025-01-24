<?php
// Fonction pour définir le tri des résultats
function getTri(string $tri = ''): string
{
  $validSortColumns = [ 'stock','prix'];

  if (in_array($tri, $validSortColumns, true)) {

    return "ORDER BY $tri"; // Retourne ORDER BY avec la colonne de tri spécifiée
  }

  return "ORDER BY nom"; // Par défaut, tri par nom
}

// Fonction pour obtenir les informations de pagination en tenant compte d'un filtre catégorie
function getPaginationInfo(PDO $pdo, $page, $perPage = 5, $filtre_categorie = ''): array
{
  // Calcul de l'offset en fonction de la page
  $offset = ($page - 1) * $perPage;


  $query = $filtre_categorie
    ? "SELECT COUNT(*) FROM articles WHERE id_categorie = :filtre_categorie"
    : "SELECT COUNT(*) FROM articles";

  $stmt = $pdo->prepare($query);

  // Si un filtre est appliqué, on lie le paramètre
  if ($filtre_categorie) {
    $stmt->bindParam(':filtre_categorie', $filtre_categorie, PDO::PARAM_INT);
  }

  $stmt->execute();
  $totalArticles = $stmt->fetchColumn();
  $totalPages = ceil($totalArticles / $perPage);

  return [
    'offset' => $offset,
    'totalPages' => $totalPages,
    'perPage' => $perPage,
    'totalArticles' => $totalArticles
  ];
}

// Fonction pour lister les articles avec pagination, tri et filtrage par catégorie
function FiltreArticles(PDO $pdo, $page, $tri = '', $filtre_categorie = '')
{
  // Générer la clause ORDER BY
  $triColonne = getTri($tri);
  // Obtenir les infos de pagination, y compris l'offset et le total d'articles filtrés
  $pagination = getPaginationInfo($pdo, $page, 5, $filtre_categorie);

  // Début de la requête avec jointures nécessaires
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

  // Si un filtre de catégorie est appliqué, ajout de la clause WHERE
  if ($filtre_categorie) {
    $query .= "  WHERE articles.id_categorie = :filtre_categorie";
  }

  // Ajouter le tri et la pagination à la requête
  $query .= " $triColonne LIMIT :perpage OFFSET :offset;";

  try {
    // Préparation de la requête
    $stmt = $pdo->prepare($query);

    // Si un filtre de catégorie est appliqué, lier la valeur
    if ($filtre_categorie) {
      $stmt->bindParam(':filtre_categorie', $filtre_categorie, PDO::PARAM_INT);
    }

    // Lier les paramètres de pagination
    $stmt->bindParam(':perpage', $pagination['perPage'], PDO::PARAM_INT);
    $stmt->bindParam(':offset', $pagination['offset'], PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer tous les articles
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retour des résultats avec la pagination
    return [
      'articles' => $articles,
      'totalPages' => $pagination['totalPages']
    ];

  } catch (PDOException $e) {
    // Gestion d'erreur SQL
    echo "Erreur SQL : " . $e->getMessage();
    return [];
  }
}

// Fonction pour supprimer un article
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
      // Suppression de l'article s'il existe
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

// Fonction pour mettre à jour une catégorie avec une promotion
function UpCategorie(PDO $pdo, $categorie)
{
  $promotion = isset($_POST['promotion_creation']) && $_POST['promotion_creation'] !== ""
    ? $_POST['promotion_creation'] // Si une promotion manuelle est définie
    : $_POST['promotion']; // Sinon, prendre la promotion existante

  if ($promotion > 0) {
    // Si le pourcentage de promotion est spécifié, vérifier s'il existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM promotions WHERE discount_percentage = :promotion");
    $stmt->bindParam(':promotion', $promotion);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
      // Si la promotion n'existe pas, insérer une nouvelle promotion
      $queryInsert = "INSERT INTO promotions (discount_percentage) VALUES (:promotion)";
      $stmtInsert = $pdo->prepare($queryInsert);
      $stmtInsert->bindParam(':promotion', $promotion);
      $stmtInsert->execute();

      // Récupérer l'ID de la nouvelle promotion
      $newPromotionId = $pdo->lastInsertId();
    } else {
      // Si la promotion existe déjà, récupérer son ID
      $querySelect = "SELECT id_promotion FROM promotions WHERE discount_percentage = :promotion";
      $stmtSelect = $pdo->prepare($querySelect);
      $stmtSelect->bindParam(':promotion', $promotion);
      $stmtSelect->execute();
      $newPromotionId = $stmtSelect->fetchColumn();
    }
  } else {
    // Si aucune promotion définie, mettre à NULL ou 0
    $newPromotionId = null;
  }
}

// Fonction pour récupérer les catégories disponibles
function RecupCategorie(PDO $pdo): array
{
  $query = "SELECT id_categorie, nom FROM categories";
  $stmt = $pdo->prepare($query);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

