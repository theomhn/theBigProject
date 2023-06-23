<?php

require_once ROOT . "/app/Route.php";

class RouterException extends Exception
{
    public function __construct(...$args)
    {
        parent::__construct(...$args);
    }
}

class Router
{

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    /**
     * Constructeur de la classe Router
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Définit une route pour la méthode GET
     *
     * @param string $path
     * @param mixed $callable
     * @param string|null $name
     * @return Route
     */
    public function get($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'GET');
    }

    /**
     * Définit une route pour la méthode POST
     *
     * @param string $path
     * @param mixed $callable
     * @param string|null $name
     * @return Route
     */
    public function post($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'POST');
    }

    /**
     * Définit une route pour la méthode PUT
     *
     * @param string $path
     * @param mixed $callable
     * @param string|null $name
     * @return Route
     */
    public function put($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'PUT');
    }

    /**
     * Définit une route pour la méthode DELETE
     *
     * @param string $path
     * @param mixed $callable
     * @param string|null $name
     * @return Route
     */
    public function delete($path, $callable, $name = null)
    {
        return $this->add($path, $callable, $name, 'DELETE');
    }

    /**
     * Ajoute une route à la liste des routes
     *
     * @param string $path
     * @param mixed $callable
     * @param string|null $name
     * @param string $method
     * @return Route
     */
    private function add($path, $callable, $name, $method)
    {
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable) && $name === null) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * Exécute le routeur pour trouver et appeler la route correspondante
     *
     * @return mixed
     * @throws RouterException
     */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if (!isset($this->routes[$method])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }

        foreach ($this->routes[$method] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new RouterException('No matching routes');
    }

    /**
     * Génère une URL à partir du nom de la route et des paramètres donnés
     *
     * @param string $name
     * @param array $params
     * @return string
     * @throws RouterException
     */
    public function url($name, $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }
}
