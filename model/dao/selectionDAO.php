<?php

require_once dirname(__FILE__) . '/../../model/dao/movieDAO.php';
require_once dirname(__FILE__) . '/../../model/dao/actorDAO.php';
require_once dirname(__FILE__) . '/../../model/dao/directorDAO.php';
require_once dirname(__FILE__) . '/../../model/dao/genreDAO.php';

require_once dirname(__FILE__) . '/../../model/dto/movie.php';
require_once dirname(__FILE__) . '/../../model/dto/actor.php';
require_once dirname(__FILE__) . '/../../model/dto/director.php';
require_once dirname(__FILE__) . '/../../model/dto/genre.php';

require_once "DBConnex.php";

class selectionDAO
{
    /**
     * @param $user_id
     * @param $movie_id
     * @return bool
     */
    public static function checkMovieSelection($user_id, $movie_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from selection where movie_id = :movie_id and user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":movie_id", $movie_id);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    /**
     * @param $user_id
     * @param $movie_id
     * @return bool
     */
    public static function updateMovieSelection($user_id, $movie_id)
    {
        $res = 1;
        $movie = movieDAO::getMovieByImdbID($movie_id);
        $actors = $movie->getActors();
        $director = $movie->getDirector();
        $genres = $movie->getGenreArray();
        if (!self::checkMovieSelection($user_id, $movie_id)) {
            // Add to selection
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into selection (user_id, movie_id, saved_date) VALUES (:user_id, :movie_id, CURRENT_TIMESTAMP)");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":movie_id", $movie_id);
            $res = $stmt->execute();
            echo "{ \"T\" : \"A\" , \"V\" : \"$res\" , ";
        } else {
            //Remove from selection
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("delete from selection where user_id = :user_id and movie_id = :movie_id");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":movie_id", $movie_id);
            $res = ($res and $stmt->execute());
            echo "{\"T\" : \"R\" , \"V\" : \"$res\" , ";
        }
        foreach ($actors as $actor) {
            $actor_id = $actor->getId();
            $res = ($res and self::updateSelectionActor($user_id, $actor_id));
            echo "\"Ac\" : \"$res\" , ";
        }
        foreach ($genres as $genre) {
            $genre_id = genreDAO::getGenreId($genre);
            $res = ($res and self::updateSelectionGenre($user_id, $genre_id));
            echo "\"G\" : \"$res\" , ";
        }
        $director_id = $director->getId();
        self::updateSelectionDirector($user_id, $director_id);
        echo "\"D\" : \"$res\" , ";
        return $res;
    }

    /**
     * @param $user_id
     * @param $actor_id
     * @return bool
     */
    public static function updateSelectionActor($user_id, $actor_id)
    {
        // Calculate the real number of time each actor has been selected by the user
        // this allows to manage adding and removing with only one function
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(actor.`id`) AS nb 
                                    FROM actor, movie, movie_actor, selection 
                                    WHERE actor.`id` = movie_actor.`actor_id` 
                                    AND movie_actor.`movie_id` = movie.`id` 
                                    AND selection.movie_id = movie.`imdb_id`
                                    AND user_id = :user_id AND actor.id = :actor_id;");
        $stmt->bindParam(":actor_id", $actor_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $nb = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb = $nb['nb'];
        // Check if the occurrence is already created in the table
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(*) as occur FROM selection_actor WHERE id_user = :user_id AND id_actor = :actor_id ;");
        $stmt->bindParam(":actor_id", $actor_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $occur = $stmt->fetch(PDO::FETCH_ASSOC);
        $occur = $occur['occur'];
        if ($occur > 0) {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("UPDATE selection_actor SET nb = :nb  where id_actor = :actor_id and id_user = :user_id ;");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":actor_id", $actor_id);
            $stmt->bindParam(":nb", $nb);
            $res = $stmt->execute();
        } else {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into selection_actor values (:user_id, :actor_id, 1)");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":actor_id", $actor_id);
            $res = $stmt->execute();
        }
        return $res;
    }

    /**
     * @param $user_id
     * @param $genre_id
     * @return bool
     */
    public static function updateSelectionGenre($user_id, $genre_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(genre.`id`) AS nb 
                                  FROM genre, movie, movie_genre, selection 
                                  WHERE genre.`id` = movie_genre.`id_genre` 
                                  AND movie_genre.`id_movie` = movie.`id` 
                                  AND selection.movie_id = movie.`imdb_id`
                                  AND user_id = :user_id AND genre.id = :genre_id ;");
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $nb = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb = $nb['nb'];
        // Check if the occurrence is already created in the table
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(*) as occur FROM selection_genre WHERE id_user = :user_id AND id_genre = :genre_id ;");
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $occur = $stmt->fetch(PDO::FETCH_ASSOC);
        $occur = $occur['occur'];
        if ($occur > 0) {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("UPDATE selection_genre SET nb = :nb  where id_genre = :genre_id and id_user = :user_id;");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":genre_id", $genre_id);
            $stmt->bindParam(":nb", $nb);
            $res = $stmt->execute();
        } else {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into selection_genre values (:user_id, :genre_id, 1)");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":genre_id", $genre_id);
            $res = $stmt->execute();
        }
        return $res;
    }

    /**
     * @param $user_id
     * @param $director_id
     * @return bool
     */
    public static function updateSelectionDirector($user_id, $director_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(director.`id`) AS nb 
                                  FROM director, movie, selection 
                                  WHERE director.`id` = movie.`director_id` 
                                  AND movie.`imdb_id` = selection.`movie_id`
                                  AND user_id = :user_id AND director.id = :director_id ;");
        $stmt->bindParam(":director_id", $director_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $nb = $stmt->fetch(PDO::FETCH_ASSOC);
        $nb = $nb['nb'];
        // Check if the occurrence is already created in the table
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT COUNT(*) as occur FROM selection_director WHERE id_user = :user_id AND id_director = :director_id ;");
        $stmt->bindParam(":director_id", $director_id);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $occur = $stmt->fetch(PDO::FETCH_ASSOC);
        $occur = $occur['occur'];
        if ($occur > 0) {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("UPDATE selection_director SET nb = :nb  where id_director = :director_id and id_user = :user_id;");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":director_id", $director_id);
            $stmt->bindParam(":nb", $nb);
            $res = $stmt->execute();
        } else {
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into selection_director values (:user_id, :director_id, 1)");
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":director_id", $director_id);
            $res = $stmt->execute();
        }
        return $res;
    }

    public static function getMoviesSelection(User $user)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select movie.* from movie, selection where movie.imdb_id = selection.movie_id and user_id = :user_id order by saved_date DESC ;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @param User $user
     * @return array(Genres)
     */
    public static function getFavoriteGenres(User $user)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT genre.name, id_genre AS id , nb
                                  FROM genre, selection_genre, selection
                                  WHERE selection_genre.id_user = selection.`user_id`
                                  AND genre.id = selection_genre.id_genre
                                  AND user_id = :user_id
                                  GROUP BY id_genre 
                                  ORDER BY nb DESC LIMIT 10;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $genres = array();
        foreach ($res as $str_genre){
            $genre = new Genre();
            $genre->hydrate($str_genre);
            $genres[] = $genre;
        }
        return $genres;
    }

    /**
     * @param User $user
     * @return array(Directors)
     */
    public static function getFavoriteDirectors(User $user)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT director.`name`, id_director AS id , nb
                                  FROM selection_director, selection, director
                                  WHERE selection_director.id_user = selection.`user_id` 
                                  AND director.`id` = selection_director.id_director
                                  AND user_id = :user_id
                                  GROUP BY id_director
                                  ORDER BY nb DESC
                                  LIMIT 15;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $directors = array();
        foreach ($res as $str_director){
            $director = new Director();
            $director->hydrate($str_director);
            $directors[] = $director;
        }
        return $directors;
    }

    /**
     * @param User $user
     * @return array(Actors)
     */
    public static function getFavoriteActors(User $user)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT actor.`name`, id_actor as id, nb 
                                  FROM actor, selection_actor, selection
                                  WHERE selection_actor.id_user = selection.`user_id` 
                                  AND actor.`id` = selection_actor.id_actor
                                  AND user_id = :user_id
                                  GROUP BY id_actor 
                                  ORDER BY nb DESC LIMIT 15;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $actors = array();
        foreach ($res as $str_actors){
            $actor = new Actor();
            $actor->hydrate($str_actors);
            $actors[] = $actor;
        }
        return $actors;
    }

    /**
     * @param User $user
     * @param $genre_id
     * @return array(Movies)
     */
    public static function getSelectionGenre(User $user, $genre_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                  FROM movie, movie_genre 
                                  WHERE movie.`id` = movie_genre.`id_movie` 
                                  AND movie.`imdb_id` NOT IN 
                                      (SELECT movie_id 
                                      FROM selection 
                                      WHERE user_id = :user_id)
                                  AND movie_genre.`id_genre` = :genre_id 
                                  ORDER BY movie.`imdb_rating` DESC;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @param User $user
     * @return array(Movies)
     */
    public static function getSelectionDirector(User $user, $director_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                    FROM movie
                                    WHERE movie.`imdb_id` NOT IN 
                                      (SELECT movie_id 
                                      FROM selection  
                                      WHERE user_id = :user_id) 
                                    AND director_id = :director_id
                                    ORDER BY movie.`imdb_rating` DESC;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":director_id", $director_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @param User $user
     * @param $actor_id
     * @return array(Movies)
     */
    public static function getSelectionActor(User $user, $actor_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                  FROM movie, movie_actor
                                  WHERE movie.`id` = movie_actor.`movie_id` 
                                  AND movie.`imdb_id` NOT IN 
                                    (SELECT movie_id 
                                    FROM selection  
                                    WHERE user_id = :user_id) 
                                  AND actor_id = :actor_id
                                  ORDER BY movie.`imdb_rating` DESC;");
        $user_id = $user->getId();
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":actor_id", $actor_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @param $genre_id
     * @return array(Movies)
     */
    public static function getMoviesGenre($genre_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                  FROM movie, movie_genre 
                                  WHERE movie.`id` = movie_genre.`id_movie` 
                                  AND movie_genre.`id_genre` = :genre_id 
                                  ORDER BY movie.`imdb_rating` DESC;");
        $stmt->bindParam(":genre_id", $genre_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @return array(Movies)
     */
    public static function getMoviesDirector($director_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                    FROM movie
                                    WHERE director_id = :director_id
                                    ORDER BY movie.`imdb_rating` DESC;");

        $stmt->bindParam(":director_id", $director_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

    /**
     * @param $actor_id
     * @return array
     */
    public static function getMoviesActor( $actor_id)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("SELECT movie.* 
                                  FROM movie, movie_actor
                                  WHERE movie.`id` = movie_actor.`movie_id` 
                                  AND actor_id = :actor_id
                                  ORDER BY movie.`imdb_rating` DESC;");
        $stmt->bindParam(":actor_id", $actor_id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        return movieDAO::createMoviesFromArray($res);
    }

}