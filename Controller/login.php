<?php


// Inclure le modèle pour la connexion
require 'Model/login.php';

// Vérifier si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer et sanitiser les entrées utilisateur
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

  // Vérifier si les champs email et mot de passe ne sont pas vides
  if (!empty($email) && !empty($password)) {
    // Vérifier les informations d'identification de l'utilisateur
    $verifUser = verifUser($pdo, $email, $password);

    // Vérifier si l'utilisateur est authentifié
    if ($verifUser) {
      // Stocker les informations de l'utilisateur dans la session
      $_SESSION['email'] = $verifUser['email'];
      $_SESSION['role'] = $verifUser['role'];

      // Rediriger vers la page d'accueil
      header('Location: index.php?component=home');
      exit;
    } else {
      // Rediriger vers la page d'erreur
      header('Location: Partial/error.php');
      exit;
    }
  } else {
    $_SESSION['error_message'] = 'Veuillez remplir tous les champs.';
  }
}


require 'View/login.php';
