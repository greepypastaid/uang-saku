<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', '\App\Modules\Home\Controller\HomeController::index');
$routes->get('/transaction', '\App\Modules\Transaction\Controller\TransactionController::index');
$routes->post('/transaction/create', '\App\Modules\Transaction\Controller\TransactionController::create');
$routes->get('/transaction/list', '\App\Modules\Transaction\Controller\TransactionController::list');
$routes->get('/transaction/read', '\App\Modules\Transaction\Controller\TransactionController::read');
$routes->post('/transaction/delete', '\App\Modules\Transaction\Controller\TransactionController::delete');
$routes->post('/transaction/update', '\App\Modules\Transaction\Controller\TransactionController::update');
