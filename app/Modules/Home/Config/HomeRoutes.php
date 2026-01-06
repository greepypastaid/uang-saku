<?php

$routes->group('', ['namespace' => 'App\Modules\Home\Controller'], function ($routes) {
    $routes->get('/', 'HomeController::index');  
    $routes->get('/whyus', function() {
        return view('../Modules/Home/View/whyus');
    });
    $routes->get('/contact', function() {
        return view('../Modules/Home/View/contact');
    });
    $routes->get('/about', function() {
        return view('../Modules/Home/View/about');
    });
});