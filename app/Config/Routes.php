<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', '\App\Modules\Home\Controller\HomeController::index');
$routes->get('/transaction', '\App\Modules\Transaction\Controller\TransactionController::index');
$routes->post('/transaction/create', '\App\Modules\Transaction\Controller\TransactionController::create');
$routes->get('/transaction/list', '\App\Modules\Transaction\Controller\TransactionController::list');
$routes->post('/transaction/delete', '\App\Modules\Transaction\Controller\TransactionController::delete');