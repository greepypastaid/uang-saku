<?php

namespace App\Modules\Home\Controller;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        return view('../Modules/Home/View/landing');
    }
}
