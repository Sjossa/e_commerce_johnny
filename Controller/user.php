<?php

require 'Model/user.php'; // Inclusion du modèle

// Récupération et validation de l'ID
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id > 0) {

  $stmt = validitéUsers($pdo, $id);

  if ($stmt->fetchColumn() > 0) {

    $role = getEnumValues($pdo, 'users', 'role');

    // Récupérer les données de l'utilisateur
    $article = RecupUsers($pdo, $id);
    if (!$article) {
      $_SESSION['error_message'] = "Erreur lors de la récupération des informations de l'utilisateur.";
      header("Location: index.php?component=users");
      exit();
    }

    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = trim($_POST['username'] ?? '');
      $email = trim($_POST['email'] ?? '');
      $roleSelection = trim($_POST['role'] ?? '');

      if (in_array($roleSelection, $role, true)) {
        // Mettre à jour les informations utilisateur
        UpdateUsers($pdo, $id, $username, $email, $roleSelection);

        $_SESSION['success_message'] = "Les informations de l'utilisateur ont été mises à jour avec succès.";

        

        exit(); // Arrêter le script après la redirection
      } else {
        $_SESSION['error_message'] = "Le rôle sélectionné est invalide.";
      }
    }
  } else {
    // Redirection si l'utilisateur n'existe pas
    $_SESSION['error_message'] = "Utilisateur non trouvé.";
    header("Location: index.php?component=users");
    exit();
  }
} else {
  // Redirection si l'ID est invalide
  header("Location: index.php?component=home");
  exit();
}

require 'View/user.php';
