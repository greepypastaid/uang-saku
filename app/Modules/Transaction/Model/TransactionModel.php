<?php

namespace App\Modules\Transaction\Model;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = "transaksi";
    protected $primaryKey = "id";
    protected $returnType = "array";
    protected $allowedFields = ['tanggal', 'nama_transaksi', 'harga', 'kategori', 'wallet_id', 'type'];
    protected $useTimestamps = false;
    protected $validationRules = [
        'tanggal' => 'required',
        'nama_transaksi' => 'required',
        'harga' => 'required|numeric',
        'kategori' => 'required',
        'wallet_id' => 'permit_empty|integer',
        'type' => 'required|in_list[income,expense]',
    ];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function createTransaction(array $data)
    {
        $sql = "INSERT INTO {$this->table} (tanggal, nama_transaksi, harga, kategori, wallet_id, `type`) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $data['tanggal'] ?? null,
            $data['nama_transaksi'] ?? null,
            $data['harga'] ?? 0,
            $data['kategori'] ?? null,
            $data['wallet_id'] ?? null,
            $data['type'] ?? null,
        ];
        $this->db->query($sql, $params);
        return (int) $this->db->insertID();
    }

    public function getAllTransactions(): array
    {
        $query = $this->db->query("SELECT * FROM {$this->table} ORDER BY tanggal DESC, id DESC");
        return $query->getResultArray();
    }

    public function getTransactionById($id): ?array
    {
        $query = $this->db->query("SELECT * FROM {$this->table} WHERE id = ? LIMIT 1", [$id]);
        $row = $query->getRowArray();
        return $row ?: null;
    }

    public function updateTransaction($id, array $data)
    {
        $sets = [];
        $params = [];

        foreach ($data as $k => $v) {
            if (in_array($k, $this->allowedFields, true)) {
                $sets[] = "`$k` = ?";
                $params[] = $v;
            }
        }

        if (empty($sets)) {
            return false;
        }

        $params[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = ?";
        $res = $this->db->query($sql, $params);

        return $res !== false;
    }

    public function deleteTransaction($id)
    {
        $res = $this->db->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
        return $res !== false;
    }

    public function getTotalExpense(): float
    {
        $query = $this->db->query("SELECT SUM(harga) AS total FROM {$this->table} WHERE `type` = ?", ['expense']);
        $row = $query->getRowArray();
        return (float) ($row['total'] ?? 0);
    }

    public function getTotalIncome(): float
    {
        $query = $this->db->query("SELECT SUM(harga) AS total FROM {$this->table} WHERE `type` = ?", ['income']);
        $row = $query->getRowArray();
        return (float) ($row['total'] ?? 0);
    }
}