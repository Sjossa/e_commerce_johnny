<?php

function email_verify($email, $validEmail)
{
  return $email === $validEmail;
}

function verifUser(PDO $pdo, $email, $password)
{
  $query = "SELECT * FROM users WHERE email = :email ";
  $stmt = $pdo->prepare($query);
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);


  if ($result) {
    $validPassword = $result['password'];

    if (password_verify($password, $validPassword)) {

      return $result;
    } else {
      return false;
    }
  } else {
    return false;
  }
}

?>

