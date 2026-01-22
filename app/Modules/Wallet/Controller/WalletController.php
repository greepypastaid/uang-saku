<?php

namespace App\Modules\Wallet\Controller;

use App\Controllers\BaseController;
use App\Modules\Wallet\Model\WalletModel;

class WalletController extends BaseController
{
    protected $walletModel;

    public function __construct()
    {
        $this->walletModel = new WalletModel();
    }

    public function index()
    {
        return view('../Modules/Wallet/View/wallet');
    }

    public function create()
    {
        $data = $this->request->getPost();

        $arrayWallet = [
            'nama' => $data['nama'] ?? null,
            'saldo' => $data['saldo'] ?? null,
        ];

        if (!$this->walletModel->validate($arrayWallet)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->walletModel->errors()]);
        }

        $insertId = $this->walletModel->insert($arrayWallet);

        if ($insertId) {
            $arrayWallet['id'] = $insertId;
            return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil disimpan.', 'data' => $arrayWallet]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan data wallet.']);
    }

    public function list()
    {
        $transaksi = $this->walletModel->getAllWallets();
        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function read()
    {
        $id = $this->request->getGet('id');
        $transaksi = $this->walletModel->find($id);
        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function delete()
    {
        $data = $this->request->getPost();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID Wallet wajib diisi.']);
        }

        $deleted = $this->walletModel->deleteWallet($data['id']);
        if ($deleted === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus data wallet.']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Data wallet berhasil dihapus.']);
    }

    public function update()
    {
        $data = $this->request->getPost();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID Wallet wajib diisi.']);
        }

        $arrayWallet = [
            'nama' => $data['nama'] ?? null,
            'saldo' => $data['saldo'] ?? null,
        ];

        if (!$this->walletModel->validate($arrayWallet)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Validasi gagal.', 'errors' => $this->walletModel->errors()]);
        }

        $updated = $this->walletModel->updateWallet($data['id'], $arrayWallet);
        if ($updated === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal memperbarui data wallet.']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Data wallet berhasil diperbarui!']);
    }

    public function transfer()
    {
        $data = $this->request->getPost();

        $from = (int) ($data['from_wallet_id'] ?? 0);
        $to = (int) ($data['to_wallet_id'] ?? 0);
        $amount = (float) ($data['amount'] ?? 0);
        $note = $data['note'] ?? 'Transfer Dana';

        if ($from <= 0 || $to <= 0 || $amount <= 0) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data transfer tidak valid.'
            ]);
        }

        if ($from === $to) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Wallet asal dan tujuan tidak boleh sama.'
            ]);
        }

        $status = $this->walletModel->transferFunds($from, $to, $amount, $note);

        return $this->response->setJSON([
            'status' => $status,
            'message' => $status ? 'Transfer dana berhasil.' : 'Transfer dana gagal.'
        ]);
    }

}
