<?php
require 'config/database/BDD.php';
require 'config/utulitaire/nav.php';

$routes = [
  'home' => 'Controllers/home.php',
  'about' => 'Views/about.php',
  'contact' => 'Controllers/contact.php'
];


$component = isset($_GET['component']) ? $_GET['component'] : 'home';


if (!array_key_exists($component, $routes)) {

  $component = 'home';
}


require $routes[$component];
?>

