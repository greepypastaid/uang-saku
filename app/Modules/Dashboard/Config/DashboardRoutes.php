<?php

$routes->group('', ['namespace' => 'App\Modules\Dashboard\Controller'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/dashboard/data', 'DashboardController::getData');
});
