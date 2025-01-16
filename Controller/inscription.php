<?php
require "Model/inscription.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $verifpassword = $_POST['verifpassword'];

CreationUser($pdo,$username,$email,$password,$verifpassword);

}
require "View/inscription.php";

