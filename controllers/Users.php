<?php

class Users extends Controller
{
    protected $modelName = "User";

    public function __construct()
    {
        $this->loadModel($this->modelName);
    }

    public function post() // create a new user
    {
        $salt = bin2hex(random_bytes(16));
        $token = bin2hex(random_bytes(32));

        $obj = [
            'pseudo' => $_POST['pseudo'],
            'email' => $_POST['email'],
            'password' => password_hash($_POST['password'] . $salt, PASSWORD_DEFAULT),
            'salt' => $salt,
            'token' => $token
        ];
        /* var_dump($obj); */
        $user = $this->pdo['User']->create($obj);
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
