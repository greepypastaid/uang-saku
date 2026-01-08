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
        'tanggal'        => 'required',
        'nama_transaksi' => 'required',
        'harga'          => 'required|numeric',
        'kategori'       => 'required',
        'wallet_id'      => 'permit_empty|integer',
        'type'           => 'required|in_list[income,expense]',
    ];

    public function createTransaction(array $data)
    {
        return $this->insert($data);
    }

    public function getAllTransactions(): array
    {
        return $this->findAll();
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

    public function getTotalExpense(): float
    {
    return $this->selectSum('harga')->where('type', 'expense')->get()->getRowArray()['harga'] ?? 0;
    }

    public function getTotalIncome(): float
    {
        return $this->selectSum('harga')->where('type', 'income')->get()->getRowArray()['harga'] ?? 0;
    }
}