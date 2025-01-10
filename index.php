<?php
require_once 'config/BDD.php';
?>

<body data-bs-theme="dark">

  <div class="container">

    <?php

    require_once 'Partial/nav.php';
    if (isset($_GET["component"])) {
      $componentName = ($_GET["component"]);
      if (file_exists("Controller/$componentName.php")) {
        require "Controller/$componentName.php";
      } else {
        echo "Erreur 404";
      }
    }

    ?>
  </div>
  <script src="Partial/JS.js"></script>
</body>
