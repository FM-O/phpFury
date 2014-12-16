<?php
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 16/12/14
 * Time: 12:11
 */
Class User{
    private $id;
    private $login;
    private $password;
    private $email;

    public function getId(){
        return $this->id;
    }

    public function setId($newId){
        $this->id = $newId;
    }

    public function getLogin(){
        return $this->login;
    }

    public function setLogin($newLogin){
        $this->login = $newLogin;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPassword($newPassword){
        $this->password = $newPassword;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($newEmail){
        $this->email = $newEmail;
    }
}