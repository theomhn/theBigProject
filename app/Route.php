<?php

class Route
{

    private $path;
    private $callable;
    private $matches = [];
    private $params = [];

    /**
     * Constructeur de la classe Route
     *
     * @param string $path
     * @param mixed $callable
     */
    public function __construct($path, $callable)
    {
        $this->path = trim($path, '/'); // On retire les / inutiles
        $this->callable = $callable;
    }

    /**
     * Vérifie si l'URL correspond au chemin de la route
     *
     * @param string $url
     * @return bool
     */
    public function match($url)
    {
        $url = trim($url, '/');
        $path = preg_replace_callback('#:([\w]+)#', [$this, 'paramMatch'], $this->path);
        $regex = "#^$path$#i";
        if (!preg_match($regex, $url, $matches)) {
            return false;
        }
        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * Définit une contrainte pour un paramètre de la route
     *
     * @param string $param
     * @param string $regex
     * @return $this
     */
    public function with($param, $regex)
    {
        $this->params[$param] = str_replace('(', '(?:', $regex);
        return $this;
    }

    /**
     * Fonction de correspondance pour les paramètres de la route
     *
     * @param array $match
     * @return string
     */
    private function paramMatch($match)
    {
        if (isset($this->params[$match[1]])) {
            return '(' . $this->params[$match[1]] . ')';
        }
        return '([^/]+)';
    }

    /**
     * Génère une URL à partir des paramètres donnés
     *
     * @param array $params
     * @return string
     */
    public function getUrl($params)
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", $v, $path);
        }
        return $path;
    }

    /**
     * Appelle la fonction/callback associée à la route
     *
     * @return mixed
     */
    public function call()
    {
        if (is_string($this->callable)) {
            $params = explode('#', $this->callable);
            $controller = $params[0];
            require_once ROOT . 'controllers/' . $controller . '.php';
            $controller = new $controller();
            return call_user_func_array([$controller, $params[1]], $this->matches);
        } else {
            return call_user_func_array($this->callable, $this->matches);
        }
    }
}
