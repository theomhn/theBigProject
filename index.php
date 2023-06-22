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
    $router->get('/tournois', "Bases#getTournamentHome");
    $router->get('/les-tournois', "Bases#getAllTournaments");
    $router->get('/tournois/:id', "Bases#getTournamentView");
}

// API
$router->post('/ws/login', "Users#login");
$router->post('/ws/users', "Users#post");

if (USER !== false) {

    /* Users */
    $router->post("/ws/users", "Users#post");
    $router->get('/ws/logout', "Users#logout");

    /* Tournaments */
    $router->get("/ws/tournaments", "Tournaments#getAll");
    $router->get("/ws/tournaments/:id", "Tournaments#get");
    $router->get("/ws/tournaments/:id/users", "Tournaments#getParticipants");
    $router->post("/ws/tournaments/", "Tournaments#post");
    $router->post("/ws/tournaments/:id/join", "Tournaments#join");

    /* Games */
    $router->get("/ws/games/:id", "Games#get");
    $router->put("/ws/games/:id", "Games#setScore");
}

try {
    $router->run();
} catch (Exception $ex) {
    // Si aucune route n'est trouvée, redirection vers une erreur 404
    require_once ROOT . 'controllers/Bases.php';
    $controller = new Bases();
    $controller->get404();
}
