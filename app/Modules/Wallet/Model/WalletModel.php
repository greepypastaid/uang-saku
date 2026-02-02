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

    protected $validationRules = [
        'nama' => 'required',
        'saldo' => 'permit_empty|numeric',
    ];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function createWallet(array $data)
    {
        $now = date('Y-m-d H:i:s');
        $sql = "INSERT INTO {$this->table} (nama, saldo, created_at, updated_at, note) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $data['nama'] ?? null,
            $data['saldo'] ?? 0,
            $data['created_at'] ?? $now,
            $data['updated_at'] ?? $now,
            $data['note'] ?? null,
        ];
        $this->db->query($sql, $params);
        return (int) $this->db->insertID();
    }

    public function getAllWallets(): array
    {
        $query = $this->db->query("SELECT * FROM {$this->table} ORDER BY id DESC");
        return $query->getResultArray();
    }

    public function getWalletById($id): ?array
    {
        $query = $this->db->query("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1", [$id]);
        $row = $query->getRowArray();
        return $row ?: null;
    }

    public function updateWallet($id, array $data)
    {
        $sets = [];
        $params = [];

        foreach ($data as $k => $v) {
            if (in_array($k, $this->allowedFields, true)) {
                $sets[] = "`$k` = ?";
                $params[] = $v;
            }
        }

        if ($this->useTimestamps && !in_array($this->updatedField, array_keys($data), true)) {
            $sets[] = "`{$this->updatedField}` = ?";
            $params[] = date('Y-m-d H:i:s');
        }

        if (empty($sets)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = ?";
        $res = $this->db->query($sql, $params);

        return $res !== false;
    }

    public function deleteWallet($id)
    {
        $res = $this->db->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
        return $res !== false;
    }

    public function getTotalSaldo(): float
    {
        $query = $this->db->query("SELECT SUM(saldo) AS total FROM {$this->table}");
        $row = $query->getRowArray();
        return (float) ($row['total'] ?? 0);
    }

    public function transferFunds($fromWalletId, $toWalletId, $amount, $note = null)
    {
        $db = $this->db;
        $db->transBegin();

        try {
            // Lock and fetch balances
            $fromRow = $db->query("SELECT saldo FROM {$this->table} WHERE id = ? LIMIT 1", [$fromWalletId])->getRowArray();
            $toRow = $db->query("SELECT saldo FROM {$this->table} WHERE id = ? LIMIT 1", [$toWalletId])->getRowArray();

            if (!$fromRow || !$toRow) {
                $db->transRollback();
                return false;
            }

            $fromSaldo = (float) $fromRow['saldo'];
            $toSaldo = (float) $toRow['saldo'];

            if ($fromSaldo < (float) $amount) {
                $db->transRollback();
                return false;
            }

            $newFrom = $fromSaldo - (float) $amount;
            $newTo = $toSaldo + (float) $amount;

            $now = date('Y-m-d H:i:s');

            // update balances
            $res1 = $db->query("UPDATE {$this->table} SET saldo = ?, updated_at = ? WHERE id = ?", [$newFrom, $now, $fromWalletId]);
            $res2 = $db->query("UPDATE {$this->table} SET saldo = ?, updated_at = ? WHERE id = ?", [$newTo, $now, $toWalletId]);

            if ($res1 === false || $res2 === false) {
                $db->transRollback();
                return false;
            }

            // insert transfer record
            $sql = "INSERT INTO transfer (from_wallet_id, to_wallet_id, amount, note, created_at) VALUES (?, ?, ?, ?, ?)";
            $db->query($sql, [$fromWalletId, $toWalletId, $amount, $note ?? 'Transfer Dana', $now]);

            $db->transCommit();
            return true;
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', $e->getMessage());
            return false;
        }
    }
}