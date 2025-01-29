<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once 'config/BDD.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Projet PHP avec Bootstrap</title>
  <link rel="stylesheet" href="Asset/Css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="Asset/Css/Perso/e_commerce.css">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body style="background-color: #95a595;">



  <?php require_once 'Partial/nav.php'; ?>

  <?php if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])): ?>
    <?php require "Partial/errors.php"; ?>
  <?php endif; ?>

  <div class="container my-4" id="principal">
    <?php
    $componentName = $_GET["component"] ?? null;
    if ($componentName && file_exists("Controller/$componentName.php")) {
        require "Controller/$componentName.php";
    } else {
        require "Controller/home.php";
    }
    ?>
  </div>



  <script type="module" src="Asset/Shareds/bootstrap/bootstrap.bundle.min.js"></script>
  <script type="module" src="Asset/Shareds/click.js"></script>
</body>

</html>
