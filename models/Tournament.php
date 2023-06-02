<?php

class Tournament extends Model
{

    public function __construct()
    {
        parent::__construct("tournaments");
    }

    public function join($userId, $tournamentId)
    {
        //faire un requête qui récupère le l'utilisateur et une le tournoi !

        //faire insertion en bdd dans la table event
        $this->_connexion->query("INSERT INTO users_tournaments (user_id,tournament_id) VALUES ($userId, $tournamentId);");
    }
}
