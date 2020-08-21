<?php

$movies = movieDAO::getAllMovies();
foreach ($movies as $movie){
    $str_genres = $movie->getGenre();
    $arr_genres = explode(", ", $str_genres);
    $movie_id = $movie->getId();
    foreach ($arr_genres as $str_genre){
        $genre_id = genreDAO::getGenreId($str_genre);
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("insert into movie_genre values(:genre_id, :movie_id);");
        $stmt->bindParam(":movie_id", $movie_id);
        $stmt->bindParam(":genre_id", $genre_id);
        $res = $stmt->execute();
    }
}

