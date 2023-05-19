<?php

class Users extends Controller
{

    public function __construct()
    {
        $this->loadModel("User");
    }

    public function getAll()
    {
        // Test si j'ai le droit
        echo json_encode($this->pdo['User']->getAll());
    }
    public function get($id)
    {
        // Test si j'ai le droit
        echo json_encode($this->pdo['User']->get($id));
    }

    public function post()
    {
        // Test si j'ai le droit
        echo json_encode($this->pdo['User']->create($_POST));
    }

    public function put()
    {
        // Test si j'ai le droit
        parse_str(file_get_contents('php://input'), $_PUT);
        echo json_encode($this->pdo['User']->update($_PUT));
    }

    public function delete($id)
    {
        // Test si j'ai le droit
        echo json_encode($this->pdo['User']->delete($id));
    }
}
