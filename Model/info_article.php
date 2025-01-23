<?php

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

