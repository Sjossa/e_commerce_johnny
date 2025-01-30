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
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

function userExists($pdo, $email) {
    $query = 'SELECT COUNT(*) FROM users WHERE email = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

// Insérer des utilisateurs aléatoires sans doublons
for ($i = 0; $i < 10; $i++) {
    do {
        $email = $faker->unique()->email();
    } while (userExists($pdo, $email));

    $name = $faker->userName();
    $password = password_hash($faker->password(), PASSWORD_BCRYPT);
    $role = $roles[array_rand($roles)];

    $query = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $email, $password, $role]);
}


$usersLudovic = [
    ['username' => 'ludovic', 'email' => 'ludovic@user.fr', 'role' => 'customer'],
    ['username' => 'ludovic', 'email' => 'ludovic@pro.fr', 'role' => 'manager']
];

foreach ($usersLudovic as $userData) {
    if (!userExists($pdo, $userData['email'])) {
        $password = password_hash("1234", PASSWORD_BCRYPT);
        $query = 'INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)';
        $stmt = $pdo->prepare($query);
        $stmt->execute([$userData['username'], $userData['email'], $password, $userData['role']]);
    }
}

// Générer des promotions uniques
$usedDiscounts = [];

for ($i = 0; $i < 10; $i++) {
    do {
        $discount_percentage = $faker->randomFloat(2, 5, 50);
    } while (in_array($discount_percentage, $usedDiscounts));

    $usedDiscounts[] = $discount_percentage;
    $startDate = $faker->dateTimeBetween('-3 months')->format('Y-m-d H:i:s');
    $endDate = $faker->dateTimeBetween($startDate, '+12 months')->format('Y-m-d H:i:s');

    $query = 'INSERT INTO promotions (discount_percentage, debut_promotion, fin_promotion) VALUES (?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$discount_percentage, $startDate, $endDate]);
}

// Générer des catégories uniques
$usedCategories = [];

for ($i = 0; $i < 10; $i++) {
    do {
        $categoryName = ucfirst($faker->unique()->word());
    } while (in_array($categoryName, $usedCategories));

    $usedCategories[] = $categoryName;

    $query = 'INSERT INTO categories (nom) VALUES (?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$categoryName]);
}

$queryCategories = $pdo->query('SELECT id_categorie FROM categories');
$categories = $queryCategories->fetchAll(PDO::FETCH_ASSOC);

$queryPromotions = $pdo->query('SELECT id_promotion FROM promotions');
$promotions = $queryPromotions->fetchAll(PDO::FETCH_ASSOC);

function articleExists($pdo, $name) {
    $query = 'SELECT COUNT(*) FROM articles WHERE nom = ?';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name]);
    return $stmt->fetchColumn() > 0;
}

// Générer des articles uniques
$usedArticleNames = [];

for ($i = 0; $i < 30; $i++) {
    do {
        $name = ucfirst($faker->unique()->word());
    } while (in_array($name, $usedArticleNames) || articleExists($pdo, $name));

    $usedArticleNames[] = $name;
    $description = $faker->text();
    $image = 'sl_z_072523_61700_05.webp';
    $price = $faker->randomFloat(2, 5, 1000);
    $stock = $faker->numberBetween(1, 100);
    $categoryId = $categories[array_rand($categories)]['id_categorie'];

    $promotionId = null;
    if (rand(0, 4) === 0 && count($promotions) > 0) {
        $promotionId = $promotions[array_rand($promotions)]['id_promotion'];
    }

    $query = 'INSERT INTO articles (nom, description, image, prix, stock, id_categorie, id_promotion)
              VALUES (?, ?, ?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $description, $image, $price, $stock, $categoryId, $promotionId]);
}

echo "Données générées et insérées avec succès !\n";

header("Location: index.php");
?>
