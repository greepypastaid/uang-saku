<?php

$routes->group('budget', ['namespace' => 'App\Modules\Budget\Controller', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BudgetController::index');
    $routes->get('list', 'BudgetController::list');
    $routes->post('create', 'BudgetController::create');
    $routes->post('update/(:num)', 'BudgetController::update/$1');
    $routes->post('delete/(:num)', 'BudgetController::delete/$1');
    $routes->get('info', 'BudgetController::getBudgetInfo');
});
