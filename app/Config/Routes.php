<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', '\App\Modules\Home\Controller\HomeController::index');
$routes->get('/transaction', '\App\Modules\Transaction\Controller\TransactionController::index');
