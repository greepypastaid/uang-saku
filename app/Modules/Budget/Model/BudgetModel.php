<?php

namespace App\Modules\Budget\Model;

use CodeIgniter\Model;

class BudgetModel extends Model
{
    protected $table = "budgets";
    protected $primaryKey = "id";
    protected $returnType = "array";
    protected $allowedFields = ['user_id', 'category', 'amount', 'month', 'year'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'user_id' => 'required|integer',
        'category' => 'required|max_length[100]',
        'amount' => 'required|decimal',
        'month' => 'required|integer|greater_than[0]|less_than[13]',
        'year' => 'required|integer|min_length[4]',
    ];

    protected $validationMessages = [
        'category' => [
            'required' => 'Kategori harus diisi',
        ],
        'amount' => [
            'required' => 'Jumlah budget harus diisi',
            'decimal' => 'Jumlah budget harus berupa angka',
        ],
        'month' => [
            'required' => 'Bulan harus diisi',
            'greater_than' => 'Bulan harus antara 1-12',
            'less_than' => 'Bulan harus antara 1-12',
        ],
        'year' => [
            'required' => 'Tahun harus diisi',
        ],
    ];

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getBudgetsByUser($userId, $month = null, $year = null)
    {
        $builder = $this->db->table($this->table);
        $builder->where('user_id', $userId);
        
        if ($month !== null) {
            $builder->where('month', $month);
        }
        
        if ($year !== null) {
            $builder->where('year', $year);
        }
        
        $builder->orderBy('year', 'DESC');
        $builder->orderBy('month', 'DESC');
        $builder->orderBy('category', 'ASC');
        
        return $builder->get()->getResultArray();
    }

    public function deleteBudget($id, $userId)
    {
        return $this->where('id', $id)
                    ->where('user_id', $userId)
                    ->delete();
    }

    public function updateBudget($id, $userId, array $data)
    {
        return $this->where('id', $id)
                    ->where('user_id', $userId)
                    ->update(null, $data);
    }
}
