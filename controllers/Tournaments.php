<?php

class Tournaments extends Controller
{
    protected $modelName = "Tournament";

    public function __construct()
    {
        $this->loadModel($this->modelName);
    }

    public function getHome()
    {
        $this->render("index", ["styles" => ["tournament"]]);
    }

    public function getAllTournaments()
    {
        $this->render("listTournaments" , ["styles" => ["tournament"]]);
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

        $tournament = $this->pdo['Tournament']->create($obj);
        echo json_encode($tournament);
    }
}
