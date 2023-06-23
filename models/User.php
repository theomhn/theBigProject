<?php

class User extends Model
{
    public function __construct()
    {
        // Appelle le constructeur de la classe parente pour initialiser la connexion à la base de données et définir la table
        parent::__construct("users");
    }

    public function create($user)
    {
        // Génère un sel aléatoire et un jeton pour l'utilisateur
        $user['salt'] = bin2hex(random_bytes(16));
        $user['token'] = bin2hex(random_bytes(32));

        // Hash le mot de passe de l'utilisateur en utilisant le sel
        $user['password'] = password_hash($user['password'] . $user['salt'], PASSWORD_DEFAULT);

        // Appelle la méthode create de la classe parente pour insérer l'utilisateur dans la base de données
        return parent::create($user);
    }

    public function getByCredentials(string $mail, string $password)
    {
        // Récupère l'utilisateur en fonction de son adresse e-mail
        $user = $this->_connexion->query("SELECT * FROM $this->table WHERE email = '$mail';")->fetch(PDO::FETCH_ASSOC);

        // Vérifie si l'utilisateur existe et si le mot de passe correspond en le comparant avec le hash stocké dans la base de données
        if (!empty($user) && password_verify($password . $user['salt'], $user['password'])) {
            return $user;
        } else {
            return null;
        }
    }

    public function getByToken(string $token)
    {
        // Récupère l'utilisateur en fonction de son jeton d'authentification
        $user = $this->_connexion->query("SELECT * FROM $this->table WHERE token = '$token';")->fetch(PDO::FETCH_ASSOC);

        return $user;
    }

    public function activate($token)
    {
        // Active le compte de l'utilisateur en mettant à jour la colonne 'active' de la table des utilisateurs
        $res = $this->_connexion->query("UPDATE $this->table SET active = 1 WHERE token = '$token';");

        // Vérifie si la mise à jour a affecté une seule ligne
        if ($res->rowCount() == 1) {
            return true;
        }

        return false;
    }
}
