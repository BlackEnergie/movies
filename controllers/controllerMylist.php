<?php

if(isset($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
    $movies = selectionDAO::getMoviesSelection($user);
    $nb = sizeof($movies);
    require_once "views/mylist.php";
}else{
    header("Location:index.php?MP=home");
}