<?php
require_once 'DBConnex.php';

class movieDAO
{
    /**
     * @param Movie $movie
     * @return array
     */
    public static function getActorsMovie(Movie $movie)
    {
        $result = array();
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select actor.* from actor , movie_actor where movie_actor.actor_id = actor.id and movie_id = :movieId;");
        $movie_id = $movie->getId();
        $stmt->bindParam(":movieId", $movie_id);
        $stmt->execute();
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($list)) {
            foreach ($list as $actor_data) {
                $actor = new Actor();
                $actor->hydrate($actor_data);
                $result[] = $actor;
            }
        }
        return $result;
    }

    /**
     * @param Movie $movie
     * @return Director
     */
    public static function getDirectorMovie(Movie $movie)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select director.* from director, movie where director.id = movie.director_id and movie.id = :movieId;");
        $movie_id = $movie->getId();
        $stmt->bindParam(":movieId", $movie_id);
        $stmt->execute();
        $result = $stmt->fetch();
        $director = new Director();
        $director->hydrate($result);
        return $director;
    }

    /**
     * @return array
     */
    public static function getAllMovies()
    {
        $result = [];
        $instance = DBConnex::getInstance();
        $list = $instance->queryFetchAll("select * from movie order by title;");
        if (!is_null($list)) {
            $result = movieDAO::createMoviesFromArray($list);
        }
        return $result;
    }

    /**
     * @param $page
     * @return array
     */
    public static function getAllMoviesPage($page)
    {
        $result = [];
        $instance = DBConnex::getInstance();
        $limit = ($page - 1) * 20;
        $stmt = $instance->prepare("select * from movie order by imdb_rating desc limit $limit ,20;");
        $stmt->execute();
        $list = $stmt->fetchAll();
        if (!is_null($list)) {
            $result = movieDAO::createMoviesFromArray($list);
        }
        return $result;
    }

    /**
     * @return int|mixed
     */
    public static function getNbMovies()
    {
        $res = 0;
        $instance = DBConnex::getInstance();
        $query = $instance->query("select count(*) from movie;");
        if ($query != false)
            $res = $query->fetchColumn();
        return $res;
    }

    /**
     * @param Movie $movie
     * @return mixed
     */
    public static function checkMovie(Movie $movie)
    {
        $instance = DBConnex::getInstance();
        $imdbID = $movie->getImdbID();
        $stmt = $instance->prepare("select count(*) from movie where imdb_id = :imdbID ;");
        $stmt->bindParam(":imdbID", $imdbID);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    /**
     * @param $imdbID
     * @return Movie
     */
    public static function getMovieByImdbID($imdbID)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from movie where imdb_id = :imdbID ;");
        $stmt->bindParam(":imdbID", $imdbID);
        $stmt->execute();
        $res = $stmt->fetch();
        $movie = new Movie();
        $movie->hydrate($res);
        $director = self::getDirectorMovie($movie);
        $movie->setDirector($director);
        $actors = self::getActorsMovie($movie);
        $movie->setActors($actors);
        return $movie;
    }

    /**
     * @param $words
     * @return array
     */
    public static function searchMovieFromAnywhere($words)
    {
        $movies = [];
        $instance = DBConnex::getInstance();
        $words = "%" . $words . "%";
        str_replace(" ", "%", $words);
        $stmt = $instance->prepare("SELECT DISTINCT movie.* FROM movie, director, movie_actor, actor WHERE movie.`director_id` = director.id AND movie.id = movie_actor.`movie_id` AND movie_actor.actor_id = actor.id AND (movie.title LIKE :words OR director.`name` LIKE :words OR actor.`name` LIKE :words OR movie.genre LIKE :words) GROUP BY movie.`imdb_id` ORDER BY movie.imdb_rating DESC ;");
        $stmt->bindParam(":words", $words);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!is_null($res)) {
            $movies = movieDAO::createMoviesFromArray($res);
        }
        return $movies;
    }


    /**
     * @param Movie $movie
     * @return bool|null
     */
    public static function insertMovie(Movie $movie)
    {
        $res = null;
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("insert into movie (title, year, released, runtime, genre, plot, country, awards, poster, imdb_id, type, imdb_rating, imdb_votes, box_office, director_id)
                VALUES ( :title , :year_movie , :released , :runtime , :genre , :plot , :country , :awards , :poster , :imdbID , :type_movie , :imdb_rating , :imdb_votes , :box_office, :director_id );");
        $actors = $movie->getActors();
        $title = $movie->getTitle();
        $year = $movie->getYear();
        if ($movie->getReleased() != false) {
            $released = $movie->getReleased()->format("YYYY-MM-DD");
        } else $released = "";
        $runtime = $movie->getRuntime();
        $genre = $movie->getGenre();
        $plot = $movie->getPlot();
        $country = $movie->getCountry();
        $awards = $movie->getAwards();
        $poster = $movie->getPoster();
        $imdbID = $movie->getImdbID();
        $type = $movie->getType();
        $imdbRating = $movie->getImdbRating();
        $imdbVotes = $movie->getImdbVotes();
        $boxOffice = $movie->getBoxOffice();
        $director = $movie->getDirector()->getId();
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":year_movie", $year);
        $stmt->bindParam(":released", $released);
        $stmt->bindParam(":runtime", $runtime);
        $stmt->bindParam(":genre", $genre);
        $stmt->bindParam(":plot", $plot);
        $stmt->bindParam(":country", $country);
        $stmt->bindParam(":awards", $awards);
        $stmt->bindParam(":poster", $poster);
        $stmt->bindParam(":imdbID", $imdbID);
        $stmt->bindParam(":type_movie", $type);
        $stmt->bindParam(":imdb_rating", $imdbRating);
        $stmt->bindParam(":imdb_votes", $imdbVotes);
        $stmt->bindParam(":box_office", $boxOffice);
        $stmt->bindParam(":director_id", $director);

        $stmt->execute();
        //On récupère l'ID généré par la base de données pour avoir un objet complet
        $movie = self::getMovieByImdbID($movie->getImdbID());
        $movie->setActors($actors);
        $res = self::insertAssociationMovieActor($movie);
        $res = ($res and self::insertAssociationMovieGenre($movie));
        return $res;
    }

    /**
     * @param $array
     * @return Movie
     */
    public static function exctractMovie($array)
    {
        $movie = new Movie();
        $obj_director = new Director();
        $obj_actors = array();

        $movie->hydrate($array);

        $released = DateTime::createFromFormat('d M Y', $movie->getReleased());
        $movie->setReleased($released);
        $actors = explode(", ", $movie->getActorsText());
        foreach ($actors as $actor) {
            if (actorDAO::checkActor($actor) == 0) {
                actorDAO::addActor($actor);
            }
            $obj_actors[] = actorDAO::getActorByName($actor);
        }
        $director_name = $movie->getDirector();
        $director_id = directorDAO::getDirectorByName($movie->getDirector());
        if ($director_id == 0) {
            directorDAO::addDirector($movie->getDirector());
        }
        $obj_director->hydrate(directorDAO::getDirectorByName($movie->getDirector()));
        $obj_director->setName($director_name);
        $movie->setDirector($obj_director);
        $movie->setActors($obj_actors);
        if ($movie->getPlot() != "N/A" and $movie->getDirector() != "N/A") {
            if(self::checkMovie($movie)){
                self::updateMovie($movie);
            }else{
                self::insertMovie($movie);
            }
        }
        return $movie;

    }

    /**
     * @param Movie $movie
     */
    public static function updateMovie(Movie $movie){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("UPDATE movie SET poster = :poster, imdb_rating = :imdb_rating, box_office = :box_office, awards = :awards where imdb_id = :imdb_id;");
        $poster = $movie->getPoster();
        $imdb_rating = $movie->getImdbRating();
        $box_office = $movie->getBoxOffice();
        $awards = $movie->getAwards();
        $imdb_id = $movie->getImdbID();
        $stmt->bindParam(":poster", $poster);
        $stmt->bindParam(":imdb_rating",$imdb_rating);
        $stmt->bindParam(":box_office", $box_office);
        $stmt->bindParam(":awards", $awards);
        $stmt->bindParam(":imdb_id", $imdb_id);
        $stmt->execute();
    }

    /**
     * @param Movie $movie
     * @return bool
     */
    public static function insertAssociationMovieActor(Movie $movie)
    {
        $res = false;
        $instance = DBConnex::getInstance();
        $actors = $movie->getActors();
        foreach ($actors as $actor) {
            $movie_id = $movie->getId();
            $actor_id = $actor->getId();
            $stmt = $instance->prepare("insert into movie_actor VALUES (:movie_id , :actor_id);");
            $stmt->bindParam(":movie_id", $movie_id);
            $stmt->bindParam(":actor_id", $actor_id);
            $res = $stmt->execute();
        }
        return $res;
    }

    /**
     * @param Movie $movie
     * @return bool
     */
    public static function insertAssociationMovieGenre(Movie $movie){
        $arr_genres = explode(", ", $movie->getGenre());
        $movie_id = $movie->getId();
        $res = false;
        foreach ($arr_genres as $str_genre){
            $genre_id = genreDAO::getGenreId($str_genre);
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into movie_genre values(:genre_id, :movie_id);");
            $stmt->bindParam(":movie_id", $movie_id);
            $stmt->bindParam(":genre_id", $genre_id);
            $res = $stmt->execute();
        }
        return $res;
    }

    /**
     * @param $array_movies
     * @return array
     */
    public static function createMoviesFromArray($array_movies){
        $movies = array();
        foreach ($array_movies as $str_movie) {
            $movie = new Movie();
            $movie->hydrate($str_movie);
            $director = movieDAO::getDirectorMovie($movie);
            $movie->setDirector($director);
            $actors = movieDAO::getActorsMovie($movie);
            $movie->setActors($actors);
            $movies[] = $movie;
        }
        return $movies;
    }
}