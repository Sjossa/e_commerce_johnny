<?php

// Inclure le modèle pour l'inscription
require "Model/inscription.php";

// Vérifier si la méthode de requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Récupérer et sanitiser les entrées utilisateur
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $verifpassword = filter_var($_POST['verifpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  // Vérifier si les champs ne sont pas vides
  if (!empty($username) && !empty($email) && !empty($password) && !empty($verifpassword)) {
    if (userExists($pdo, $email, $username)) {
      $_SESSION['error_message'] = 'L\'adresse email ou le nom d\'utilisateur existe déjà.';
    } else {
      // Créer l'utilisateur
      CreationUser($pdo, $username, $email, $password, $verifpassword);

      // Vérifier les informations d'identification de l'utilisateur
      $verifUser = verifUser($pdo, $email, $password);

      if ($verifUser) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['email'] = $verifUser['email'];
        $_SESSION['role'] = $verifUser['role'];

        // Rediriger vers la page d'accueil
        header('Location: index.php?component=home');
        exit;
      } else {
        // Message d'erreur si l'authentification échoue
        $_SESSION['error_message'] = 'Erreur lors de la création de l\'utilisateur ou de l\'authentification.';
      }
    }
  }
}

// Inclure la vue pour afficher le formulaire d'inscription
require "View/inscription.php";
?>

