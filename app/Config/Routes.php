<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

foreach (glob(APPPATH . 'Modules/*/Config/*Routes.php') as $file) {
    require $file;
}