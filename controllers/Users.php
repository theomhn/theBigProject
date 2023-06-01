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

    private function sendValidationMail($user)
    {
        //générer lien
        // envoie le mail avec lien
        // palliatif : $user['link'] = lien
    }

    public function put()
    {
        /* a tester/debug  */
        $result = parse_str(file_get_contents('php://input'), $_PUT);
        var_dump($result);
        echo json_encode($this->pdo['User']->update($_PUT));
    }
}
