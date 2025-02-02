<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
header('Location: ../index.php');


}

session_destroy();
header('Location: ../index.php');
exit();
?>

