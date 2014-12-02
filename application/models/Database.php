<?php
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 02/12/14
 * Time: 11:24
 */

class Database{
    private $server = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'mycroblog';
    private $db;

    public function __construct(){
        try{
            $this->db = new PDO('mysql:host='.$this->server.';dbname='.$this->dbname.'', ''.$this->user.'', ''.$this->password.'');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e){
            die('Erreur:'.$e->getMessage());
        }

    }

    public function saveUser($login, $pass, $email){
        $bdd = $this->db->prepare("INSERT INTO users(email, login, password) VALUES(:email, :log, :pass)");
        $bdd->execute(array(
            'email' => $email,
            'log' => $login,
            'pass' => $pass
        ));
    }

    public function getUserFrom($login, $pass){
        $bdd = $this->db->prepare("SELECT login, password FROM users WHERE login = :login AND password = :password");
        $bdd->execute(array(
            'login' => $login,
            'password' => $pass
        ));
        $ret = $bdd->fetch();
        if($ret === false){
            throw new Exception();
        }
        return ($ret !== false) ? $ret : null;
    }
}