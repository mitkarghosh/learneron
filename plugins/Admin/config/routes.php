<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::plugin(
    'Admin',
    ['path' => '/admin'],
    function (RouteBuilder $routes) {

    	$routes->connect('/reset', ['plugin' => 'Admin','controller' => 'user', 'action' => 'reset']);

        $routes->fallbacks(DashedRoute::class);
    }
);
