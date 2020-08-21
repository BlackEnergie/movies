<?php
$apiKey = '&type=movie&plot=full&apikey=98389f19';
$url = 'http://www.omdbapi.com/?t=';
$movie = null;
$exists = false;
$actors = null;
$html_exists = "";

$obj_director = new Director();
$obj_actors = array();

$formSearch = new Formulaire('post', 'index.php?MP=Test', 'searchByTitle', 'contentRecherche');
$formSave = new Formulaire('post', 'index.php?MP=Test', 'save', 'contentRecherche');

$formSearch->ajouterComposantLigne($formSearch->creerInputTexte('title' ,'title', '', 1, 'Title', ''));
$formSearch->ajouterComposantLigne($formSearch->creerInputSubmit('search', 'search', 'Search', 'danger'));
$formSearch->ajouterComposantTab();

$formSearch->creerFormulaire();

if(isset($_POST['search'])){
    $_SESSION['search'] = $_POST['search'];

    $title_url = urlencode($_POST['title']);
    $complete_url = $url . $title_url . $apiKey;
    $json = file_get_contents($complete_url);
    $array = json_decode($json, true);
    if($array['Response'] == 'True'){
        $movie = new Movie();
        $movie->hydrate($array);
        $_SESSION['movie_array'] = $array;

        if(movieDAO::checkMovie($movie) != 0){
            $exists = true;
            $html_exists = "<div class='w-25 mx-auto mt-4 alert alert-primary' role='alert'>This movie is already saved</div>";
        } else{
            $formSave->ajouterComposantLigne($formSearch->creerInputSubmit('save', 'save', 'Save', 'dark'));
            $formSave->ajouterComposantTab();
        }

    } else{
        echo 'Aucun résultat pour ' . $_POST['title'] . '.';
    }
}

$formSave->creerFormulaire();

if(isset($_POST['save'])){
    $movie = new Movie();
    $array = $_SESSION['movie_array'];
    $movie->hydrate($array);

    $released = DateTime::createFromFormat('j M Y', $movie->getReleased());
    $movie->setReleased($released);

    $actors = explode(", " , $movie->getActors());

    foreach ($actors as $actor){
        $obj_actor = new Actor();
        if (actorDAO::checkActor($actor) == 0){
            actorDAO::addActor($actor);
        }
        $obj_actor->hydrate(actorDAO::getActorByName($actor));
        $obj_actors[] = $obj_actor;
    }

    if (directorDAO::checkDirector($movie->getDirector()) == 0){
        directorDAO::addDirector($movie->getDirector());
    }

    if($exists == 0){
        $obj_director->hydrate(directorDAO::getDirectorByName($movie->getDirector()));
        $movie->setDirector($obj_director->getId());
        $movie->setActors($obj_actors);
        $res = movieDAO::insertMovie($movie, $obj_actors);
        if($res == 1){
            $html_exists = "<div class='w-25 mx-auto mt-4 alert alert-success' role='alert'>This movie as been saved</div>";
        } else{
            $html_exists = "<div class='w-25 mx-auto mt-4 alert alert-danger' role='alert'>An error occurred</div>";
        }
    }

}

include_once 'views/search.php';