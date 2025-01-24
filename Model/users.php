<?php
function listeUsers(PDO $pdo, $page, $tri = '')
{
  $perPage = 5;
  $offset = ($page - 1) * $perPage;

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
    $stmt->bindValue(':perpage', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalPages = ceil($totalUsers / $perPage);

    return [
      'users' => $users,
      'totalPages' => $totalPages
    ];

  } catch (PDOException $e) {
    error_log("Erreur SQL : " . $e->getMessage());
    return [];
  }
}

function deleteUsers(PDO $pdo, $usersId)
{
  if ($usersId && is_int($usersId) && $usersId > 0) {
    $checkQuery = "SELECT COUNT(*) FROM users WHERE id = :id";
    try {
      $stmt = $pdo->prepare($checkQuery);
      $stmt->bindValue(':id', $usersId, PDO::PARAM_INT);
      $stmt->execute();
      $usersExists = $stmt->fetchColumn();

      if ($usersExists) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':id', $usersId, PDO::PARAM_INT);
        $stmt->execute();
        return true; // Indiquer que la suppression a réussi
      } else {
        error_log("Erreur : L'utilisateur avec l'ID $usersId n'existe pas.");
        return false; // Indiquer que l'utilisateur n'existe pas
      }
    } catch (PDOException $e) {
      error_log("Erreur SQL : " . $e->getMessage());
      return false; // Indiquer qu'une erreur s'est produite
    }
  }
  return false; // Indiquer que l'ID de l'utilisateur est invalide
}
?>

