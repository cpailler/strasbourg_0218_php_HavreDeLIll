<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/10/17
 * Time: 17:20
 */


$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'Accueil/index');
    $r->addRoute('GET', '/Chambres', 'Chambre/index');
    $r->addRoute('POST', '/Chambres', 'Chambre/index');
    $r->addRoute('GET', '/Parlementaires', 'Parlementaires/index');
    $r->addRoute('GET', '/Localisation', 'Localisation/index');
    $r->addRoute('GET', '/Accueil', 'Accueil/index');
    $r->addRoute('GET', '/Login', 'Login/index');
    $r->addRoute('POST', '/Login', 'Login/index');
    $r->addRoute('GET', '/Logout', 'Logout/index');
    $r->addRoute('GET', '/Reservation/{initMonth:\d+}/{initYear:\d+}', 'Reservation/init');
    $r->addRoute('GET', '/Reservation', 'Reservation/init');
    $r->addRoute('POST', '/Reservation/mail', 'Reservation/envoiMail');
   // $r->addRoute('GET', '/Reservation/mail', 'Reservation/envoiMail');
    $r->addRoute('GET', '/Administration', 'Administration/index');
    $r->addRoute('GET', '/Administration/DiapoAccueil', 'Administration/DiapoAccueil');
    $r->addRoute('POST', '/Administration/DiapoAccueil', 'Administration/DiapoAccueil');
    $r->addRoute('GET', '/Administration/ArticlesAccueil', 'Administration/ArticlesAccueil');
    $r->addRoute('POST', '/Administration/ArticlesAccueil', 'Administration/ArticlesAccueil');
    $r->addRoute('GET', '/Administration/Chambres', 'Administration/AdminChambres');
    $r->addRoute('POST', '/Administration/Chambres', 'Administration/AdminChambres');
    // {id} must be a number (\d+)
    /*
    $r->addRoute('GET', '/item/{id:\d+}', 'Item/show');
    $r->addRoute('GET', '/item/add', 'Item/add');
    $r->addRoute('GET', '/item/edit/{id:\d+}', 'Item/edit');
    $r->addRoute('GET', '/admin', 'Admin/index');
    */
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);
        $class = APP_CONTROLLER_NAMESPACE . $class . APP_CONTROLLER_SUFFIX;
        echo call_user_func_array(array(new $class, $method), $vars);
        break;
}
