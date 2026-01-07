<?php

namespace App\Modules\Dashboard\Controller;

use App\Controllers\BaseController;
use App\Modules\Wallet\Model\WalletModel;

class DashboardController extends BaseController
{
    protected $walletModel;

    public function __construct()
    {
        $this->walletModel = new WalletModel();
    }

    public function index()
    {
        $wallets = $this->walletModel->findAll();
        return view('../Modules/Dashboard/View/dashboard', ['wallets' => $wallets]);
    }
}
