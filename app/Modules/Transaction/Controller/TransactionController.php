<?php

namespace App\Modules\Transaction\Controller;

use App\Controllers\BaseController;
use App\Modules\Transaction\Model\TransactionModel;
use App\Modules\Wallet\Model\WalletModel;

class TransactionController extends BaseController
{
    protected $transactionModel;
    protected $walletModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->walletModel = new WalletModel();
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

        $totalBuilder = $this->transactionModel->builder()->where('user_id', $userId);
        $recordsTotal = (int) $totalBuilder->countAllResults(false);

        $builder = $this->transactionModel->builder()->where('user_id', $userId);

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

        $updated = $this->transactionModel->updateTransaction($data['id'], $arrayTransaksi);

        if ($updated && !empty($arrayTransaksi['wallet_id'])) {
            $tandaNew = ($arrayTransaksi['type'] === 'income') ? 1 : -1;
            $this->adjustWalletSaldo((int) $arrayTransaksi['wallet_id'], $tandaNew * (float) $arrayTransaksi['harga']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Berhasil Memperbarui data transaksi.']);
    }
}