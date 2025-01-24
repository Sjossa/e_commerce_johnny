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

  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body data-bs-theme="dark">
  <?php require_once 'Partial/nav.php'; ?>
  <div class="container my-4" id="principal">
    <?php require "Partial/errors.php"; ?>
    <?php
    if (isset($_GET["component"])) {
      $componentName = htmlspecialchars($_GET["component"]);
      if (file_exists("Controller/$componentName.php")) {
        require "Controller/$componentName.php";
      } else {
        echo '<div class="alert alert-danger" role="alert">Erreur 404 : Composant non trouvé.</div>';
      }
    } else {
      require "Controller/home.php";
    }
    ?>
  </div>


  <footer class="bg-dark text-white py-3 mt-auto">
    <div class="container text-center">
      <small>© 2025 MonSite. Tous droits réservés.</small>
    </div>
  </footer>

  <script type="module" src="Asset/Shareds/bootstrap/bootstrap.bundle.min.js"></script>
  <script type="module" src="./Asset/Shareds/click.js"></script>

</body>

</html>
