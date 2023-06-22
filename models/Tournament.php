<?php

class Tournament extends Model
{

    public function __construct()
    {
        parent::__construct("tournaments");
    }

    public function getParticipants($id)
    {
        $participants = $this->_connexion->query("SELECT u.id, u.pseudo FROM users u JOIN users_tournaments ut ON u.id = ut.user_id WHERE ut.tournament_id = $id")->fetchAll(PDO::FETCH_ASSOC);

        if ($participants === false) {
            return [];
        }
        return $participants;
    }

    public function getGamesPerStep($idTournament, $step)
    {
        $games = $this->_connexion->query("SELECT * FROM matchs WHERE tournament_id = $idTournament AND step = $step ORDER BY id;")->fetchAll(PDO::FETCH_ASSOC);

        if ($games === false) {
            return [];
        }
        return $games;
    }
}
