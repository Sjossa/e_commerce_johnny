<?php

function email_verify($email, $validEmail)
{
  return $email === $validEmail;
}

/**
 * Vérifie les informations d'identification de l'utilisateur.
 *
 * @param PDO $pdo L'objet PDO pour la connexion à la base de données.
 * @param string $email L'email de l'utilisateur.
 * @param string $password Le mot de passe de l'utilisateur.
 * @return array|false Les informations de l'utilisateur si l'authentification réussit, false sinon.
 */
function verifUser(PDO $pdo, $email, $password)
{
  // Définir la requête SQL pour récupérer l'utilisateur par email
  $query = "SELECT * FROM users WHERE email = :email";

  try {
    // Préparer la requête
    $stmt = $pdo->prepare($query);

    // Lier le paramètre email
    $stmt->bindParam(':email', $email);

    // Exécuter la requête
    $stmt->execute();

    // Récupérer le résultat
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si un utilisateur a été trouvé
    if ($result) {
      $validPassword = $result['password'];

      // Vérifier le mot de passe
      if (password_verify($password, $validPassword)) {
        return $result;
      } else {
        return false;
      }
    } else {
      return false;
    }
  } catch (PDOException $e) {
    // En cas d'erreur, loguer l'erreur et retourner false
    error_log("Erreur lors de la vérification de l'utilisateur : " . $e->getMessage());
    return false;
  }
}
?>

