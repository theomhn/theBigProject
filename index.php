<?php

// On génère une constante contenant le chemin vers la racine publique du projet
// Plus propre que l'autre méthode
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));
define('APP', '/' . basename(__DIR__));

require_once ROOT . 'app/Router.php';
require_once ROOT . 'app/Controller.php';
require_once ROOT . 'app/Model.php';
require_once ROOT . 'controllers/Users.php';

$security = new Users();
define('USER', $security->authentificate());
$router = new Router($_GET['url']);

/** GET */
$router->get('/', "Bases#getHome");
$router->get('/connexion', "Bases#getConnexion");
$router->get('/activate', "Users#activate");

if (USER !== false) {
    $router->get('/tournois', "Tournaments#getHome");
    $router->get('/les-tournois', "Tournaments#getAllTournaments");
    $router->get('/saisir-les-scores', "Tournaments#getScores");
    $router->get('/tournoi/:id', "Tournaments#getTournamentView");
}

// API
$apiController = ["Users", "Tournaments"];

$router->post('/ws/login', "Users#login");
$router->post('/ws/users', "Users#post");

if (USER !== false) {
    $router->post("/ws/tournaments/:id/join", "Tournaments#join");
    $router->get("/ws/tournaments/:id/users", "Tournaments#getParticipants");

    /* Users */
    // $router->get("/ws/Users/:id", "Users#get");
    $router->post("/ws/Users/", "Users#post");
    // $router->put("/ws/Users/", "Users#put");
    // $router->delete("/ws/Users/:id", "Users#delete");

    /* Tournaments */
    $router->get("/ws/Tournaments", "Tournaments#getAll");
    $router->get("/ws/Tournaments/:id", "Tournaments#get");
    $router->post("/ws/Tournaments/", "Tournaments#post");
    // $router->put("/ws/Tournaments/", "Tournaments#put");
    // $router->delete("/ws/Tournaments/:id", "Tournaments#delete");
}

try {
    $router->run();
} catch (Exception $ex) {
    // Si aucune route n'est trouvée, redirection vers une erreur 404
    require_once ROOT . 'controllers/Bases.php';
    $controller = new Bases();
    $controller->get404();
}
