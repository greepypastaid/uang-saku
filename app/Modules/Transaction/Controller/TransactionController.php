<?php

namespace App\Modules\Transaction\Controller;

use App\Controllers\BaseController;

class TransactionController extends BaseController
{
    public function index(): string
    {
        return view('../Modules/Transaction/View/transaction');
    }
}
