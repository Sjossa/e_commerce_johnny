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


function isPromotionValid(PDO $pdo,int $id_promotion): bool
{


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
