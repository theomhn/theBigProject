<?php

class Tournaments extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel("Tournament");
    }

    public function join($idTournament)
    {
        $tournament = $this->model->get($idTournament);

        if (!isset($tournament)) {
            http_response_code(404);
            echo json_encode("Le tournoi n'existe pas");
            return false;
        }

        $date = date("Y-m-d H:i:s");
        if ($date < $tournament['date_start']) {
            http_response_code(403);
            echo json_encode("Le tournoi n'a pas commencé, il commencera le " . $tournament['date_start']);
            return false;
        }
        if ($date > $tournament['date_end']) {
            http_response_code(403);
            echo json_encode("Le tournoi est terminé");
            return false;
        }

        $allParticipants = $this->model->getParticipants($idTournament); // les participants

        if (count($allParticipants) >= $tournament['nbParticipants']) {
            http_response_code(403);
            echo json_encode("Le tournoi est complet");
            return  false;
        }

        $obj = [
            'user_id' => USER['id'],
            'tournament_id' => $idTournament
        ];

        $associationModel = $this->loadModel('UserTournament');
        try {
            $associationModel->create($obj);
        } catch (Exception $e) {
            echo json_encode(true);
            return true;
        }

        $games = $this->model->getGames($idTournament); // récupère les games d'un tournoi
        $lastGame = end($games); // récupère le dernier game créé
        $gameModel = $this->loadModel('Game');

        if (!$lastGame || !empty($lastGame['user1_id']) && !empty($lastGame['user2_id'])) {
            $obj = [
                'tournament_id' => $idTournament,
                'user1_id' => USER['id'],
                'step' => 0
            ];
            $lastGame = $gameModel->create($obj);
        } else {
            // faire rejoindre un joueur
            $obj = ['user2_id' => USER['id']];
            $gameModel->update($lastGame['id'], $obj);
        }

        echo json_encode(true);
    }

    public function getParticipants($id)
    {
        // Test si j'ai le droit
        echo json_encode($this->model->getParticipants($id));
    }

    public function post()
    {
        $obj = [
            'title' => $_POST['title'],
            'game' => $_POST['game'],
            'nbParticipants' => $_POST['nbParticipants'],
            'date_start' => $_POST['dateStart'],
            'date_end' => $_POST['dateEnd']
        ];
        /* var_dump($obj); */

        $tournament = $this->model->create($obj);
        echo json_encode($tournament);
    }
}
