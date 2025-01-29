<?php

require 'Model/login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

  if (!empty($email) && !empty($password)) {

    $verifUser = verifUser($pdo, $email, $password);

    if ($verifUser['success']) {
      $_SESSION['email'] = $verifUser['user']['email'];
      $_SESSION['role'] = $verifUser['user']['role'];

      header('Location: index.php?component=home');
      exit;
    } else {
      $_SESSION['error_message'] = $verifUser['error'];
      header('Location: index.php?component=login');
      exit;
    }
  } else {
    // Si l'email ou le mot de passe est vide, afficher un message d'erreur
    $_SESSION['error_message'] = 'Veuillez remplir tous les champs.';
    header('Location: index.php?component=login');
    exit;
  }
}

// Inclure la vue de la page de connexion
require 'View/login.php';
?>

