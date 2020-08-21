<?php
require_once 'DBConnex.php';
class actorDAO
{
    /**
     * @return array
     */
    public static function getAllActors(){
        $result = array();
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from actor order by name;");
        $list = $stmt->execute();
        if(!empty($list)){
            foreach ($list as $actor_data){
                $actor = new Actor();
                $actor->hydrate($actor_data);
                $result[] = $actor;
            }
        }
        return $result;
    }

    /**
     * @param $name
     * @return int|mixed
     */
    public static function checkActor($name){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select count(*) from actor where name = :name ;");
        $stmt->bindParam(":name", $name);
        $res = $stmt->fetchColumn();
        return $res;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function addActor($name){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("insert into actor (name) values (:actor_name);");
        $stmt->bindParam(":actor_name", $name);
        return $stmt->execute();
    }


    /**
     * @param $name
     * @return Actor
     */
    public static function getActorByName($name){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select * from actor where name = :actor_name ;");
        $stmt->bindParam("actor_name", $name);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $actor = new Actor();
        $actor->hydrate($res[0]);
        return $actor;
    }

    /**
     * @param $movieId
     * @return array
     */
    public static function getActorsFromMovie($movieId){
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select actor.* from actor , movie_actor where actor.id = movie_actor.actor_id and movie_id = :movie_id ; ");
        $stmt->bindParam(":movie_id", $movieId);
        $stmt->execute();
        $stmt->fetchAll();
        $actors = [];
        if(!empty($res)){
            foreach ($res as $actor_data) {
                $actor = new Actor();
                $actor->hydrate($actor_data);
                $actors[] = $actor;
            }
        }
        return $actors;
    }

}