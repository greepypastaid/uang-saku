<?php

namespace App\Modules\Wallet\Model;

use CodeIgniter\Model;

class WalletModel extends Model
{
    protected $table = 'wallets';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama', 'saldo'];

    // buat ini cok bagian timestamps katanya biar otomatis
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
}
