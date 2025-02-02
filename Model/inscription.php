<?php

function CreationUser($pdo, $username, $email, $password, $verifpassword)
{
    // Hacher le mot de passe
    $hash = password_hash($password, PASSWORD_DEFAULT);


    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

    try {

        $stmt = $pdo->prepare($query);


        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);


        $stmt->execute();

    } catch (PDOException $e) {
        // En cas d'erreur, loguer l'erreur et afficher un message d'erreur
        error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());

    }
}

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
                return $result;
            } else {
                return false;
            }
        } else {
            return false;
        }
    } catch (PDOException $e) {
       
        error_log("Erreur lors de la vérification de l'utilisateur : " . $e->getMessage());
        return false;
    }
}

function userExists($pdo, $email, $username)
{
    $query = "SELECT COUNT(*) FROM users WHERE email = :email OR username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchColumn() > 0;
}

?>



