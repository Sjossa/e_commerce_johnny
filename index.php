<?php
session_start();
require __DIR__ . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require_once 'config/BDD.php';
require_once 'Partial/nav.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Projet PHP avec Bootstrap</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous">
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body data-bs-theme="dark">
  <div class="container my-4">
    <?php
    if (isset($_GET["component"])) {
      $componentName = htmlspecialchars($_GET["component"]); // Protéger contre les injections
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

  <!-- Footer -->
  <footer class="bg-dark text-white py-3 mt-auto">
    <div class="container text-center">
      <small>© 2025 MonSite. Tous droits réservés.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script type="module" src="./Partial/click.js"></script>

</body>

</html>
