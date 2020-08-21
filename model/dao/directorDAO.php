<?php
require_once 'DBConnex.php';
class directorDAO
{
    /**
     * @return array
     */
    public static function getAllDirectors(){
        $result = array();
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from director order by name;");
        $list = $stmt->execute();
        if(!empty($list)){
            foreach ($list as $director_data){
                $director = new Director();
                $director->hydrate($director_data);
                $result[] = $director;
            }
        }
        return $result;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public static function checkDirector($name){
        $instance = DBConnex::getInstance();
        $res = null;
        $stmt = $instance->prepare("select count(*) from director where name = :name ;");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        return $res;
    }

    /**
     * @param $name
     */
    public static function addDirector($name){
        $instance = DBConnex::getInstance();
        $res = null;
        $stmt = $instance->prepare("insert into director (name) values (:name);");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public static function getDirectorByName($name){
        $instance = DBConnex::getInstance();
        $res = null;
        $stmt = $instance->prepare("select id from director where name = :name ;");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $res = $stmt->fetch();
        return $res;
    }

    /**
     * @param $id
     * @return Director
     */
    public static function getDirectorById($id){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from director where id = :id ;");
        $stmt->bindParam(":id", $id);
        $res = $stmt->fetch();
        $director = new Director();
        $director->hydrate($res);
        return $director;
    }

}