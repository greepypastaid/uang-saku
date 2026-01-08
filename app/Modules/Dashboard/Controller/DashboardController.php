<?php

namespace App\Modules\Dashboard\Controller;

use App\Controllers\BaseController;
use App\Modules\Wallet\Model\WalletModel;
use App\Modules\Transaction\Model\TransactionModel;

class DashboardController extends BaseController
{
    protected $walletModel;
    protected $transactionModel;



    public function __construct()
    {
        $this->walletModel = new WalletModel();
        $this->transactionModel = new TransactionModel();
    }
    public function index()
    {
        return view('../Modules/Dashboard/View/dashboard');
    }

    function getData()
    {
        $totalSaldo = $this->walletModel->getTotalSaldo();
        $totalPengeluaran = $this->transactionModel->getTotalExpense();
        $totalPemasukan = $this->transactionModel->getTotalIncome();

        return $this->response->setJSON([
            'total_saldo' => $totalSaldo,
            'total_pengeluaran' => $totalPengeluaran,
            'total_pemasukan' => $totalPemasukan,
        ]);
    }
}
