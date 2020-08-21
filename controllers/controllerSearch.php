<?php
$apiKey = '&type=movie&apikey=98389f19';
$url_search = 'http://www.omdbapi.com/?s=';
$url_infos = 'http://www.omdbapi.com/?i=';

$movie = null;
$exists = false;
$actors = null;

$obj_director = new Director();
$obj_actors = array();

$formSearch = new Formulaire('post', 'index.php?MP=Search', 'searchMultipleByTitle', 'contentRecherche');

$formSearch->ajouterComposantLigne($formSearch->creerInputSearch('titleMultiple' ,'titleMultiple', '', 1, 'Title', '', 'danger', 'Search'));
$formSearch->ajouterComposantTab();

$formSearch->creerFormulaire();


if(isset($_POST['titleMultiple']))  $search = $_POST['titleMultiple'];    // User making a search from this tab
elseif (isset($_GET["S"]))          $search = $_GET["S"];                 // User come from Catalogue tab

if(isset($search)){
    if(isset($_SESSION["user"])){
        $user = unserialize($_SESSION['user']);
    }
    $title_url = urlencode($search);
    $complete_url = $url_search . $title_url . $apiKey;
    $json = file_get_contents($complete_url);
    $array = json_decode($json, true);
    if($array['Response'] == 'True'){
        $movies_results = [];
        $i = 0;
        foreach ($array['Search'] as $movie_data){
            $complete_url = $url_infos . $movie_data['imdbID'] . $apiKey;
            $json = file_get_contents($complete_url);
            $array_infos = json_decode($json, true);
            $movie = movieDAO::exctractMovie($array_infos);
            if (!(is_string($movie))){
                $movies_results[] = $movie;
            }
            $i++;
        }
    }
}

require_once 'views/results.php';
