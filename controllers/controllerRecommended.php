<?php
if(isset($_SESSION["user"])){
    $display = "none";
    $nb = 0;
    $user = unserialize($_SESSION["user"]);
    $actors = selectionDAO::getFavoriteActors($user);
    $directors = selectionDAO::getFavoriteDirectors($user);
    $genres = selectionDAO::getFavoriteGenres($user);
    if(isset($_GET["Type"])){
        $display = "";
        $type = $_GET["Type"];
        switch ($type) {
            case "actor" :
                $movies = selectionDAO::getMoviesActor($_GET["ID"]);
                break;
            case "director" :
                $movies = selectionDAO::getMoviesDirector($_GET["ID"]);
                break;
            case "genre" :
                $movies = selectionDAO::getMoviesGenre($_GET["ID"]);
                break;
            default :
                $movies = array();
                break;
        }
        $nb = sizeof($movies);
    }
    require_once "views/recommended.php";
}else{
    header("Location:index.php?MP=home");
}