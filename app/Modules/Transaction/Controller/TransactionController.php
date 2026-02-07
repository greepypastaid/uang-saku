<?php

namespace App\Modules\Transaction\Controller;

use App\Controllers\BaseController;
use App\Modules\Transaction\Model\TransactionModel;
use App\Modules\Wallet\Model\WalletModel;
use App\Modules\Budget\Model\BudgetModel;

class TransactionController extends BaseController
{
    protected $transactionModel;
    protected $walletModel;
    protected $budgetModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->walletModel = new WalletModel();
        $this->budgetModel = new BudgetModel();
    }

    public function adjustWalletSaldo(int $walletId, float $amount)
    {
        $wallet = $this->walletModel->find($walletId);
        if ($wallet) {
            $wallet['saldo'] += $amount;
            $this->walletModel->update($walletId, ['saldo' => $wallet['saldo']]);
        }
    }

    public function index(): string
    {
        $userId = auth()->id();
        $wallets = $this->walletModel->where('user_id', $userId)->findAll();

        return view('../Modules/Transaction/View/transaction', ['wallets' => $wallets]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $arrayTransaksi = [
            'user_id' => $userId,
            'tanggal' => $data['tanggal'] ?? null,
            'nama_transaksi' => $data['nama_transaksi'] ?? null,
            'harga' => $data['harga'] ?? null,
            'kategori' => $data['kategori'] ?? null,
            'wallet_id' => $data['wallet_id'] ?? null,
            'transfer_id' => $data['transfer_id'] ?? null,
            'type' => $data['type'] ?? null,
        ];

        if (!$this->transactionModel->validate($arrayTransaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->transactionModel->errors()]);
        }

        // Check budget limit for expense transactions
        if ($arrayTransaksi['type'] === 'expense') {
            $budgetCheck = $this->checkBudgetLimit(
                $userId,
                $arrayTransaksi['kategori'],
                $arrayTransaksi['tanggal'],
                (float) $arrayTransaksi['harga']
            );
            
            if (!$budgetCheck['allowed']) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $budgetCheck['message'],
                    'budget_warning' => true
                ]);
            }
        }

        $insertId = $this->transactionModel->createTransaction($arrayTransaksi);

        if ($insertId) {
            if (!empty($arrayTransaksi['wallet_id'])) {
                $tanda = ($arrayTransaksi['type'] === 'income') ? 1 : -1;
                $this->adjustWalletSaldo((int) $arrayTransaksi['wallet_id'], $tanda * (float) $arrayTransaksi['harga']);
            }

            $arrayTransaksi['id'] = $insertId;
            return $this->response->setJSON(['status' => true, 'message' => 'Data transaksi berhasil disimpan.', 'data' => $arrayTransaksi]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan data transaksi.']);
    }

    public function log(){
        return view('../Modules/Transaction/View/log_mutation');
    }

    public function list()
    {
        $req = $this->request;
        $draw = (int) ($req->getGet('draw') ?? 0);
        $start = (int) ($req->getGet('start') ?? 0);
        $length = (int) ($req->getGet('length') ?? 10);
        $searchValue = $req->getGet('search')['value'] ?? null;
        $order = $req->getGet('order');
        $columns = $req->getGet('columns');

        $userId = auth()->id();
        $mode = $req->getGet('mode') ?? 'daily';

        $totalBuilder = $this->transactionModel->builder()->where('user_id', $userId);
        $recordsTotal = (int) $totalBuilder->countAllResults(false);

        $builder = $this->transactionModel->builder()->where('user_id', $userId);

        if ($mode === 'daily') {
            $builder->where('kategori !=', 'Hutang/Piutang');
        }

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('nama_transaksi', $searchValue)
                ->orLike('kategori', $searchValue)
                ->orLike('harga', $searchValue)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $recordsFiltered = (int) $countBuilder->countAllResults(false);

        $columnMap = [
            0 => 'id',
            1 => 'tanggal',
            2 => 'nama_transaksi',
            3 => 'harga',
            4 => 'kategori',
            5 => 'id',
        ];

        if (!empty($order) && isset($order[0]['column'])) {
            $colIndex = (int) $order[0]['column'];
            $colName = $columnMap[$colIndex] ?? 'id';
            $dir = (isset($order[0]['dir']) && strtolower($order[0]['dir']) === 'asc') ? 'ASC' : 'DESC';
            $builder->orderBy($colName, $dir);
        } else {
            $builder->orderBy('tanggal', 'DESC')->orderBy('id', 'DESC');
        }

        if ($length != -1) {
            $builder->limit($length, $start);
        }

        $data = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function delete()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID wajib diisi.']);
        }

        $transaksi = $this->transactionModel->where('id', $data['id'])
            ->where('user_id', $userId)
            ->first();

        if (!$transaksi) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan atau Anda tidak memiliki akses.']);
        }

        if (!empty($transaksi['wallet_id'])) {
            $tanda = ($transaksi['type'] === 'income') ? -1 : 1;
            $this->adjustWalletSaldo((int) $transaksi['wallet_id'], $tanda * (float) $transaksi['harga']);
        }

        $this->transactionModel->delete($data['id']);

        return $this->response->setJSON(['status' => true, 'message' => 'Berhasil dihapus.']);
    }

    public function read()
    {
        $id = $this->request->getVar('id');

        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $transaksi = $this->transactionModel->getTransactionById($id);

        if (empty($transaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data transaksi tidak ditemukan.']);
        }

        $userId = auth()->id();
        if ((int) ($transaksi['user_id'] ?? 0) !== (int) $userId) {
            return $this->response->setJSON(['status' => false, 'message' => 'Anda tidak memiliki akses ke transaksi ini.']);
        }

        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function update()
    {
        $data = $this->request->getPost();
        $id = $data['id'] ?? $data['id_transaksi'] ?? null;

        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $data['id'] = $id;
        $userId = auth()->id();

        $arrayTransaksi = [
            'user_id' => $userId,
            'tanggal' => $data['tanggal'] ?? null,
            'nama_transaksi' => $data['nama_transaksi'] ?? null,
            'harga' => $data['harga'] ?? null,
            'kategori' => $data['kategori'] ?? null,
            'wallet_id' => $data['wallet_id'] ?? null,
            'type' => $data['type'] ?? null,
        ];

        $uangLama = $this->transactionModel->getTransactionById($data['id']);

        if (!$uangLama || ((int) ($uangLama['user_id'] ?? 0) !== (int) $userId)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan atau Anda tidak memiliki akses.']);
        }

        if ($uangLama && !empty($uangLama['wallet_id'])) {
            $tandaOld = ($uangLama['type'] === 'income') ? -1 : 1;
            $this->adjustWalletSaldo((int) $uangLama['wallet_id'], $tandaOld * (float) $uangLama['harga']);
        }

        if (!$this->transactionModel->validate($arrayTransaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->transactionModel->errors()]);
        }

        // Check budget limit for expense transactions
        if ($arrayTransaksi['type'] === 'expense') {
            $budgetCheck = $this->checkBudgetLimit(
                $userId,
                $arrayTransaksi['kategori'],
                $arrayTransaksi['tanggal'],
                (float) $arrayTransaksi['harga'],
                $data['id'] // exclude current transaction from calculation
            );
            
            if (!$budgetCheck['allowed']) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => $budgetCheck['message'],
                    'budget_warning' => true
                ]);
            }
        }

        $updated = $this->transactionModel->updateTransaction($data['id'], $arrayTransaksi);

        if ($updated && !empty($arrayTransaksi['wallet_id'])) {
            $tandaNew = ($arrayTransaksi['type'] === 'income') ? 1 : -1;
            $this->adjustWalletSaldo((int) $arrayTransaksi['wallet_id'], $tandaNew * (float) $arrayTransaksi['harga']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Berhasil Memperbarui data transaksi.']);
    }

    private function checkBudgetLimit($userId, $kategori, $tanggal, $amount, $excludeTransactionId = null)
    {
        $date = new \DateTime($tanggal);
        $month = (int) $date->format('n');
        $year = (int) $date->format('Y');

        // Get budget for this category and month
        $budget = $this->budgetModel
            ->where('user_id', $userId)
            ->where('category', $kategori)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$budget) {
            // No budget set, allow transaction
            return ['allowed' => true];
        }

        // Calculate current spending for this category in this month
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $builder->select('SUM(harga) as total_spent');
        $builder->where('user_id', $userId);
        $builder->where('kategori', $kategori);
        $builder->where('type', 'expense');
        $builder->where('MONTH(tanggal)', $month);
        $builder->where('YEAR(tanggal)', $year);
        
        if ($excludeTransactionId) {
            $builder->where('id !=', $excludeTransactionId);
        }
        
        $result = $builder->get()->getRowArray();
        $currentSpent = (float) ($result['total_spent'] ?? 0);
        
        $newTotal = $currentSpent + $amount;
        $budgetLimit = (float) $budget['amount'];
        
        if ($newTotal > $budgetLimit) {
            $remaining = $budgetLimit - $currentSpent;
            return [
                'allowed' => false,
                'message' => sprintf(
                    'Budget untuk kategori "%s" di bulan ini adalah Rp %s. Anda sudah menghabiskan Rp %s. Transaksi ini (Rp %s) akan melebihi budget. Sisa budget: Rp %s',
                    $kategori,
                    number_format($budgetLimit, 0, ',', '.'),
                    number_format($currentSpent, 0, ',', '.'),
                    number_format($amount, 0, ',', '.'),
                    number_format(max(0, $remaining), 0, ',', '.')
                )
            ];
        }

        return ['allowed' => true];
    }
}