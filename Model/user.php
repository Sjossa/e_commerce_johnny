<?php
function RecupUsers(PDO $pdo, $id)
{
  $query = "SELECT username, email, role FROM users WHERE id = :id";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();


  return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getEnumValues(PDO $pdo, $table, $column)
{
  $query = "SHOW COLUMNS FROM $table LIKE :column";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':column', $column, PDO::PARAM_STR);
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Extraire les valeurs ENUM du type
  preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
  if (!empty($matches[1])) {
    $values = str_getcsv($matches[1], ',', "'");
    return $values; // Retourne un tableau des valeurs
  }

  return [];
}




function validitéUsers($pdo, $id)
{
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = :id");
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  return $stmt;
}

function UpdateUsers(PDO $pdo, $id, $username, $email, $role)
{
  $query = "UPDATE users SET username = :username, email = :email, role = :role WHERE id = :id";
  $stmt = $pdo->prepare($query);

  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':role', $role);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
}
