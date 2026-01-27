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
        $req = $this->request;
        $draw = (int) ($req->getGet('draw') ?? 0);
        $start = (int) ($req->getGet('start') ?? 0);
        $length = (int) ($req->getGet('length') ?? 10);
        $order = (int) ($req->getGet('order') ?? 0);

        $searchValue = $req->getGet('search')['value'] ?? null;
        $order = $req->getGet('order');
        $columns = $req->getGet('columns');

        // buat nyari data mentahane tanpa filter
        $totalBuilder = $this->walletModel->builder();
        $recordsTotal = (int) $totalBuilder->countAllResults(false);

        // buat filtering search
        $builder = $this->walletModel->builder();

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('nama', $searchValue)
                ->orLike('saldo', $searchValue)
                ->groupEnd();
        }

        // itung ulang
        $countBuilder = clone $builder;
        $recordsFiltered = (int) $countBuilder->countAllResults(false);

        $data = $builder->limit($length, $start)->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])->get()->getResultArray();

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
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
