<?php
function CreationUser($pdo, $username, $email, $password, $verifpassword) {


    if ($password !== $verifpassword) {
        echo "Les mots de passe ne correspondent pas !";
        return;
    }


    $hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $pdo->prepare($query);

    // Lier les paramètres pour éviter les injections SQL
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hash);

    // Exécuter la requête
    $stmt->execute();
}

