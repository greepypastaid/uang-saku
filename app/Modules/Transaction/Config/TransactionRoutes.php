<?php

$routes->group('transaction', ['namespace' => 'App\Modules\Transaction\Controller'], function ($routes) {
    $routes->get('/', 'TransactionController::index');
    $routes->post('create', 'TransactionController::create');
    $routes->get('list', 'TransactionController::list');
    $routes->get('read', 'TransactionController::read');
    $routes->post('delete', 'TransactionController::delete');
    $routes->post('update', 'TransactionController::update');
});