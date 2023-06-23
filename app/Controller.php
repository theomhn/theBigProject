<?php

abstract class Controller
{

    protected $model;

    /**
     * Charge un modèle
     *
     * @param string $model
     * @return object
     */
    public function loadModel(string $model)
    {
        // récupère le fichier correspondant au modèle souhaité
        require_once ROOT . 'models/' . $model . '.php';

        return new $model();
    }

    /**
     * Affiche une vue
     *
     * @param string $fichier
     * @param array $data
     * @return void
     */
    public function render(string $fichier, array $data = [])
    {
        // Récupère les données et les extrait sous forme de variables (chaque élément du tableau devient une variable hors du tableau)
        extract($data);

        ob_start();

        // Crée le chemin et inclut le fichier de vue
        require_once(ROOT . 'views/' . $fichier . '.php');

        // On stocke le contenu dans $content
        $content = ob_get_clean();

        // On fabrique le "template"
        require_once(ROOT . 'views/layouts/default.php');
    }

    /**
     * Récupère tous les éléments
     *
     * @return void
     */
    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }

    /**
     * Récupère un élément par son identifiant
     *
     * @param mixed $id
     * @return void
     */
    public function get($id)
    {
        echo json_encode($this->model->get($id));
    }

    /**
     * Met à jour un élément
     *
     * @return void
     */
    public function put()
    {
        parse_str(file_get_contents('php://input'), $_PUT);
        echo json_encode($this->model->update($_PUT));
    }

    /**
     * Supprime un élément par son identifiant
     *
     * @param mixed $id
     * @return void
     */
    public function delete($id)
    {
        $this->model->delete($id);
    }
}
