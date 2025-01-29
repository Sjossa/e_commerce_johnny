<?php

require_once '../vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$roles = ['customer', 'manager'];

try {
  $pdo = new PDO(
    'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD']
  );

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'DB_HOST: ' . $_ENV['DB_HOST'] . "<br>";
  echo 'DB_USER: ' . $_ENV('DB_USER') . "<br>";
  echo 'DB_PASSWORD: ' . $_ENV('DB_PASSWORD') . "<br>";
  echo 'DB_NAME: ' . $_ENV('DB_NAME') . "<br>";

  die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Générer des utilisateurs
for ($i = 0; $i < 10; $i++) {
  $name = $faker->userName();
  $email = $faker->email();
  $password = password_hash($faker->password(), PASSWORD_BCRYPT);
  $role = $roles[array_rand($roles)];

  // Insertion dans la table 'users'
  $userQuery = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
  $stmtUser = $pdo->prepare($userQuery);
  $stmtUser->execute([$name, $email, $password, $role]);
}

// Insertion de l'utilisateur Ludovic si nécessaire
$usersLudovic = [
  ['username' => 'ludovic', 'email' => 'ludovic@user.fr', 'role' => 'customer', 'password' => '1234'],
  ['username' => 'ludovic', 'email' => 'ludovic@pro.fr', 'role' => 'manager', 'password' => '1234']
];

foreach ($usersLudovic as $userData) {
  $email = $userData['email'];
  $checkUserQuery = 'SELECT COUNT(*) FROM users WHERE email = ?';
  $stmtCheck = $pdo->prepare($checkUserQuery);
  $stmtCheck->execute([$email]);
  $userExists = $stmtCheck->fetchColumn();

  if (!$userExists) {
    $name = $userData['username'];
    $password = password_hash("1234", PASSWORD_BCRYPT);
    $role = $userData['role'];

    $userQuery = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
    $stmtUser = $pdo->prepare($userQuery);
    $stmtUser->execute([$name, $email, $password, $role]);
  }
}

// Générer des promotions et des catégories
for ($i = 0; $i < 10; $i++) {
  $discount_percentage = $faker->randomFloat(2, 5, 50);

  // Date de début de la promotion (1 à 6 mois dans le passé)
  $startDate = $faker->dateTimeBetween('-3 months'); // La date commence entre maintenant et 6 mois dans le passé

  // Date de fin de la promotion (max 6 mois après la date de début)
  $endDate = $faker->dateTimeBetween($startDate->format('Y-m-d H:i:s'), '+12 months'); // La date de fin est entre la date de début et 6 mois après

  // Formatage des dates en chaîne de caractères pour la base de données
  $startDate = $startDate->format('Y-m-d H:i:s');
  $endDate = $endDate->format('Y-m-d H:i:s');

  // Insertion dans la table 'promotions'
  $promotionQuery = 'INSERT INTO promotions (discount_percentage, debut_promotion, fin_promotion) VALUES (?, ?, ?)';
  $stmtPromotion = $pdo->prepare($promotionQuery);
  $stmtPromotion->execute([$discount_percentage, $startDate, $endDate]);

  // Générer une catégorie
  $categoryName = $faker->word();

  $categoryQuery = 'INSERT INTO categories (nom) VALUES (?)';
  $stmtCategory = $pdo->prepare($categoryQuery);
  $stmtCategory->execute([$categoryName]);
}


$queryCategories = $pdo->query('SELECT id_categorie FROM categories');
$categories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);

$queryPromotions = $pdo->query('SELECT id_promotion FROM promotions');
$promotions = $queryPromotions->fetchAll(PDO::FETCH_ASSOC);


$usedPromotionIds = [];

for ($i = 0; $i < 30; $i++) {
  $name = $faker->word();
  $description = $faker->text();
  $image = 'sl_z_072523_61700_05.webp';
  $price = $faker->randomFloat(2, 5, 1000);
  $stock = $faker->numberBetween(1, 100);

  // Sélectionner une catégorie au hasard
  $categoryId = $categories[array_rand($categories)]['id_categorie'];

  // Choisir une promotion, mais éviter de la répéter
  $promotionId = null;
  if (rand(0, 4) === 0 && count($promotions) > 0) {
    $promotionCandidates = array_diff(array_column($promotions, 'id_promotion'), $usedPromotionIds);
    if (count($promotionCandidates) > 0) {
      $promotionId = $promotionCandidates[array_rand($promotionCandidates)];
      $usedPromotionIds[] = $promotionId; // Marquer comme utilisée
    }
  }

  // Insérer l'article dans la base de données
  $articleQuery = 'INSERT INTO articles (nom, description, image, prix, stock, id_categorie, id_promotion)
                   VALUES (?, ?, ?, ?, ?, ?, ?)';
  $stmtArticle = $pdo->prepare($articleQuery);
  $stmtArticle->execute([$name, $description, $image, $price, $stock, $categoryId, $promotionId]);
}

echo "Données générées et insérées avec succès !\n";

header("Location: index.php");


