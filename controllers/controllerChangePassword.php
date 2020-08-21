<?php

if(isset($_SESSION['user'])){
    if(isset($_POST["password"])){
        //userDAO::updatePassword();
    }
}else{
    require_once 'controllerSignIn.php';
}