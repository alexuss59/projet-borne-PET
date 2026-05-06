<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Cacceuil::index');
$routes->resource('Api/BonsAchat', ['controller' => 'Api\BonsAchat']);
$routes->get('Api/BonsAchat/verifier/(:segment)', 'Api\BonsAchat::verifier/$1');
$routes->post('api/genererBon', 'Api\BonsAchat::genererBon');
service('auth')->routes($routes);


