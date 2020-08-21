<?php
require_once "DBConnex.php";
class genreDAO {


    /**
     * @param $name
     * @return mixed
     */
    public static function getGenreId($name){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select id from genre where name = :name");
        $stmt->bindParam(":name", $name);
        $stmt->execute();
        $res = $stmt->fetch();
        $res = $res[0];
        if($res == null){
            $instance = DBConnex::getInstance();
            $stmt = $instance->prepare("insert into genre(genre.name) values(:name);");
            $stmt->bindParam(":name", $name);
            $res = $stmt->execute();
            if($res != null)
                return self::getGenreId($name);
            else return false;
        }
        return $res;
    }

}