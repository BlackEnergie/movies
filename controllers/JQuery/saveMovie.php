<?php

require_once '../../model/dto/movie.php';
require_once '../../model/dto/actor.php';
require_once '../../model/dto/director.php';

require_once '../../model/dao/actorDAO.php';
require_once '../../model/dao/directorDAO.php';
require_once '../../model/dao/movieDAO.php';

$apiKey = '&type=movie&plot=full&apikey=98389f19';
$url = 'http://www.omdbapi.com/?i=';
$movie = null;
$actors = null;
$call_res = "";

if (isset($_POST['imdbID'])) {
    $imdbID = $_POST['imdbID'];
    $complete_url = $url . $imdbID . $apiKey;
    $json = file_get_contents($complete_url);
    $array = json_decode($json, true);
    if ($array['Response'] == 'True') {
        $call_res = movieDAO::exctractMovie($array);
    } else {
        $call_res = "error";
    }
    if(is_string($call_res)){
        echo $call_res;
    }
}