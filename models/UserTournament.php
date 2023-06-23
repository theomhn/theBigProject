<?php

class UserTournament extends Model
{

    public function __construct()
    {
        // Appelle le constructeur de la classe parente pour initialiser la connexion à la base de données et définir la table
        parent::__construct("users_tournaments");
    }
}
