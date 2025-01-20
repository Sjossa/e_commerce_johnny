<?php
function listeUsers(PDO $pdo, $page, $tri = '')
{
  $perPage = 5; // Nombre d'utilisateurs par page
  $offset = ($page - 1) * $perPage;

  // Colonnes autorisées pour le tri
  $colonnes = ['username', 'email', 'role'];
  $orderBy = '';

  if (!empty($tri)) {
    $order = 'ASC';
    if (strpos($tri, '_desc') !== false) {
      $order = 'DESC';
      $tri = str_replace('_desc', '', $tri);
    }
    // Validation de la colonne pour éviter les injections SQL
    if (in_array($tri, $colonnes, true)) {
      $orderBy = "ORDER BY $tri $order";
    }
  }

  // Préparer la requête
  $query = "SELECT * FROM users $orderBy LIMIT :perpage OFFSET :offset;";

  try {
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':perpage', $perPage, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalPages = ceil($totalUsers / $perPage);

    return [
      'users' => $users,
      'totalPages' => $totalPages
    ];

  } catch (PDOException $e) {
    echo "Erreur SQL : " . $e->getMessage();
    return [];
  }
}


function DeleteUsers(PDO $pdo, $usersId)
{
  if ($usersId) {
    $checkQuery = "SELECT COUNT(*) FROM users WHERE id = :id";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->bindValue(':id', $usersId, PDO::PARAM_INT);
    $stmt->execute();
    $usersExists = $stmt->fetchColumn();

    if ($usersExists) {
      $query = "DELETE FROM users WHERE id = :id";
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(':id', $usersId, PDO::PARAM_INT);
      $stmt->execute();
    } else {
      echo "Erreur : L'utilisateur avec l'ID $usersId n'existe pas.";
      return;
    }
  }
}
?>

