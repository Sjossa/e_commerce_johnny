<?php
    require_once 'model/securite.php';
    
    
    
    
    function checkPermission($requiredRole) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $requiredRole) {
            header('Location: index.php?component=home'); // Rediriger si l’utilisateur n'a pas le bon rôle
            exit;
        }
    }
