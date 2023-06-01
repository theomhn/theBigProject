<?php

class User extends Model
{

    public function __construct()
    {
        parent::__construct("users");
    }

    public function create($user)
    {
        $user['salt'] = bin2hex(random_bytes(16));
        $user['token'] = bin2hex(random_bytes(32));
        $user['password'] = password_hash($user['password'] . $user['salt'], PASSWORD_DEFAULT);

        return parent::create($user);
    }

    public function getByCredentials(string $mail, string $password)
    {
        $user = $this->_connexion->query("SELECT * FROM $this->table WHERE email = '$mail';")->fetch(PDO::FETCH_ASSOC);

        if (!empty($user) && password_verify($password . $user['salt'], $user['password'])) {
            return $user;
        } else {
            return null;
        }
    }

    public function getByToken(string $token)
    {
        $user = $this->_connexion->query("SELECT * FROM $this->table WHERE token = '$token';")->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function activate($token)
    {
        $res = $this->_connexion->query("UPDATE $this->table SET active = 1 WHERE token = '$token';");
        if ($res->rowCount() == 1) {
            return true;
        }
        return false;
    }
}
