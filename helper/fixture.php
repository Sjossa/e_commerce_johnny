<?php

require_once '../vendor/autoload.php';

$faker = Faker\Factory::create();

$pdo = new PDO('mysql:host=localhost;dbname=e_commerce', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Liste de rôles possibles pour les utilisateurs
$roles = ['admin', 'user', 'moderator'];

// Générer des utilisateurs, promotions et catégories
for ($i = 0; $i < 10; $i++) {

  // Données pour la table 'users'
  $name = $faker->userName();
  $email = $faker->email();
  $password = password_hash($faker->password(), PASSWORD_BCRYPT);
  $role = $roles[array_rand($roles)];

  // Insertion dans la table 'users'
  $userQuery = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
  $stmtUser = $pdo->prepare($userQuery);
  $stmtUser->execute([$name, $email, $password, $role]);

  // Données pour la table 'promotions'
  $discount_percentage = $faker->randomFloat(2, 5, 50); // Remise entre 5% et 50%

  // Insertion dans la table 'promotions' (sans association avec user)
  $promotionQuery = 'INSERT INTO promotions (discount_percentage) VALUES (?)';
  $stmtPromotion = $pdo->prepare($promotionQuery);
  $stmtPromotion->execute([$discount_percentage]);

  // Générer une catégorie aléatoire (mot)
  $categoryName = $faker->word();  // Un mot générique généré par Faker

  // Insertion dans la table 'categories' (sans association avec user)
  $categoryQuery = 'INSERT INTO categories (nom) VALUES (?)';
  $stmtCategory = $pdo->prepare($categoryQuery);
  $stmtCategory->execute([$categoryName]);

}

// Récupérer les IDs des catégories et des promotions après l'insertion
$queryCategories = $pdo->query('SELECT id_categorie FROM categories');
$categories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);

$queryPromotions = $pdo->query('SELECT id_promotion FROM promotions');
$promotions = $queryPromotions->fetchAll(PDO::FETCH_ASSOC);

// Générer 10 articles
for ($i = 0; $i < 10; $i++) {

  // Données pour les articles
  $name = $faker->word(); // Générer un nom d'article (exemple : 'sofa', 'car', etc.)
  $description = $faker->text(200); // Description d'article générée
  $image = 'sl_z_072523_61700_05.webp'; // Nom fixe pour l'image de l'article
  $price = $faker->randomFloat(2, 5, 1000); // Prix entre 5 et 1000 (format decimal)
  $stock = $faker->numberBetween(1, 100); // Quantité en stock

  // Sélection de la catégorie et de la promotion de manière aléatoire parmi celles existantes
  $categoryId = $categories[array_rand($categories)]['id_categorie'];
  $promotionId = $promotions[array_rand($promotions)]['id_promotion'];

  // Insertion dans la table 'articles'
  $articleQuery = 'INSERT INTO articles (nom, description, image, prix, stock, id_categorie, id_promotion) VALUES (?, ?, ?, ?, ?, ?, ?)';
  $stmtArticle = $pdo->prepare($articleQuery);
  $stmtArticle->execute([$name, $description, $image, $price, $stock, $categoryId, $promotionId]);

}

echo "Données générées et insérées avec succès !\n";

header("Location: index.php");


?>

