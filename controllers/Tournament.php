<?php

class Tournament extends Controller
{

    public function getHome()
    {
        $this->render("index", ["styles" => ["tournament"]]);
    }
}
