<?php

namespace App\Modules\Budget\Controller;

use App\Controllers\BaseController;
use App\Modules\Budget\Model\BudgetModel;

class BudgetController extends BaseController
{
    protected $budgetModel;

    public function __construct()
    {
        $this->budgetModel = new BudgetModel();
    }

    public function index(): string
    {
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        
        return view('../Modules/Budget/View/budget', [
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }

    public function list()
    {
        $req = $this->request;
        $draw = (int) ($req->getGet('draw') ?? 0);
        $start = (int) ($req->getGet('start') ?? 0);
        $length = (int) ($req->getGet('length') ?? 10);
        $searchValue = $req->getGet('search')['value'] ?? null;
        
        $userId = auth()->id();
        $month = (int) ($req->getGet('month') ?? date('n'));
        $year = (int) ($req->getGet('year') ?? date('Y'));

        // Get budgets
        $builder = $this->budgetModel->builder();
        $builder->where('user_id', $userId);
        $builder->where('month', $month);
        $builder->where('year', $year);
        
        $recordsTotal = $builder->countAllResults(false);
        
        // Apply search filter
        if (!empty($searchValue)) {
            $builder->like('category', $searchValue);
        }
        
        $recordsFiltered = $builder->countAllResults(false);
        
        // Apply pagination
        $budgets = $builder->orderBy('category', 'ASC')
                          ->limit($length, $start)
                          ->get()
                          ->getResultArray();

        // Format data for DataTable
        $data = [];
        foreach ($budgets as $budget) {
            $data[] = [
                'id' => $budget['id'],
                'category' => $budget['category'],
                'amount' => number_format($budget['amount'], 0, ',', '.'),
                'month' => $budget['month'],
                'year' => $budget['year'],
            ];
        }

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $budgetData = [
            'user_id' => $userId,
            'category' => $data['category'] ?? null,
            'amount' => $data['amount'] ?? null,
            'month' => $data['month'] ?? null,
            'year' => $data['year'] ?? null,
        ];

        if (!$this->budgetModel->validate($budgetData)) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'Validasi gagal.', 
                'errors' => $this->budgetModel->errors()
            ]);
        }

        // Check if budget already exists
        $existing = $this->budgetModel
            ->where('user_id', $userId)
            ->where('category', $budgetData['category'])
            ->where('month', $budgetData['month'])
            ->where('year', $budgetData['year'])
            ->first();

        if ($existing) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'Budget untuk kategori ini di bulan yang sama sudah ada.'
            ]);
        }

        $insertId = $this->budgetModel->insert($budgetData);

        if ($insertId) {
            $budgetData['id'] = $insertId;
            return $this->response->setJSON([
                'status' => true, 
                'message' => 'Budget berhasil dibuat.', 
                'data' => $budgetData
            ]);
        }

        return $this->response->setJSON([
            'status' => false, 
            'message' => 'Gagal membuat budget.'
        ]);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'ID budget tidak valid.'
            ]);
        }

        $data = $this->request->getPost();
        $userId = auth()->id();

        $budgetData = [
            'category' => $data['category'] ?? null,
            'amount' => $data['amount'] ?? null,
            'month' => $data['month'] ?? null,
            'year' => $data['year'] ?? null,
        ];

        // Validate data
        if (!$this->budgetModel->validate($budgetData)) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'Validasi gagal.', 
                'errors' => $this->budgetModel->errors()
            ]);
        }

        // Check if budget exists and belongs to user
        $existing = $this->budgetModel
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$existing) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'Budget tidak ditemukan.'
            ]);
        }

        // Check duplicate (different id, same category/month/year)
        $duplicate = $this->budgetModel
            ->where('user_id', $userId)
            ->where('category', $budgetData['category'])
            ->where('month', $budgetData['month'])
            ->where('year', $budgetData['year'])
            ->where('id !=', $id)
            ->first();

        if ($duplicate) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'Budget untuk kategori ini di bulan yang sama sudah ada.'
            ]);
        }

        $success = $this->budgetModel->updateBudget($id, $userId, $budgetData);

        if ($success) {
            return $this->response->setJSON([
                'status' => true, 
                'message' => 'Budget berhasil diupdate.'
            ]);
        }

        return $this->response->setJSON([
            'status' => false, 
            'message' => 'Gagal mengupdate budget.'
        ]);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setJSON([
                'status' => false, 
                'message' => 'ID budget tidak valid.'
            ]);
        }

        $userId = auth()->id();
        $success = $this->budgetModel->deleteBudget($id, $userId);

        if ($success) {
            return $this->response->setJSON([
                'status' => true, 
                'message' => 'Budget berhasil dihapus.'
            ]);
        }

        return $this->response->setJSON([
            'status' => false, 
            'message' => 'Gagal menghapus budget.'
        ]);
    }

    public function getBudgetInfo()
    {
        $userId = auth()->id();
        $category = $this->request->getGet('category');
        $date = $this->request->getGet('date') ?? date('Y-m-d');
        
        if (!$category) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Kategori harus diisi'
            ]);
        }

        $dateObj = new \DateTime($date);
        $month = (int) $dateObj->format('n');
        $year = (int) $dateObj->format('Y');

        // Get budget for this category
        $budget = $this->budgetModel
            ->where('user_id', $userId)
            ->where('category', $category)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if (!$budget) {
            return $this->response->setJSON([
                'status' => true,
                'has_budget' => false,
                'message' => 'Tidak ada budget limit untuk kategori ini'
            ]);
        }

        // Calculate current spending
        $db = \Config\Database::connect();
        $builder = $db->table('transaksi');
        $builder->select('SUM(harga) as total_spent');
        $builder->where('user_id', $userId);
        $builder->where('kategori', $category);
        $builder->where('type', 'expense');
        $builder->where('MONTH(tanggal)', $month);
        $builder->where('YEAR(tanggal)', $year);
        
        $result = $builder->get()->getRowArray();
        $currentSpent = (float) ($result['total_spent'] ?? 0);
        
        $budgetLimit = (float) $budget['amount'];
        $remaining = $budgetLimit - $currentSpent;
        $percentage = $budgetLimit > 0 ? round(($currentSpent / $budgetLimit) * 100, 2) : 0;

        return $this->response->setJSON([
            'status' => true,
            'has_budget' => true,
            'data' => [
                'budget_limit' => $budgetLimit,
                'current_spent' => $currentSpent,
                'remaining' => $remaining,
                'percentage' => $percentage,
                'formatted' => [
                    'budget_limit' => number_format($budgetLimit, 0, ',', '.'),
                    'current_spent' => number_format($currentSpent, 0, ',', '.'),
                    'remaining' => number_format($remaining, 0, ',', '.'),
                ]
            ]
        ]);
    }
}
