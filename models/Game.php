<?php

class Game extends Model
{

    public function __construct()
    {
        parent::__construct("matchs");
    }

    public function getByTournamentId($tournamentId)
    {
        $games = $this->_connexion->query("SELECT * FROM $this->table WHERE tournament_id = $tournamentId;")->fetch(PDO::FETCH_ASSOC);
        if ($games === false) {
            return [];
        }
        return $games;
    }

    //vérifier si le match est déjà validé
    function isDone($match)
    {
        return isset($match['score1_player1']) && isset($match['score2_player1']) && isset($match['score1_player2']) && isset($match['score2_player2'])
            && $match['score1_player1'] == $match['score2_player1'] && $match['score1_player2'] == $match['score2_player2']
            && $match['score1_player1'] != $match['score1_player2'];
    }
}
