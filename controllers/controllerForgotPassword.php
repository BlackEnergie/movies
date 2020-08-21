<?php
$sent = isset($_POST['forgot']);

if (isset($_SESSION['user'])) {
    include_once 'views/profile.php';
} else {
    if(!$sent){
        include_once 'views/constant/forgotPassword.php';
    } else{
        $email = $_POST['forgot'];
        if(userDAO::exists($email)){
            forgotPassword($email);
        }
        require_once 'views/constant/sentForgotPassword.php';
    }
}