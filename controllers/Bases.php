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
}
