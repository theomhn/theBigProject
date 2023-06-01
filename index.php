<?php

// On génère une constante contenant le chemin vers la racine publique du projet
// Plus propre que l'autre méthode
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
define('APP', '/' . basename(__DIR__));
$GLOBALS['user'] = false;

require_once ROOT . 'app/Router.php';
require_once ROOT . 'app/Controller.php';
require_once ROOT . 'app/Model.php';
require_once ROOT . 'controllers/Users.php';

$security = new Users();
$GLOBALS['user'] = $security->authentificate();

$router = new Router($_GET['url']);

/** GET */
$router->get('/', "Bases#getHome");
$router->get('/connexion', "Bases#getConnexion");
$router->get('/tournois', "Tournaments#getHome");
$router->get('/lesTournois', "Tournaments#getAllTournaments");

// API
$router->post('/ws/login', "Users#login");
$apiController = ["Users", "Tournaments"];
foreach ($apiController as $controller) {
    $router->get("/ws/$controller", "$controller#getAll");
    $router->get("/ws/$controller/:id", "$controller#get");
    $router->post("/ws/$controller/", "$controller#post");
    $router->put("/ws/$controller/", "$controller#put");
    $router->delete("/ws/$controller/:id", "$controller#delete");
}

try {
    $router->run();
} catch (Exception $ex) {
    // Si aucune route n'est trouvée, redirection vers une erreur 404
    require_once ROOT . 'controllers/Bases.php';
    $controller = new Bases();
    $controller->get404();
}
