<?php
require_once dirname(__FILE__) .'/../../configs/param.php';

class DBConnex extends PDO{

    private static $instance;

    /**
     * @return DBConnex
     */
    public static function getInstance(){
        if ( !self::$instance ){
            self::$instance = new DBConnex();
        }
        return self::$instance;
    }

    function __construct(){
        try {
            parent::__construct(Param::$dsn ,Param::$user, Param::$pass);
        } catch (Exception $e) {
            echo $e->getMessage();
            die("Impossible de se connecter." );
        }
    }

    public function __destruct(){
        if(!is_null(self::$instance)){
            self::$instance = null;
        }
    }

    /**
     * @param $sql
     * @return array|bool
     */
    public function queryFetchAll($sql){
        $sth  =$this->query($sql);

        if ( $sth ){
            return $sth -> fetchAll(PDO::FETCH_ASSOC);
        }

        return false;
    }

    /**
     * @param $sql
     * @return array|mixed
     */
    public function queryFetchFirstRow($sql){
        $sth    = $this->query($sql);
        $result    = array();

        if ( $sth ){
            $result  = $sth -> fetch();
        }

        return $result;
    }


    /**
     * @param $sql
     * @return bool|int
     */
    public function insert($sql){
        if ( $this -> exec($sql) > 0 ){
            return 1;
            //$this->lastInsertId();
        }
        return false;
    }

    /**
     * @param $sql
     * @return int
     */
    public function update($sql){
        return $this->exec($sql) ;
    }

    /**
     * @param $sql
     * @return int
     */
    public function delete($sql){
        return $this->exec($sql) ;
    }
}
