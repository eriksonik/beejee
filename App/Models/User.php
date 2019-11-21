<?php namespace Models;


use App\Model;

class User extends Model
{
    public function info($id = null)
    {
        $stmt = $this->db->prepare('SELECT * FROM `users` WHERE `id` = :id');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function byHash($hash)
    {
        $stmt = $this->db->prepare('SELECT * FROM `users` WHERE `password` = :hash');
        $stmt->bindValue(':hash', $hash, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function checkAuth($username, $passw)
    {
        $stmt = $this->db->prepare('SELECT * FROM `users` WHERE `name` = :name AND `password` = :passw');
        $stmt->bindValue(':name', $username, \PDO::PARAM_STR);
        $stmt->bindValue(':passw', md5($passw), \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch();
    }
}
