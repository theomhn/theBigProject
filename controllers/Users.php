<?php

class Users extends Controller
{
    protected $modelName = "User";

    public function __construct()
    {
        $this->loadModel($this->modelName);
    }

    public function login()
    {
        $mail = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->pdo['User']->getByCredentials($mail, $password);

        if ($user) {
            $seconds = isset($_POST['rememberMe']) ? time() + 60 * 60 * 24 * 365 : 0;

            setcookie('authentication', $user['token'], $seconds, APP);

            echo json_encode($user['token']);
        } else {

            http_response_code(401);

            echo json_encode('Mail ou mot de password incorrect');
        }
    }

    public function authentificate()
    {
        if (isset($_COOKIE['authentication'])) {
            $user = $this->pdo['User']->getByToken($_COOKIE['authentication']);
            if ($user && $user['active']) {
                return $user;
            }
        }
        return false;
    }

    private function sendValidationMail($user)
    {
        // génère un lien de validation du compte utilisateur
        $lien = "http://localhost/TheBigProject/activate?token=" . $user['token'];

        echo $lien;
    }

    public function activate()
    {
        $res = $this->pdo['User']->activate($_GET['token']);

        if ($res) {
            echo "compte activé";
        } else {
            echo "nom nom valide";
        }
    }

    public function post() // create a new user
    {

        $obj = [
            'pseudo' => $_POST['pseudo'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        /* var_dump($obj); */
        $user = $this->pdo['User']->create($obj);
        $this->sendValidationMail($user);
        echo json_encode($user);
    }

    public function put()
    {
        /* a tester/debug  */
        $result = parse_str(file_get_contents('php://input'), $_PUT);
        var_dump($result);
        echo json_encode($this->pdo['User']->update($_PUT));
    }
}
