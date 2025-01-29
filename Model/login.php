<?php
function verifUser(PDO $pdo, $email, $password)
{
  $query = "SELECT * FROM users WHERE email = :email";

  try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      $validPassword = $result['password'];
      if (password_verify($password, $validPassword)) {
        return ['success' => true, 'user' => $result];
      } else {
        return ['success' => false, 'error' => 'Mot de passe incorrect'];
      }
    } else {
      return ['success' => false, 'error' => 'Aucun utilisateur trouvé avec cet email'];
    }
  } catch (PDOException $e) {
    error_log("Erreur lors de la vérification de l'utilisateur : " . $e->getMessage());
    return ['success' => false, 'error' => 'Erreur lors de la vérification de l\'utilisateur'];
  }
}


