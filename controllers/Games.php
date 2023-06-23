<?php


class Games extends Controller
{
    /**
     * Constructeur de la classe Games
     */
    public function __construct()
    {
        // Charge le modèle Game
        $this->model = $this->loadModel("Game");
    }

    /**
     * Défini le score d'un match
     *
     * @param int $gameId
     */
    public function setScore($gameId)
    {
        // Récupère le match à partir de l'ID fourni
        $match = $this->model->get($gameId);

        // Récupère le corps de la requête JSON
        $reqBody = json_decode(file_get_contents("php://input"));

        // Vérifie si le match existe
        if (!$match) {
            http_response_code(403);
            echo json_encode("Le match n'existe pas.");
            return false;
        }

        // Charge le modèle du tournoi
        $tournamentModel = $this->loadModel('Tournament');

        // Récupère les informations du tournoi lié au match
        $tournament = $tournamentModel->get($match['tournament_id']);

        // Récupère la date et l'heure actuelle
        $date = date("Y-m-d H:i:s");

        // Vérifie si le tournoi a déjà commencé
        if ($date < $tournament['date_start']) {
            http_response_code(403);
            echo json_encode("Le tournoi n'a pas commencé, vous ne pouvez pas encore saisir les scores. Date de début : " . $tournament['date_start'], JSON_UNESCAPED_UNICODE);
            return false;
        }

        // Vérifie si le tournoi est déjà terminé
        if ($date > $tournament['date_end']) {
            http_response_code(403);
            echo json_encode("Le tournoi est terminé, vous ne pouvez plus saisir les scores.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        // Vérifie s'il y a une égalité entre les scores
        if ($reqBody->score1 == $reqBody->score2) {
            echo json_encode("Il y a égalité. Refaites un match afin d'avoir un vainqueur.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        // Vérifie si le match a déjà été validé
        if ($this->model->isDone($match)) {
            http_response_code(403);
            echo json_encode("Le match a déjà été validé.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        $obj = [];
        if (USER['id'] == $match['player1']) {
            // Si l'utilisateur courant est le joueur 1 du match, enregistre les scores pour le joueur 1 et le joueur 2
            $obj = [
                'score1_player1' => $reqBody->score1,
                'score1_player2' => $reqBody->score2
            ];
        } else if (USER['id'] == $match['player2']) {
            // Si l'utilisateur courant est le joueur 2 du match, enregistre les scores pour le joueur 1 et le joueur 2
            $obj = [
                'score2_player1' => $reqBody->score1,
                'score2_player2' => $reqBody->score2
            ];
        } else {
            // Si l'utilisateur courant ne fait pas partie du match, retourne une erreur
            http_response_code(403);
            echo json_encode("Vous n'avez pas le droit de modifier un match dont vous ne faites pas partie.");
            return false;
        }

        // Met à jour le match avec les scores enregistrés
        $match = $this->model->update($match['id'], $obj);

        if (!$this->model->isDone($match)) {
            // Si le match n'est pas encore terminé, vérifie si les scores ont été enregistrés pour les deux joueurs
            if (!isset($match['score1_player1']) || !isset($match['score2_player1'])) {
                $response = "Scores enregistrés, en attente de confirmation de l'adversaire.";
            } else {
                $response = "Scores enregistrés, non conformes à ceux de l'adversaire. Mettez-vous d'accord !";
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            return false;
        }

        // Détermine l'ID du joueur gagnant en comparant les scores
        $winnerId = ($match['score1_player1'] > $match['score1_player2']) ? $match['player1'] : $match['player2'];

        // Détermine l'étape suivante du tournoi
        $nextStep = $match['step'] + 1;

        // Récupère les jeux de la prochaine étape du tournoi
        $games = $this->model->getGamesPerStep($tournament['id'], $nextStep);

        // Récupère le dernier jeu créé
        $lastGame = end($games);

        if (!$lastGame || !empty($lastGame['player2'])) {
            // Si le dernier jeu est vide ou si le joueur 2 est déjà défini, crée un nouveau jeu avec le joueur gagnant
            $obj = [
                'tournament_id' => $tournament['id'],
                'player1' => $winnerId,
                'step' => $nextStep
            ];
            $lastGame = $this->model->create($obj);
        } else {
            // Sinon, fait rejoindre le joueur gagnant au dernier jeu existant
            $obj = ['player2' => $winnerId];
            $this->model->update($lastGame['id'], $obj);
        }

        echo json_encode(true);
    }
}
