<?php

class Tournaments extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel("Tournament");
    }

    public function getHome()
    {
        $this->render("index", ["styles" => ["tournament"]]);
    }

    public function getAllTournaments()
    {
        $this->render("listTournaments", ["styles" => ["tournament"]]);
    }

    public function join($id)
    {
        $obj = [
            'user_id' => USER['id'],
            'tournament_id' => $id
        ];

        $associationModel = $this->loadModel('UserTournament');
        if ($associationModel->create($obj)) {
            echo json_encode(true);
            
        } else {
            http_response_code(400);
            echo json_encode(false);
        }
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
