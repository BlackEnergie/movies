<?php
require_once 'configs/salt.php';

require_once 'functions/formulaire.php';
require_once 'functions/dispatcher.php';

require_once 'model/dto/movie.php';
require_once 'model/dto/actor.php';
require_once 'model/dto/director.php';
require_once 'model/dto/user.php';
require_once 'model/dto/genre.php';
require_once 'model/dto/selection.php';

require_once 'model/dao/actorDAO.php';
require_once 'model/dao/directorDAO.php';
require_once 'model/dao/movieDAO.php';
require_once 'model/dao/userDAO.php';
require_once 'model/dao/genreDAO.php';
require_once 'model/dao/selectionDAO.php';

if(isset($_GET['MP'])){
    $_SESSION['MP'] = $_GET['MP'];
} else $_SESSION['MP'] = 'home';

require_once dispatcher::dispatch($_SESSION['MP']);