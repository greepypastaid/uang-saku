<?php

namespace App\Modules\Hutangpiutang\Controllers;

use App\Controllers\BaseController;
use App\Modules\Hutangpiutang\Models\HutangPiutangModel;
use App\Modules\Transaction\Model\TransactionModel;
use App\Modules\Wallet\Model\WalletModel;

class HutangPiutangController extends BaseController
{
    protected $HutangPiutangModel;
    protected $transactionModel;
    protected $walletModel;

    public function __construct()
    {
        $this->HutangPiutangModel = new HutangPiutangModel();
        $this->transactionModel = new TransactionModel();
        $this->walletModel = new WalletModel();
    }

    public function index()
    {
        $userId = auth()->id();
        $wallets = $this->walletModel->where('user_id', $userId)->findAll();
        return view('../Modules/Hutangpiutang/Views/hutangpiutang', ['wallets' => $wallets]);
    }

    public function list()
    {
        $userId = auth()->id();
        $req = $this->request;
        $start = (int) ($req->getGet('start') ?? 0);
        $length = (int) ($req->getGet('length') ?? 10);
        $searchValue = $req->getGet('search')['value'] ?? null;

        $builder = $this->HutangPiutangModel->builder()->where('user_id', $userId);
        
        if ($searchValue) {
            $builder->groupStart()
                ->like('person_name', $searchValue)
                ->orLike('description', $searchValue)
                ->groupEnd();
        }

        $totalRecords = $builder->countAllResults(false);
        $data = $builder->limit($length, $start)->orderBy('created_at', 'DESC')->get()->getResultArray();
        
        return $this->response->setJSON([
            'draw' => (int)$req->getGet('draw'),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords, 
            'data' => $data
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();
        $amount = (float) str_replace('.', '', $data['amount']);
        $walletId = $data['wallet_id'];
        $type = $data['type'];

        if ($type === 'piutang') {
            $wallet = $this->walletModel->find($walletId);
            if (!$wallet || $wallet['saldo'] < $amount) {
                return $this->response->setJSON(['status' => false, 'message' => 'Saldo wallet tidak cukup untuk meminjamkan uang.']);
            }
        }

        $insertData = [
            'user_id' => $userId,
            'wallet_id' => $walletId,
            'type' => $type,
            'person_name' => $data['person_name'],
            'amount' => $amount,
            'due_date' => $data['due_date'],
            'description' => $data['description'],
            'status' => 'unpaid'
        ];
        $this->HutangPiutangModel->insert($insertData);
        $hutangId = $this->HutangPiutangModel->getInsertID();
        
        $transType = ($type === 'hutang') ? 'income' : 'expense';
        $transName = ($type === 'hutang') ? "Pinjaman dari: " . $data['person_name'] : "Meminjamkan ke: " . $data['person_name'];

        $transData = [
            'user_id' => $userId,
            'tanggal' => date('Y-m-d'),
            'nama_transaksi' => $transName,
            'harga' => $amount,
            'kategori' => 'Hutang/Piutang',
            'wallet_id' => $walletId,
            'type' => $transType
        ];
        $this->transactionModel->insert($transData);

        $wallet = $this->walletModel->find($walletId);
        $newSaldo = ($transType === 'income') ? ($wallet['saldo'] + $amount) : ($wallet['saldo'] - $amount);
        $this->walletModel->update($walletId, ['saldo' => $newSaldo]);

        return $this->response->setJSON(['status' => true, 'message' => 'Data disimpan & Saldo wallet diperbarui']);
    }

    public function read()
    {
        $id = $this->request->getGet('id');
        $data = $this->HutangPiutangModel->find($id);
        
        if($data) {
            return $this->response->setJSON(['status' => true, 'data' => $data]);
        }
        return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
    }
    public function update()
    {
        $data = $this->request->getPost();
        $id = $data['id'];
        $userId = auth()->id();
        
        $oldData = $this->HutangPiutangModel->where('id', $id)->where('user_id', $userId)->first();
        if (!$oldData) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
        $newAmount = (float) str_replace('.', '', $data['amount']);
        $oldAmount = (float) $oldData['amount'];
        $type = $oldData['type'];
        $walletId = $oldData['wallet_id'];

        if ($newAmount !== $oldAmount) {
            $wallet = $this->walletModel->find($walletId);
            if (!$wallet) {
                return $this->response->setJSON(['status' => false, 'message' => 'Wallet tidak ditemukan, tidak bisa update nominal.']);
            }

            $currentSaldo = (float) $wallet['saldo'];
            $newSaldo = $currentSaldo;

            if ($type === 'hutang') {
                $diff = $newAmount - $oldAmount;
                $newSaldo = $currentSaldo + $diff;
            } else {
                $diff = $newAmount - $oldAmount;
                
                if ($diff > 0 && $currentSaldo < $diff) {
                    return $this->response->setJSON(['status' => false, 'message' => 'Saldo wallet tidak cukup untuk menambah nominal piutang ini.']);
                }
                
                $newSaldo = $currentSaldo - $diff; 
            }

            $this->walletModel->update($walletId, ['saldo' => $newSaldo]);
        }

        $updateData = [
            'person_name' => $data['person_name'],
            'amount' => $newAmount,
            'description' => $data['description'],
        ];

        $this->HutangPiutangModel->update($id, $updateData);
        
        return $this->response->setJSON([
            'status' => true, 
            'message' => 'Data diperbarui & Saldo wallet otomatis disesuaikan!'
        ]);
    }

    public function pelunasan()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();
        $HutangPiutangId = $data['id'];
        $walletId = $data['wallet_id'];

        $HutangPiutang = $this->HutangPiutangModel->where('id', $HutangPiutangId)->where('user_id', $userId)->first();
        if (!$HutangPiutang || $HutangPiutang['status'] === 'paid') {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak valid atau sudah lunas']);
        }

        $transType = ($HutangPiutang['type'] === 'hutang') ? 'expense' : 'income';
        $transName = "Pelunasan " . ucfirst($HutangPiutang['type']) . ": " . $HutangPiutang['person_name'];

        $transData = [
            'user_id' => $userId,
            'tanggal' => date('Y-m-d'),
            'nama_transaksi' => $transName,
            'harga' => $HutangPiutang['amount'],
            'kategori' => 'Hutang/Piutang',
            'wallet_id' => $walletId,
            'type' => $transType
        ];
        $this->transactionModel->insert($transData);

        $amount = (float) $HutangPiutang['amount'];
        $wallet = $this->walletModel->find($walletId);
        if ($transType === 'income') {
            $newSaldo = $wallet['saldo'] + $amount;
        } else {
            $newSaldo = $wallet['saldo'] - $amount;
        }
        $this->walletModel->update($walletId, ['saldo' => $newSaldo]);

        $this->HutangPiutangModel->update($HutangPiutangId, ['status' => 'paid']);

        return $this->response->setJSON(['status' => true, 'message' => 'Berhasil dilunasi & Saldo diupdate!']);
    }

    public function delete() {
        $id = $this->request->getPost('id');
        $this->HutangPiutangModel->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'Dihapus']);
    }
}