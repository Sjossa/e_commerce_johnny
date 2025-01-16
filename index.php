<?php
session_start();
require_once 'config/BDD.php';
require_once 'Partial/nav.php';
if (isset($_SESSION['role']) && isset($_SESSION['email']) && !empty($_SESSION['role']) && !empty($_SESSION['email'])) {
  var_dump($_SESSION['role']);
  var_dump($_SESSION['email']);
}

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
  rel="stylesheet"
  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
  crossorigin="anonymous">


<body data-bs-theme="dark">

  <div class="container">

    <?php


    if (isset($_GET["component"])) {

      $componentName = $_GET["component"];
      if (file_exists("Controller/$componentName.php")) {
        require "Controller/$componentName.php";
      } else {
        require "Partial/error.php";
      }

    } else {
require "Controller/home.php";
    }




    ?>


  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script type="module" src="./Partial/click.js"></script>


</body>
