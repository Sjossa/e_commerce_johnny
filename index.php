<?php
session_start();
    require __DIR__ . "/vendor/autoload.php";
    $dotenv = Dotenv\Dotenv ::createImmutable(__DIR__);
    $dotenv -> safeLoad();

    require_once 'config/BDD.php';
    require_once 'controller/securite.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mon Projet PHP avec Bootstrap</title>
	<link rel="stylesheet" href="Includes/bootstrap_css/bootstrap.min.css">
	<link rel="stylesheet" href="Includes/Bootstrap-icons/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Asset/Css/Perso/e_commerce.css">




</head>

<body style="background-color: #95a595;">


<?php require_once 'Partial/nav.php'; ?>

<?php if (!empty($_SESSION['error_message']))
 require "Partial/errors.php"; ?>


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


<script type="module" src="Includes/bootstrap_js/bootstrap.bundle.min.js"></script>
<script type="module" src="Asset/Shared/click.js"></script>
</body>

</html>
