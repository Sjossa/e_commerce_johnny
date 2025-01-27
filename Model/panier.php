<?PHP
function RecupArticle(PDO $pdo, int $id) {
    $query = "
        SELECT
            articles.id_article,
            articles.nom,
            articles.prix,
            articles.image,
            articles.stock,
            articles.description,
            categories.nom AS categorie_nom,
            articles.id_promotion,
            promotions.discount_percentage AS pourcentage
        FROM articles
        LEFT JOIN categories ON articles.id_categorie = categories.id_categorie
        LEFT JOIN promotions ON articles.id_promotion = promotions.id_promotion
        WHERE articles.id_article = :id
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
}
?>
