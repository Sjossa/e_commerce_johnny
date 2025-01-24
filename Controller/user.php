<?php

require 'Model/user.php'; // Inclusion du modèle

// Récupération et validation de l'ID
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;


if ($id > 0) {
  // Vérifier l'existence de l'utilisateur avec l'ID
  $stmt = validitéUsers($pdo, $id);

  if ($stmt->fetchColumn() > 0) {
    // Récupération des valeurs ENUM pour la colonne "role"
    $role = getEnumValues($pdo, 'users', 'role');

    // Récupérer les données de l'utilisateur
    $article = RecupUsers($pdo, $id);

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = trim($_POST['username'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $roleSelection = trim($_POST['role'] ?? '');

      // Vérification que le rôle est valide
      if (in_array($roleSelection, $role, true)) {
        // Mettre à jour les informations utilisateur
        UpdateUsers($pdo, $id, $username, $email, $roleSelection);

        // Redirection après mise à jour
        header("Location: index.php?component=users");
        exit();
      } else {
        $_SESSION['error_message'] = "Le rôle sélectionné est invalide.";
      }
    }
  } else {
    // Redirection si l'utilisateur n'existe pas
    header("Location: index.php?component=users");
    exit();
  }
} else {
  // Redirection si l'ID est invalide
  header("Location: index.php?component=home");
  exit();
}

require 'View/user.php';

