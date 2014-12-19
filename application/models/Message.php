<?php
//TEST
/**
 * Created by IntelliJ IDEA.
 * User: flo
 * Date: 16/12/14
 * Time: 21:51
 */

class Message {

    private $id;
    private $content;
    private $date;
    private $users_id;
    private $user_login;

    public function getId(){
        return $this->id;
    }

    public function setId($newId){
        $this->id = $newId;
    }

    public function getContent(){
        return $this->content;
    }

    public function setContent($newContent){
        $this->content = $newContent;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($newDate){
        $this->date = $newDate;
    }

    public function getUsersId(){
        return $this->users_id;
    }

    public function setUsersId($newUsersId){
        $this->users_id = $newUsersId;
    }

    public function getUserLogin(){
        return $this->user_login;
    }

    public function setUserLogin($newUserLogin){
        $this->user_login = $newUserLogin;
    }

} 