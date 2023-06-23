<?php


class Games extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel("Game");
    }

    public function setScore($gameId)
    {
        $match = $this->model->get($gameId);
        $reqBody = json_decode(file_get_contents("php://input"));

        if (!$match) {
            http_response_code(403);
            echo json_encode("Le match n'existe pas.");
            return false;
        }

        $tournamentModel = $this->loadModel('Tournament');
        $tournament = $tournamentModel->get($match['tournament_id']);

        $date = date("Y-m-d H:i:s");
        if ($date < $tournament['date_start']) {
            http_response_code(403);
            echo json_encode("Le tournoi n'a pas commencé, vous ne pouvez pas encore saisir les scores, date de debut : " . $tournament['date_start'], JSON_UNESCAPED_UNICODE);
            return false;
        }

        if ($date > $tournament['date_end']) {
            http_response_code(403);
            echo json_encode("Le tournoi est terminé, vous ne pouvez plus saisir les scores.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        //vérifier s'il y a une égalité
        if ($reqBody->score1 == $reqBody->score2) {
            echo json_encode("Il y a égalité refaite un match afin d'avoir un vainqueur.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        if ($this->model->isDone($match)) {
            http_response_code(403);
            echo json_encode("Le match à déjà  été validé.", JSON_UNESCAPED_UNICODE);
            return false;
        }

        $obj = [];
        if (USER['id'] == $match['player1']) {
            $obj = [
                'score1_player1' => $reqBody->score1,
                'score1_player2' => $reqBody->score2
            ];
        } else if (USER['id'] == $match['player2']) {
            $obj = [
                'score2_player1' => $reqBody->score1,
                'score2_player2' => $reqBody->score2
            ];
        } else {
            http_response_code(403);
            echo json_encode("Vous n'avez pas le droit de modifier un match dont vous ne faites pas parti.");
            return false;
        }

        $match = $this->model->update($match['id'], $obj);

        if (!$this->model->isDone($match)) {
            if (!isset($match['score1_player1']) || !isset($match['score2_player1'])) {
                $response = "Scores enregistrés, en attente de confirmation de l'adversaire.";
            } else {
                $response = "Scores enregistrés, non conforme à ceux de l'adversaire. Mettez vous d'accord !";
            }
            echo json_encode($response, JSON_UNESCAPED_UNICODE);
            return false;
        }

        $winnerId = ($match['score1_player_1'] > $match['score1_player_2']) ? $match['player1'] : $match['player2'];
        $nextStep = $match['step'] + 1;

        $games = $this->model->getGamesPerStep($tournament['id'], $nextStep); // récupère les games d'un tournoi
        $lastGame = end($games); // récupère le dernier game créé

        if (!$lastGame || !empty($lastGame['player2'])) {
            $obj = [
                'tournament_id' => $tournament['id'],
                'player1' => $winnerId,
                'step' => $nextStep
            ];
            $lastGame = $this->model->create($obj);
        } else {
            // faire rejoindre un joueur
            $obj = ['player2' => $winnerId];
            $this->model->update($lastGame['id'], $obj);
        }

        echo json_encode(true);
    }
}
