<?php

// La constante ROOT représente le chemin absolu du répertoire racine de l'application
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));

// La constante APP représente le chemin relatif du répertoire de l'application
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


//Si l'utilisateur est connecté
if (USER !== false) {
    $router->get('/tournois', "Bases#getTournamentHome");
    $router->get('/les-tournois', "Bases#getAllTournaments");
    $router->get('/tournois/:id', "Bases#getTournamentView");
}

// API
$router->post('/ws/login', "Users#login");
$router->post('/ws/users', "Users#post");

//Si l'utilisateur est connecté
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
} catch (RouterException $ex) {
    // Si aucune route n'est trouvée, redirection vers une erreur 404
    require_once ROOT . 'controllers/Bases.php';
    $controller = new Bases();
    $controller->get404();
} catch (Exception $ex) {
    http_response_code(500);
    echo "Erreur serveur, veuillez réessayer.<br>";
    echo "Si le problème persiste, informez un webmaster du détail suivant.";
    echo "<details>";
    echo "<summary>Détails</summary>";
    echo($ex->getMessage());
    echo "</details>";
}