<?php

$routes->group('wishlist', ['namespace' => 'App\Modules\Wishlist\Controller', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'WishlistController::index');
    $routes->post('create', 'WishlistController::create');
    $routes->post('update/(:num)', 'WishlistController::update/$1');
    $routes->post('delete/(:num)', 'WishlistController::delete/$1');
    $routes->post('purchased/(:num)', 'WishlistController::markPurchased/$1');
    $routes->post('work-settings', 'WishlistController::saveWorkSettings');
});
