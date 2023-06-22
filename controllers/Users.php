<?php

class Users extends Controller
{
    public function __construct()
    {
        $this->model = $this->loadModel("User");
    }

    public function login()
    {
        $mail = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->model->getByCredentials($mail, $password);

        if ($user) {
            $seconds = isset($_POST['rememberMe']) ? time() + 60 * 60 * 24 * 365 : 0;

            setcookie('authentication', $user['token'], $seconds, APP);

            echo json_encode($user['token']);
        } else {

            http_response_code(401);

            echo json_encode('Adresse mail ou mot de password incorrect');
        }
    }

    public function authentificate()
    {
        if (isset($_COOKIE['authentication'])) {
            $user = $this->model->getByToken($_COOKIE['authentication']);
            if ($user && $user['active']) {
                return $user;
            }
        }
        return false;
    }

    private function sendValidationMail($user)
    {
        // génère un lien de validation du compte utilisateur
        $lien = "http://localhost/theBigProject/activate?token=" . $user['token'];

        return $lien;
    }

    public function activate()
    {
        $res = $this->model->activate($_GET['token']);

        if ($res) {
            echo "compte activé avec succès !";
        } else {
            echo "Aucun compte est en attente de validation avec cette adresse mail !";
        }
    }

    public function post() // create a new user
    {
        $obj = [
            'pseudo' => $_POST['pseudo'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        try {
            $user = $this->model->create($obj);
            // @TODO vraiment envoyer le mail
            $link = $this->sendValidationMail($user);
            echo json_encode($link);
        } catch (Exception $ex) {
            http_response_code(400);
            echo json_encode("Mail déjà inscrit !");
        }
    }

    public function put()
    {
        /* a tester/debug  */
        $result = parse_str(file_get_contents('php://input'), $_PUT);
        var_dump($result);
        echo json_encode($this->model->update($_PUT));
    }
}
