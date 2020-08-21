<?php

require_once '../../model/dto/selection.php';
require_once '../../model/dto/user.php';

require_once '../../model/dao/selectionDAO.php';

$movie = null;
session_start();

if(isset($_POST['imdbID'])){
    if (isset($_SESSION['user'])) {
        $movie_id = $_POST['imdbID'];
        $user = unserialize($_SESSION['user']);
        $call_res = selectionDAO::updateMovieSelection($user->getId(),$movie_id);
        if($call_res) $call_res = "\"1\"";
        else $call_res = "\"0\"";

    }
}

echo "\"Res\" :" . $call_res . "}";
