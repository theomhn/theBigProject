<?php

class Bases extends Controller
{

    public function getHome()
    {
        $this->render("index", ["styles" => ["index"]]);
    }

    public function getConnexion()
    {
        $this->render("connexion", ["styles" => ["connexion"]]);
    }

    public function get404()
    {
        $this->render("404");
    }

    public function getTournamentHome()
    {
        $this->render("createTournament", ["styles" => ["tournament"]]);
    }

    public function getAllTournaments()
    {
        $this->render("listTournaments", ["styles" => ["tournament"]]);
    }

    public function getTournamentView($id)
    {
        $this->render("showTournament", ["styles" => ["tournament"], "id" => $id]);
    }
}
