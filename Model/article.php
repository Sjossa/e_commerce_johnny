<?php
// Récupération des catégories
function RecupCategorie(PDO $pdo): array
{
    $query = "SELECT id_categorie, nom FROM categories";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération des promotions
function Recuppromotion(PDO $pdo): array
{
    $query = "SELECT id_promotion, discount_percentage FROM promotions";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération d'un article par ID
function RecupArticle(PDO $pdo, int $id)
{
    $query = "SELECT
    articles.id_article,
        articles.nom,
        articles.prix,
        articles.image,
        articles.stock,
        articles.description,
        categories.nom AS categories_nom,
        articles.id_promotion,
        promotions.discount_percentage AS pourcentage
      FROM articles
      LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
      LEFT JOIN promotions ON articles.id_promotion = promotions.id_promotion
      WHERE articles.id_article = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

// Validation de l'existence d'un article
function ValiditeArticle(PDO $pdo, $id)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE id_article = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

function VerificationPromotion($pdo,$id){
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM promotions WHERE discount_percentage = :discount_percentage");
    $stmt->bindParam(':discount_percentage', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Ajout d'une promotion
function AjoutPromotion(PDO $pdo, int $promotion): int
{
    $query = "INSERT INTO promotions (discount_percentage) VALUES (:discount_percentage)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':discount_percentage', $promotion, PDO::PARAM_INT);
    $stmt->execute();
    return $pdo->lastInsertId(); // Retourne l'ID de la promotion insérée
}

// Ajout d'un article
function AjoutArticle(PDO $pdo, $nom, $description, $image, $prix, $stock, $categorie, $promotion = null)
{
    $query = "INSERT INTO articles (nom, description, image, prix, stock, id_categorie, id_promotion)
      VALUES (:nom, :description, :image, :prix, :stock, :categorie, :id_promotion)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':id_promotion', $promotion);
    $stmt->execute();
}

// Mise à jour d'un article existant
// Mise à jour de l'article avec gestion des erreurs
function UpdateArticle(PDO $pdo, $id_article, $nom, $description, $image, $prix, $stock, $categorie, $promotion)
{
    $query = "UPDATE articles
              SET nom = :nom, description = :description, image = :image, prix = :prix, stock = :stock,
                  id_categorie = :categorie, id_promotion = :promotion
              WHERE id_article = :id_article";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':prix', $prix);
    $stmt->bindParam(':stock', $stock);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':promotion', $promotion, PDO::PARAM_INT);
    $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("Erreur PDO: " . $e->getMessage());
        return false;
    }
}



