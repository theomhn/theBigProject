<?php

// On génère une constante contenant le chemin vers la racine publique du projet
// Plus propre que l'autre méthode
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
$GLOBALS['user'] = false;

require_once ROOT . 'app/Router.php';
require_once ROOT . 'app/Controller.php';
require_once ROOT . 'app/Model.php';
require_once ROOT . 'app/Security.php';

$security = new Security();
$security->authentificate();

$router = new Router($_GET['url']);

/** GET */
$router->get('/', "Bases#getHome");
$router->get('/connexion', "Bases#getConnexion");
$router->get('/tournois', "Tournaments#getHome");
$router->get('/lesTournois', "Tournaments#getAllTournaments");

/** POST */
$router->post('/tournois', "Tournaments#createTournament");
$router->post('/inscription', "Users#post");
//$router->put('/inscription', "Users#update");

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
