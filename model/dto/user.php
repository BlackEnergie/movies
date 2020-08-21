<?php
require_once dirname(__FILE__) . '/../../functions/hydrate.php';

class User extends hydrate
{
    private $id;
    private $email;
    private $firstname;
    private $lastname;
    private $registration;

    private $selection = [];
    private $playlists = [];

    public function __construct()
    {
    }
    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    public function getFullName()
    {
        return $this->firstname . " " . $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * @param mixed $registration
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;
    }

    /**
     * @return array
     */
    public function getSelection()
    {
        return $this->selection;
    }

    /**
     * @param array $selection
     */
    public function setSelection($selection)
    {
        $this->selection = $selection;
    }

    /**
     * @return array
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * @param array $playlists
     */
    public function setPlaylists($playlists)
    {
        $this->playlists = $playlists;
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




}
