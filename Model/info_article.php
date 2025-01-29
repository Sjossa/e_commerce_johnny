<?php

// Récupère toutes les catégories
function RecupCategorie(PDO $pdo): array
{
    $query = "SELECT id_categorie, nom FROM categories";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupère toutes les promotions valides (en cours)
function Recuppromotion(PDO $pdo): array
{
    $query = "
        SELECT id_promotion, discount_percentage
        FROM promotions
        WHERE debut_promotion <= NOW()
        AND fin_promotion >= NOW()"; 
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Récupération d'un article par son ID
function RecupArticle(PDO $pdo, int $id)
{
    $query = "
        SELECT
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

// Vérification de l'existence d'un article
function ValiditeArticle(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE id_article = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

// Vérification de la validité d'une promotion (en cours)
function ValiditePromotion(PDO $pdo, int $id): bool
{
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM promotions
        WHERE id_promotion = :id
        AND debut_promotion <= NOW()
        AND fin_promotion >= NOW()");

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Retourne true si la promotion est valide, false sinon.
    return $stmt->fetchColumn() > 0;
}
function isPromotionValid(int $id_promotion): bool
{
    global $pdo;

    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM promotions
        WHERE id_promotion = :id
        AND debut_promotion <= NOW()
        AND fin_promotion >= NOW()");

    $stmt->bindParam(':id', $id_promotion, PDO::PARAM_INT);
    $stmt->execute();


    return $stmt->fetchColumn() > 0;
}

?>

