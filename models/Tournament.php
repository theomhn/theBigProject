<?php

class Tournament extends Model
{
    public function __construct()
    {
        // Appelle le constructeur de la classe parente pour initialiser la connexion à la base de données et définir la table
        parent::__construct("tournaments");
    }

    public function getParticipants($id)
    {
        // Récupère tous les participants d'un tournoi spécifié par son identifiant
        $participants = $this->_connexion->query("SELECT u.id, u.pseudo, ut.tournament_id FROM users u JOIN users_tournaments ut ON u.id = ut.user_id WHERE ut.tournament_id = $id")->fetchAll(PDO::FETCH_ASSOC);

        // Vérifie si des participants ont été trouvés
        if ($participants === false) {
            return [];
        }

        return $participants;
    }

    public function getByPlayers($idUser)
    {
        // // Récupère les tournois auxquels participe un joueur
        $tournaments = $this->_connexion->query("SELECT tournament_id FROM users_tournaments WHERE user_id = $idUser")->fetchAll(PDO::FETCH_ASSOC);

        // Vérifie si des tournois ont été trouvés
        if ($tournaments === false) {
            return [];
        }

        return $tournaments;
    }

    public function getGamesPerStep($idTournament, $step)
    {
        // Récupère tous les jeux (matchs) d'un tournoi spécifié par son identifiant et une étape spécifiée
        $games = $this->_connexion->query("SELECT * FROM matchs WHERE tournament_id = $idTournament AND step = $step ORDER BY id;")->fetchAll(PDO::FETCH_ASSOC);

        // Vérifie si des jeux ont été trouvés
        if ($games === false) {
            return [];
        }

        return $games;
    }

    public function leave($idTournament)
    {
        $games = $this->_connexion->query("DELETE FROM users_tournaments WHERE tournament_id = $idTournament;");

        return $games;
    }
}
