<?php
require_once 'DBConnex.php';

class userDAO
{
    /**
     * @param $email
     * @param $password
     * @return null|User
     */
    public static function connection($email, $password)
    {
        $instance = DBConnex::getInstance();
        $user = null;
        $password = sha1($password . $_SERVER['salt']);
        $connect = "select id, email, firstname, lastname, registration from user where email = :email and password = :password ;";
        $stmt = $instance->prepare($connect);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->execute();
        $res = $stmt->fetch();
        if (!empty($res)) {
            $user = new User();
            $user->hydrate($res);
        }
        print_r($user);
        return $user;
    }

    /**
     * @param $email
     * @param $old
     * @param $new
     * @return bool|mixed
     */
    public static function updatePassword($email, $old, $new)
    {
        $res = false;
        if (self::connection($email, $old) != null) {
            $instance = DBConnex::getInstance();
            $password = sha1($new . $_SERVER['salt']);
            $connect = "update user set password = :password where email = :email ;";
            $stmt = $instance->prepare($connect);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $res = $stmt->fetch();
            if (!empty($res)) {
                $res = true;
            }
        }
        return $res;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function exists($email)
    {
        $instance = DBConnex::getInstance();
        $user = false;
        $connect = "select * from user where email = :email ;";
        $stmt = $instance->prepare($connect);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $res = $stmt->fetch();
        if (!empty($res)) {
            $user = true;
        }
        return $user;
    }

    /**
     * @param User $user
     * @param $password
     * @return bool
     */
    public static function registration(User $user, $password)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("insert into user (email, password, firstname, lastname, registration) VALUES (:email, :password, :firstname, :lastname, :registration); ");
        $password = sha1($password . $_SERVER['salt']);
        $email = $user->getEmail();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $registration = $user->getRegistration();
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":firstname", $firstname);
        $stmt->bindParam(":lastname", $lastname);
        $stmt->bindParam(":registration", $registration);
        $res = $stmt->execute();
        return $res;
    }

    /**
     * @param User $user
     * @return User
     */
    public static function setIdUser(User $user)
    {
        $instance = DBConnex::getInstance();
        $stmt = $instance->prepare("select id from user where email = :email;");
        $email = $user->getEmail();
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $res = $stmt->fetchColumn();
        $user->setId($res);
        return $user;
    }


}