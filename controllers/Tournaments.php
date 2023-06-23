<?php

class Tournaments extends Controller
{
    /**
     * Constructeur de la classe Tournaments
     */
    public function __construct()
    {
        // Charge le modèle du tournoi
        $this->model = $this->loadModel("Tournament");
    }

    /**
     * Rejoins un tournoi
     *
     * @param int $idTournament
     */
    public function join($idTournament)
    {
        // Récupère les informations du tournoi à partir de l'ID fourni
        $tournament = $this->model->get($idTournament);

        // Vérifie si le tournoi existe
        if (!isset($tournament)) {
            http_response_code(404);
            echo json_encode("Le tournoi n'existe pas");
            return false;
        }

        // Récupère la date et l'heure actuelle
        $date = date("Y-m-d H:i:s");

        // Vérifie si le tournoi a déjà commencé
        if ($date < $tournament['date_start']) {
            http_response_code(403);
            echo json_encode("Le tournoi n'a pas encore commencé. Il commencera le " . $tournament['date_start']);
            return false;
        }

        // Vérifie si le tournoi est terminé
        if ($date > $tournament['date_end']) {
            http_response_code(403);
            echo json_encode("Le tournoi est terminé");
            return false;
        }

        // Récupère tous les participants du tournoi
        $allParticipants = $this->model->getParticipants($idTournament);

        // Vérifie si le tournoi est complet (nombre maximum de participants atteint)
        if (count($allParticipants) >= $tournament['nbParticipants']) {
            http_response_code(403);
            echo json_encode("Le tournoi est complet");
            return  false;
        }

        // Crée une association entre l'utilisateur courant et le tournoi
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

        // Récupère les jeux de la première étape du tournoi
        $games = $this->model->getGamesPerStep($idTournament, 0);

        // Récupère le dernier jeu créé
        $lastGame = end($games);

        // Charge le modèle du jeu
        $gameModel = $this->loadModel('Game');

        if (!$lastGame || !empty($lastGame['user2_id'])) {
            // Si le dernier jeu est vide ou si le joueur 2 est déjà défini, crée un nouveau jeu avec l'utilisateur courant comme joueur 1
            $obj = [
                'tournament_id' => $idTournament,
                'user1_id' => USER['id'],
                'step' => 0
            ];
            $lastGame = $gameModel->create($obj);
        } else {
            // Sinon, fait rejoindre l'utilisateur courant au dernier jeu existant en tant que joueur 2
            $obj = ['user2_id' => USER['id']];
            $gameModel->update($lastGame['id'], $obj);
        }

        echo json_encode(true);
    }

    public function getParticipants($id)
    {
        // Récupère les participants du tournoi à partir de l'ID fourni
        echo json_encode($this->model->getParticipants($id));
    }

    public function post()
    {
        // Récupère les données du tournoi à partir de la requête POST
        $obj = [
            'title' => $_POST['title'],
            'game' => $_POST['game'],
            'nbParticipants' => $_POST['nbParticipants'],
            'date_start' => $_POST['dateStart'],
            'date_end' => $_POST['dateEnd']
        ];

        // Crée un nouveau tournoi avec les données fournies
        $tournament = $this->model->create($obj);
        echo json_encode($tournament);
    }
}
