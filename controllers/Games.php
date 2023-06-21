<?php


class Games extends Controller
{

    public function __construct()
    {
        $this->model = $this->loadModel("Game");
    }
}
