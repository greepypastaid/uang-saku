<?php

$routes->group('', ['namespace' => 'App\Modules\Home\Controller'], function ($routes) {
    $routes->get('/', 'HomeController::index');  
});