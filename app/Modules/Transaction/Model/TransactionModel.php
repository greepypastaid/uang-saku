<?php 

namespace App\Modules\Transaction\Model;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = "transaksi";
    protected $primaryKey = "id";
    protected $returnType = "array";
    protected $allowedFields = ['tanggal', 'nama_transaksi', 'harga', 'kategori'];
    protected $useTimestamps = false;
    protected $validationRules = [
        'tanggal'        => 'required',
        'nama_transaksi' => 'required',
        'harga'          => 'required|numeric',
        'kategori'       => 'required',
    ];

    public function createTransaction(array $data)
    {
        return $this->insert($data);
    }

    public function getAllTransactions(): array
    {
        return $this->findAll(); // curiga sesat nih kalo gede, malas ah kosek ae
    }

    public function getTransactionById($id): ?array
    {
        return $this->find($id);
    }

    public function updateTransaction($id, array $data)
    {
        return $this->update($id, $data);
    }

    public function deleteTransaction($id)
    {
        return $this->delete($id);
    }
    }