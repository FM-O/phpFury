<?php
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 02/12/14
 * Time: 11:24
 */

class Database{
    private $server = 'db557353478.db.1and1.com';
    private $user = 'dbo557353478';
    private $password = 'mycroblog';
    private $dbname = 'db557353478';
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

        require_once 'User.php';

        $bdd = $this->db->prepare("SELECT id, login, password, email FROM users WHERE login = :login AND password = :password");
        $bdd->execute(array(
            'login' => $login,
            'password' => $pass
        ));
        $ret = $bdd->fetchObject();

        if($ret === false){
            throw new Exception();
        }
        else{
            $user = new User();
            $user->setId($ret->id);
            $user->setLogin($ret->login);
            $user->setPassword($ret->password);
            $user->setEmail($ret->email);
            return ($user !== false) ? $user : null;
        }
    }

    public function saveMessage($message, $login){

        $bdd = $this->db->prepare("SELECT login, id FROM users WHERE login = :login");
        $bdd->execute(array(
            'login' => $login
        ));

        $ret = $bdd->fetchObject();

        $now = new DateTime();
        $now = $now->format('Y-m-d H:i:s');


        $bdd = $this->db->prepare("INSERT INTO messages(content, date, users_id) VALUES(:message, :date, :user_id)");
        $bdd->execute(array(
            'message' => $message,
            'date' => $now,
            'user_id' => $ret->id
        ));
    }

    public function getMessages($user){

        require_once 'Message.php';

        $bdd = $this->db->prepare("SELECT messages.id, content, date, login, users_id FROM messages
         INNER JOIN users
         ON users.id = messages.users_id
         WHERE login = :user");
        $bdd->execute(array(
            'user' => $user
        ));


        $array = new ArrayObject();

        while($ret = $bdd->fetchObject()){
            $message = new Message();
            $message->setId($ret->id);
            $message->setContent($ret->content);
            $message->setDate($ret->date);
            $message->setUsersId($ret->users_id);
            $message->setUserLogin($ret->login);

            $array->append($message);
        }


        return $array;
    }
}