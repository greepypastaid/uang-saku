<?php

namespace App\Modules\Dashboard\Controller;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('../Modules/Dashboard/View/dashboard');
    }
}
