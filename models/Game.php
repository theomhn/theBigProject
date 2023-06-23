<?php

class Game extends Model
{
    public function __construct()
    {
        // Appelle le constructeur de la classe parente pour initialiser la connexion à la base de données et définir la table
        parent::__construct("matchs");
    }

    public function getByTournamentId($tournamentId)
    {
        // Récupère tous les jeux (matchs) associés à un identifiant de tournoi donné
        $games = $this->_connexion->query("SELECT * FROM $this->table WHERE tournament_id = $tournamentId;")->fetch(PDO::FETCH_ASSOC);

        // Vérifie si des jeux ont été trouvés
        if ($games === false) {
            return [];
        }

        return $games;
    }

    // Vérifie si le match est déjà validé
    function isDone($match)
    {
        return isset($match['score1_player1']) && isset($match['score2_player1']) && isset($match['score1_player2']) && isset($match['score2_player2'])
            && $match['score1_player1'] == $match['score2_player1'] && $match['score1_player2'] == $match['score2_player2']
            && $match['score1_player1'] != $match['score1_player2'];
    }
}
