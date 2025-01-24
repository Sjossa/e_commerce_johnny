<?php

function CreationUser($pdo, $username, $email, $password, $verifpassword)
{
    // Vérifier si les mots de passe correspondent
    if ($password !== $verifpassword) {
        echo "Les mots de passe ne correspondent pas !";
        return;
    }

    // Hacher le mot de passe
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Définir la requête SQL pour insérer un nouvel utilisateur
    $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";

    try {
        // Préparer la requête
        $stmt = $pdo->prepare($query);

        // Lier les paramètres pour éviter les injections SQL
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hash);

        // Exécuter la requête
        $stmt->execute();

        // Afficher un message de succès
        echo "Utilisateur créé avec succès !";
    } catch (PDOException $e) {
        // En cas d'erreur, loguer l'erreur et afficher un message d'erreur
        error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
        echo "Erreur lors de la création de l'utilisateur.";
    }
}

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



