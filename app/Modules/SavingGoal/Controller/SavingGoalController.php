<?php

namespace App\Modules\SavingGoal\Controller;

use App\Controllers\BaseController;
use App\Modules\SavingGoal\Model\SavingGoalModel;

class SavingGoalController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SavingGoalModel();
    }

    public function index(): string
    {
        $userId = auth()->id();
        $goals = $this->model->getGoalsByUser($userId);

        // Batch metrics — single query instead of N+1
        $this->model->calculateMetricsBatch($goals);

        $wallets = $this->model->getWalletsByUser($userId);

        return view('../Modules/SavingGoal/View/saving_goals', [
            'goals'   => $goals,
            'wallets' => $wallets,
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $goalData = [
            'user_id'        => $userId,
            'name'           => $data['name'] ?? null,
            'target_amount'  => $data['target_amount'] ?? null,
            'icon'           => $data['icon'] ?? '🎯',
            'priority'       => (int) ($data['priority'] ?? 1),
            'deadline'       => !empty($data['deadline']) ? $data['deadline'] : null,
            'ownership_type' => $data['ownership_type'] ?? 'individual',
            'partner_id'     => ($data['ownership_type'] ?? '') === 'couple' ? ($data['partner_id'] ?: null) : null,
        ];

        // Use model validation
        if (!$this->model->validate($goalData)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $this->model->errors(),
            ]);
        }

        // Check duplicate name
        $existing = $this->model->where('user_id', $userId)->where('name', $goalData['name'])->first();
        if ($existing) {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal dengan nama ini sudah ada.']);
        }

        $insertId = $this->model->insert($goalData);

        if ($insertId) {
            return $this->response->setJSON(['status' => true, 'message' => 'Saving goal berhasil dibuat! 🎉', 'data' => ['id' => $insertId]]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal membuat saving goal.']);
    }

    public function update($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);
        }

        $userId = auth()->id();
        $goal = $this->model->where('id', $id)->groupStart()->where('user_id', $userId)->orWhere('partner_id', $userId)->groupEnd()->first();

        if (!$goal) {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal tidak ditemukan.']);
        }

        $data = $this->request->getPost();
        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['target_amount'])) $updateData['target_amount'] = $data['target_amount'];
        if (isset($data['icon'])) $updateData['icon'] = $data['icon'];
        if (isset($data['priority'])) $updateData['priority'] = (int) $data['priority'];
        if (isset($data['deadline'])) $updateData['deadline'] = $data['deadline'] ?: null;
        if (isset($data['status'])) $updateData['status'] = $data['status'];

        $this->model->update($id, $updateData);

        return $this->response->setJSON(['status' => true, 'message' => 'Goal berhasil diupdate.']);
    }

    public function delete($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);
        }

        $userId = auth()->id();
        $goal = $this->model->where('id', $id)->where('user_id', $userId)->first();

        if (!$goal) {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal tidak ditemukan.']);
        }

        $this->model->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'Goal berhasil dihapus.']);
    }

    public function contribute($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);
        }

        $userId = auth()->id();
        $goal = $this->model->where('id', $id)->groupStart()->where('user_id', $userId)->orWhere('partner_id', $userId)->groupEnd()->first();

        if (!$goal) {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal tidak ditemukan.']);
        }

        if ($goal['status'] !== 'active') {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal sudah tidak aktif.']);
        }

        $data = $this->request->getPost();
        $amount = (float) ($data['amount'] ?? 0);
        $walletId = !empty($data['wallet_id']) ? $data['wallet_id'] : null;
        $note = $data['note'] ?? null;

        if ($amount <= 0) {
            return $this->response->setJSON(['status' => false, 'message' => 'Nominal harus lebih dari 0.']);
        }

        // Validate wallet balance if wallet selected
        if ($walletId) {
            $wallet = $this->model->db->table('wallets')->where('id', $walletId)->get()->getRowArray();
            if (!$wallet || (float) $wallet['saldo'] < $amount) {
                return $this->response->setJSON(['status' => false, 'message' => 'Saldo wallet tidak mencukupi.']);
            }
        }

        $this->model->addContribution($id, $userId, $amount, $walletId, 'manual', $note);

        // Refresh goal data
        $updatedGoal = $this->model->find($id);
        $metrics = $this->model->calculateMetrics($updatedGoal);

        $message = $updatedGoal['status'] === 'completed'
            ? 'Selamat! 🎉 Target tabunganmu sudah tercapai!'
            : 'Kontribusi berhasil ditambahkan!';

        return $this->response->setJSON([
            'status'  => true,
            'message' => $message,
            'data'    => array_merge($updatedGoal, ['metrics' => $metrics]),
        ]);
    }

    public function autoAllocate()
    {
        $userId = auth()->id();
        $result = $this->model->runAutoAllocation($userId);

        if ($result['allocated'] > 0) {
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Auto-allocation berhasil! Rp ' . number_format($result['allocated'], 0, ',', '.') . ' telah didistribusikan.',
                'data'    => $result,
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Tidak ada sisa budget untuk dialokasikan.',
            'data'    => $result,
        ]);
    }

    public function contributions($id = null)
    {
        if (!$id) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);
        }

        $userId = auth()->id();
        $goal = $this->model->where('id', $id)->groupStart()->where('user_id', $userId)->orWhere('partner_id', $userId)->groupEnd()->first();

        if (!$goal) {
            return $this->response->setJSON(['status' => false, 'message' => 'Goal tidak ditemukan.']);
        }

        $contributions = $this->model->getContributions($id);
        return $this->response->setJSON(['status' => true, 'data' => $contributions]);
    }

    public function saveAutoRule()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $goalId = $data['goal_id'] ?? null;
        $allocationType = $data['allocation_type'] ?? 'percentage';
        $allocationValue = (float) ($data['allocation_value'] ?? 0);

        if (empty($goalId) || $allocationValue <= 0) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data tidak valid.']);
        }

        $this->model->upsertAutoRule($userId, $goalId, $allocationType, $allocationValue);

        return $this->response->setJSON(['status' => true, 'message' => 'Aturan auto-allocation berhasil disimpan.']);
    }
}
