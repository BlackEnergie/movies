<?php
require_once dirname(__FILE__) . '/../../functions/hydrate.php';

class Movie extends hydrate
{
    private $id;
    private $title;
    private $year;
    private $released;
    private $runtime;
    private $genre;
    private $plot;
    private $country;
    private $awards;
    private $poster;
    private $imdbID;
    private $type;
    private $imdbRating;
    private $imdbVotes;
    private $boxOffice;

    private $director;
    private $actors = [];

    /**
     * movie constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * @param mixed $director
     */
    public function setDirector($director)
    {
        $this->director = $director;
    }

    public function getActors(){
        return $this->actors;
    }

    /**
     * @return mixed
     */
    public function getActorsText()
    {
        if(is_array($this->actors))
        {
            $string = "";
            $nbActors = count($this->actors);
            for($i = 0 ; $i < $nbActors - 1 ; $i++){
                $string .= $this->actors[$i]->getName() . ", ";
            }
            $string .= $this->actors[$nbActors-1]->getName();
            return $string;
        }
        return $this->actors;
    }

    /**
     * @param mixed $actors
     */
    public function setActors($actors)
    {
        $this->actors = $actors;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * @param mixed $released
     */
    public function setReleased($released)
    {
        $this->released = $released;
    }

    /**
     * @return mixed
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * @param mixed $runtime
     */
    public function setRuntime($runtime)
    {
        $this->runtime = intval($runtime);
    }

    public function getGenreArray(){
        $genres = explode(", ", $this->genre);
        return $genres;
    }

    /**
     * @return mixed
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * @param mixed $genre
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return mixed
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * @param mixed $plot
     */
    public function setPlot($plot)
    {
        $this->plot = $plot;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getAwards()
    {
        return $this->awards;
    }

    /**
     * @param mixed $awards
     */
    public function setAwards($awards)
    {
        $this->awards = $awards;
    }

    /**
     * @return mixed
     */
    public function getPoster()
    {
        return $this->poster;
    }

    /**
     * @param mixed $poster
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;
    }

    /**
     * @return mixed
     */
    public function getImdbID()
    {
        return $this->imdbID;
    }

    /**
     * @param mixed $imdbID
     */
    public function setImdbID($imdbID)
    {
        $this->imdbID = $imdbID;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getImdbRating()
    {
        return $this->imdbRating;
    }

    /**
     * @param mixed $imdbRating
     */
    public function setImdbRating($imdbRating)
    {
        $this->imdbRating = $imdbRating;
    }

    /**
     * @return mixed
     */
    public function getImdbVotes()
    {
        return $this->imdbVotes;
    }

    /**
     * @param mixed $imdbVotes
     */
    public function setImdbVotes($imdbVotes)
    {
        $this->imdbVotes = $imdbVotes;
    }

    /**
     * @return mixed
     */
    public function getBoxOffice()
    {
        return $this->boxOffice;
    }

    /**
     * @param mixed $boxOffice
     */
    public function setBoxOffice($boxOffice)
    {
        $this->boxOffice = $boxOffice;
    }




}
