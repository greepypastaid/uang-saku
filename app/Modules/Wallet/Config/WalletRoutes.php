<?php

$routes->group('wallet', ['namespace' => 'App\Modules\Wallet\Controller'], function ($routes) {
    $routes->get('/', 'WalletController::index');
    $routes->post('create', 'WalletController::create');
    $routes->post('update', 'WalletController::update');
    $routes->post('delete', 'WalletController::delete');
    $routes->get('list', 'WalletController::list');
    $routes->get('read', 'WalletController::read');
});
