<?php

$routes->group('saving-goals', ['namespace' => 'App\Modules\SavingGoal\Controller', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SavingGoalController::index');
    $routes->post('create', 'SavingGoalController::create');
    $routes->post('update/(:num)', 'SavingGoalController::update/$1');
    $routes->post('delete/(:num)', 'SavingGoalController::delete/$1');
    $routes->post('contribute/(:num)', 'SavingGoalController::contribute/$1');
    $routes->get('contributions/(:num)', 'SavingGoalController::contributions/$1');
    $routes->post('auto-allocate', 'SavingGoalController::autoAllocate');
    $routes->post('auto-rule', 'SavingGoalController::saveAutoRule');
});
