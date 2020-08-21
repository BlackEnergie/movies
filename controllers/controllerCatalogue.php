<?php

$formSearch = new Formulaire('post', 'index.php?MP=Catalogue', 'searchInMovies', 'contentRecherche');
$formSearch->ajouterComposantLigne($formSearch->creerInputTexte('words' ,'words', '', 0, 'Title, Actor, Director, Genre', ''));
$formSearch->ajouterComposantTab();
$formSearch->ajouterComposantLigne($formSearch->creerInputSubmit('searchMovies', 'searchMovies', 'Search', 'danger'));
$formSearch->ajouterComposantLigne($formSearch->creerInputSubmit('cancel', 'cancel', 'Cancel', 'dark'));

$formSearch->ajouterComposantTab();

$formSearch->creerFormulaire();

$nbMovies = movieDAO::getNbMovies();
$nbPages = (int)($nbMovies / 20) +1;
$search = '';

if (isset($_POST["searchMovies"])) {
    $movies = movieDAO::searchMovieFromAnywhere($_POST['words']);
    $nbMovies = sizeof($movies);
    $search = $_POST["words"];
    $page = null;
} else{
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else $page = 1;
    $movies = movieDAO::getAllMoviesPage($page);
}

require_once 'views/movies_list.php';
