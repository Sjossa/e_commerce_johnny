<?php
function RecupCategorie(PDO $pdo): array
{
    $query = "SELECT id_categorie, nom FROM categories";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function AjoutArticle($pdo, $nom, $description, $image, $prix, $stock, $categorie)
{
    try {
        $query = "INSERT INTO articles (nom, description, image, prix, stock, id_categorie)
          VALUES (:nom, :description, :image, :prix, :stock, :categorie)";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':categorie', $categorie);

        $stmt->execute();
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}

function RecupArticle(PDO $pdo, int $id)
{
    $query = "SELECT
        articles.nom,
        articles.prix,
        articles.image,
        articles.stock,
        articles.description,
        categories.nom AS categories_nom
        FROM articles
        LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
        WHERE articles.id_article = :id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}

function validitéArticle($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM articles WHERE id_article = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt;
}


    function UpdateArticle(PDO $pdo, $id_article, $nom, $description, $image, $prix, $stock, $categorie)
    {
        $query = "UPDATE articles
              SET nom = :nom, description = :description, image = :image, prix = :prix, stock = :stock, id_categorie = :categorie
              WHERE id_article = :id_article";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':prix', $prix);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':categorie', $categorie);
        $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);

        $stmt->execute();
    }




