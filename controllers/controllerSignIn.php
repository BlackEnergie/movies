<?php

$error = false;
$email = "";

if(isset($_POST['email'])){
    $email = $_POST['email'];
    $user = userDAO::connection($email, $_POST['password']);
    $error = !$user;
    if($user){
        $_SESSION['user'] = serialize($user);
        header("Location: index.php?MP=profile");
    }
}

require_once 'views/constant/signIn.php';