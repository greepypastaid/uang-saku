<?php

namespace App\Modules\Transaction\Controller;

use App\Controllers\BaseController;
use App\Modules\Transaction\Model\TransactionModel;

class TransactionController extends BaseController
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function index(): string
    {
        return view('../Modules/Transaction/View/transaction');
    }

    public function create()
    {
        $data = $this->request->getPost();

        $arrayTransaksi = [
            'tanggal' => $data['tanggal'] ?? null,
            'nama_transaksi' => $data['nama_transaksi'] ?? null,
            'harga' => $data['harga'] ?? null,
            'kategori' => $data['kategori'] ?? null,
        ];

        if (!$this->transactionModel->validate($arrayTransaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->transactionModel->errors()]);
        }

        $insertId = $this->transactionModel->createTransaction($arrayTransaksi);
        if ($insertId) {
            $arrayTransaksi['id'] = $insertId;
            return $this->response->setJSON(['status' => true, 'message' => 'Data transaksi berhasil disimpan.', 'data' => $arrayTransaksi]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan data transaksi.']);
    }

    public function list()
    {
        $transaksi = $this->transactionModel->getAllTransactions();
        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function delete()
    {
        $data = $this->request->getPost();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $deleted = $this->transactionModel->deleteTransaction($data['id']);
        if ($deleted === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus data transaksi.']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Data transaksi berhasil dihapus.']);
    }

    public function read()
    {
        $id = $this->request->getGet('id');
        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $transaksi = $this->transactionModel->getTransactionById($id);
        if (empty($transaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data transaksi tidak ditemukan.']);
        }

        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function update()
    {
        $data = $this->request->getPost();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $arrayTransaksi = [
            'tanggal' => $data['tanggal'] ?? null,
            'nama_transaksi' => $data['nama_transaksi'] ?? null,
            'harga' => $data['harga'] ?? null,
            'kategori' => $data['kategori'] ?? null,
        ];

        if (!$this->transactionModel->validate($arrayTransaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->transactionModel->errors()]);
        }

        $updated = $this->transactionModel->updateTransaction($data['id'], $arrayTransaksi);

        if ($updated) {
            return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil diperbarui!', 'data' => $arrayTransaksi]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal memperbarui data transaksi.']);
    }
}
