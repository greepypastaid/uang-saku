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
        if (! auth()->loggedIn()) {
            return redirect()->to('/login');
        }

        return view('../Modules/Dashboard/View/dashboard');
    }

    function getData()
    {
        $userId = auth()->id() ?? session()->get('id');
        $totalSaldo = $this->walletModel->getTotalSaldo($userId);
        $totalPengeluaran = $this->transactionModel->getTotalExpense($userId);
        $totalPemasukan = $this->transactionModel->getTotalIncome($userId);

        return $this->response->setJSON([
            'total_saldo' => $totalSaldo,
            'total_pengeluaran' => $totalPengeluaran,
            'total_pemasukan' => $totalPemasukan,
        ]);
    }
}
