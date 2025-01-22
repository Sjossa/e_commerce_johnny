<?php
require 'Model/login.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = $_POST['password'];

  if (!empty($email) && !empty($password)) {

    $verifUser = verifUser($pdo, $email, $password);

    if ($verifUser) {

      $_SESSION['email'] = $verifUser['email'];
      $_SESSION['role'] = $verifUser['role'];


      header('Location: index.php?component=home');
      exit;
    } else {

      header('Partial/error.php');
      exit;
    }
  } else {
    // Message d'erreur si les champs sont vides
    $error_message = 'Veuillez remplir tous les champs.';
  }
}


require 'View/login.php';
?>

