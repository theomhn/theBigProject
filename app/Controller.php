<?php

abstract class Controller
{

    protected $pdo = [];

    public function loadModel(string $model)
    {
        // On va chercher le fichier correspondant au modèle souhaité
        require_once ROOT . 'models/' . $model . '.php';

        // On crée une instance de ce modèle. Ainsi "User" sera accessible par $this->User
        $this->pdo[$model] = new $model();
    }

    /**
     * Afficher une vue
     *
     * @param string $fichier
     * @param array $data
     * @return void
     */
    public function render(string $fichier, array $data = [])
    {
        // Récupère les données et les extrait sous forme de variables (chaque élément du tableau, devient une variable hors du tableau)
        extract($data);

        // On démarre le buffer de sortie
        // Cela permet de tocker dans le cache tous ce qui est craché par PHP
        // C'est ça que je cherchais mercredi, ça permet de mixer les vue tout ça, sans se faire chier à se souvenir de l'ordre de nos 'include'
        ob_start();

        // Crée le chemin et inclut le fichier de vue
        require_once(ROOT . 'views/' . strtolower(get_class($this)) . '/' . $fichier . '.php');

        // On stocke le contenu dans $content
        $content = ob_get_clean();

        // On fabrique le "template"
        require_once(ROOT . 'views/layouts/default.php');
    }
}
