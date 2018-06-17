<?php
use Symfony\Component\Routing;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

// My App simple route

$routes->add('home', new Routing\Route('/', array(
'_controller' => 'App\Controller\DefaultController::indexAction',
)));

$routes->add('new', new Routing\Route('/new', array(
    '_controller' => 'App\Controller\DefaultController::newAction',
)));

$routes->add('edit', new Routing\Route('edit/{id}', array(
    'id' => null,
    '_controller' => 'App\Controller\DefaultController::editAction',
),
 array(
    'id' => '\d+'
)
));

$routes->add('delete', new Routing\Route('delete/{id}', array(
    'id' => null,
    '_controller' => 'App\Controller\DefaultController::deleteAction',
),
    array(
        'id' => '\d+'
    )
));

return $routes;

