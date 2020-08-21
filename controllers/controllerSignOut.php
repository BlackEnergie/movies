<?php
$message = "";

if (isset($_POST['email'])) {
    $user = new User();
    $user->setEmail($_POST['email']);
    $user->setFirstname($_POST['firstname']);
    $user->setLastname($_POST['lastname']);
    $user->setRegistration(date("Y-m-d H:i:s"));
    $check_user = userDAO::exists($_POST['email']);
    if($check_user != 1){
        $create_user = userDAO::registration($user, $_POST['password']);
        if ($create_user) {
            $user = userDAO::setIdUser($user);
            print_r($user);
            $_SESSION['user'] = serialize($user);
            header("Location: index.php?MP=profile");
        } else {
            $message = 'Registration failed.';
        }
    }else{
        $message = 'An account is already linked to this email.';
    }
}

require_once 'views/constant/signOut.php';















