<?php

namespace App\Modules\Wallet\Model;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama', 'saldo', 'created_at', 'updated_at', 'note'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function createWallet($data)
    {
        return $this->insert($data);
    }

    public function updateWallet($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteWallet($id)
    {
        return $this->delete($id);
    }

    public function getWalletById($id)
    {
        return $this->find($id);
    }

    public function getAllWallets()
    {
        return $this->findAll();
    }

    public function getTotalSaldo(): float
    {
        return (float) $this->selectSum('saldo')->get()->getRowArray()['saldo'] ?? 0;
    }

    public function transferFunds($fromWalletId, $toWalletId, $amount, $note = null)
    {
        $fromWallet = $this->find($fromWalletId);
        $toWallet = $this->find($toWalletId);

        if (!$fromWallet || !$toWallet) {
            return false;
        }

        if ((float) $fromWallet['saldo'] < (float) $amount) {
            return false;
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $this->update($fromWalletId, [
                'saldo' => (float) $fromWallet['saldo'] - (float) $amount
            ]);

            $this->update($toWalletId, [
                'saldo' => (float) $toWallet['saldo'] + (float) $amount
            ]);

            $now = date('Y-m-d H:i:s');

            $transferTable = $db->table('transfer');
            $transferTable->insert([
                'from_wallet_id' => $fromWalletId,
                'to_wallet_id' => $toWalletId,
                'amount' => $amount,
                'note' => $note ?? 'Transfer Dana',
                'created_at' => $now,
            ]);

            $transferId = $db->insertID();

            $db->transCommit();
            return true;

        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }
}