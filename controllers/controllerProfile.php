<?php
if(isset($_SESSION['user'])){
    require_once 'views/profile.php';
}else {
    if(isset($_GET['r'])){
        require_once 'controllerSignOut.php';
    } else{
        require_once 'controllerSignIn.php';
    }
}