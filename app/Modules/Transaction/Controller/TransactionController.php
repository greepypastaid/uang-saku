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
        $wallets = $this->walletModel->findAll();

        return view('../Modules/Transaction/View/transaction', ['wallets' => $wallets]);
    }



    public function create()
    {

        $data = $this->request->getPost();


        $arrayTransaksi = [

            'tanggal' => $data['tanggal'] ?? null,

            'nama_transaksi' => $data['nama_transaksi'] ?? null,

            'harga' => $data['harga'] ?? null,

            'kategori' => $data['kategori'] ?? null,

            'wallet_id' => $data['wallet_id'] ?? null,

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
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $keyword = $this->request->getGet('keyword');

        $builder = $this->transactionModel->builder();

        if ($keyword) {
            $builder->groupStart()
                ->like('nama_transaksi', $keyword)
                ->orLike('kategori', $keyword)
                ->groupEnd();
        }

        $countBuilder = clone $builder;
        $totalRows = $countBuilder->countAllResults();

        $data = $builder
            ->orderBy('tanggal', 'DESC')
            ->orderBy('id', 'DESC')
            ->limit($perPage, $offset) 
            ->get()
            ->getResultArray();

        return $this->response->setJSON([
            'status' => true,
            'data' => $data,
            'currentPage' => (int) $page,
            'totalPages' => ceil($totalRows / $perPage),
            'perPage' => $perPage,
            'totalRows' => $totalRows
        ]);
    }

    public function delete()
    {

        $data = $this->request->getPost();

        if (!isset($data['id'])) {

            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);

        }


        $id = $data['id'];

        $transaksi = $this->transactionModel->getTransactionById($id);

        if (empty($transaksi)) {

            return $this->response->setJSON(['status' => false, 'message' => 'Data transaksi tidak ditemukan.']);

        }


        if (!empty($transaksi['wallet_id'])) {

            $tanda = ($transaksi['type'] === 'income') ? -1 : 1;

            $this->adjustWalletSaldo((int) $transaksi['wallet_id'], $tanda * (float) $transaksi['harga']);

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

            'wallet_id' => $data['wallet_id'] ?? null,

            'type' => $data['type'] ?? null,

        ];


        // ambil data lama yax

        $uangLama = $this->transactionModel->getTransactionById($data['id']);


        if ($uangLama && !empty($uangLama['wallet_id'])) {

            $tandaOld = ($uangLama['type'] === 'income') ? -1 : 1; #terima kasih tab tab wkwk

            $this->adjustWalletSaldo((int) $uangLama['wallet_id'], $tandaOld * (float) $uangLama['harga']);

        }


        if (!$this->transactionModel->validate($arrayTransaksi)) {

            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->transactionModel->errors()]);

        }


        $updated = $this->transactionModel->updateTransaction($data['id'], $arrayTransaksi);


        if ($updated && !empty($arrayTransaksi['wallet_id'])) {

            $tandaNew = ($arrayTransaksi['type'] === 'income') ? 1 : -1;

            $this->adjustWalletSaldo((int) $arrayTransaksi['wallet_id'], $tandaNew * (float) $arrayTransaksi['harga']); // apply new

        }


        return $this->response->setJSON(['status' => false, 'message' => 'Berhasil Memperbarui data transaksi.']);

    }

}