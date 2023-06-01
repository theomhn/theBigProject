<?php

require_once ROOT . 'models/User.php';

class Security extends Controller
{

	private function genToken()
	{
		// @TODO
	}

	private function setAuthentificationCookie($token)
	{
		// @TODO
	}
	public function authentificate()
	{
		global $user;

		$userModel = new User();

		if (!empty($_POST['username']) && !empty($_POST['password'])) {
			$user = $userModel->getByCredentials($_POST['username'], $_POST['password']);
			if ($user) {
				// @TODO définir un token pour l'user et rajouter un cookie dans les headers
			}
		} else if (!empty($_COOKIE['Authentification'])) {
			$user = $userModel->getByToken($_COOKIE['Authentification']);
		}
	}
}
