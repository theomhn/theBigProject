<?php

class Tournament extends Model
{

    public function __construct()
    {
        parent::__construct("tournaments");
    }

    public function participants($id)
    {

        $participants = $this->_connexion->query("SELECT u.pseudo FROM users u JOIN users_tournaments ut ON u.id = ut.user_id WHERE ut.tournament_id = $id")->fetch(PDO::FETCH_ASSOC);

        return $participants;
    }
}
