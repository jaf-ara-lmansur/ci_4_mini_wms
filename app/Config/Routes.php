<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->group('items',static function($routes){
    $routes->get('/','ItemController::index');
    $routes->get('create','ItemController::create');
    $routes->post('store','ItemController::store');
    $routes->get('edit/(:num)','ItemController::edit/$1');
    $routes->post('update/(:num)','ItemController::update/$1');
    $routes->post('delete/(:num)','ItemController::delete/$1');
});

$routes->group('inbound',static function($routes){
        $routes->get('/','InboundController::index');
        $routes->post('store','InboundController::store');
        $routes->get('create','InboundController::create');
        $routes->post('reject/(:num)','InboundController::reject/$1');
});
