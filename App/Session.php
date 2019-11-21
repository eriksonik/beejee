<?php namespace App;


use Models\User;

class Session
{
    public $user;

    public function __construct()
    {
        session_start();

        if (!empty($_SESSION['user'])){
            $this->user = (new User())->byHash($_SESSION['user']);
        }
    }

    public function isAuth()
    {
        return isset($this->user['name']);
    }

    public function isAdmin()
    {
        return isset($this->user['name']) && $this->user['name'] == 'admin';
    }
}
