<?php

require_once dirname(__FILE__) . '/../../functions/hydrate.php';

class Selection extends hydrate
{
    private $id;
    private $user_id;
    private $movie_id;
    private $saved_date;

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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getMovieId()
    {
        return $this->movie_id;
    }

    /**
     * @param mixed $movie_id
     */
    public function setMovieId($movie_id)
    {
        $this->movie_id = $movie_id;
    }

    /**
     * @return mixed
     */
    public function getSavedDate()
    {
        return $this->saved_date;
    }

    /**
     * @param mixed $saved_date
     */
    public function setSavedDate($saved_date)
    {
        $this->saved_date = $saved_date;
    }


}