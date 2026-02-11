<?php

namespace App\Modules\SavingGoal\Model;

use CodeIgniter\Model;

class SavingGoalModel extends Model
{
    protected $table = "saving_goals";
    protected $primaryKey = "id";
    protected $returnType = "array";
    protected $allowedFields = [
        'user_id', 'partner_id', 'ownership_type', 'name',
        'target_amount', 'current_amount', 'icon', 'priority',
        'deadline', 'status', 'completed_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id'        => 'required|integer',
        'name'           => 'required|min_length[2]|max_length[100]',
        'target_amount'  => 'required|numeric|greater_than[0]',
        'priority'       => 'permit_empty|integer|in_list[1,2,3,4,5]',
        'ownership_type' => 'permit_empty|in_list[individual,couple]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama goal harus diisi.',
            'min_length' => 'Nama goal minimal 2 karakter.',
        ],
        'target_amount' => [
            'required'     => 'Target amount harus diisi.',
            'greater_than' => 'Target amount harus lebih dari 0.',
        ],
    ];

    /**
     * Get all goals for a user (including couple goals where user is partner)
     */
    public function getGoalsByUser($userId)
    {
        return $this->db->table($this->table)
            ->groupStart()
                ->where('user_id', $userId)
                ->orWhere('partner_id', $userId)
            ->groupEnd()
            ->orderBy('priority', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Calculate metrics for a single goal
     */
    public function calculateMetrics($goal)
    {
        $targetAmount = (float) $goal['target_amount'];
        $currentAmount = (float) $goal['current_amount'];

        $remainingAmount = max(0, $targetAmount - $currentAmount);
        $progressPercentage = $targetAmount > 0 ? round(($currentAmount / $targetAmount) * 100, 2) : 0;

        $avgMonthlySaving = $goal['_avg_contrib_3m'] ?? $this->getAvgContrib3m($goal['id']);

        $estimatedMonths = ($avgMonthlySaving > 0) ? ceil($remainingAmount / $avgMonthlySaving) : null;
        $estimatedDate = $estimatedMonths ? date('Y-m-d', strtotime("+{$estimatedMonths} months")) : null;

        return [
            'remaining_amount'          => $remainingAmount,
            'progress_percentage'       => min(100, $progressPercentage),
            'avg_monthly_saving'        => round($avgMonthlySaving, 2),
            'estimated_months'          => $estimatedMonths,
            'estimated_completion_date' => $estimatedDate,
        ];
    }

    /**
     * Batch-calculate metrics for multiple goals (avoids N+1 queries)
     */
    public function calculateMetricsBatch(array &$goals)
    {
        if (empty($goals)) return;

        $goalIds = array_column($goals, 'id');
        $threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));

        // Single query: sum contributions per goal in last 3 months
        $rows = $this->db->table('saving_contributions')
            ->select('goal_id, SUM(amount) as total')
            ->whereIn('goal_id', $goalIds)
            ->where('created_at >=', $threeMonthsAgo)
            ->groupBy('goal_id')
            ->get()->getResultArray();

        $contribMap = [];
        foreach ($rows as $row) {
            $contribMap[$row['goal_id']] = (float) $row['total'] / 3;
        }

        foreach ($goals as &$goal) {
            $goal['_avg_contrib_3m'] = $contribMap[$goal['id']] ?? 0;
            $goal['metrics'] = $this->calculateMetrics($goal);
            unset($goal['_avg_contrib_3m']);
        }
    }

    /**
     * Get average 3-month contribution for a single goal (fallback)
     */
    private function getAvgContrib3m($goalId): float
    {
        $threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
        $row = $this->db->table('saving_contributions')
            ->selectSum('amount')
            ->where('goal_id', $goalId)
            ->where('created_at >=', $threeMonthsAgo)
            ->get()->getRowArray();

        return ((float) ($row['amount'] ?? 0)) / 3;
    }

    /**
     * Add a contribution to a goal (and optionally deduct wallet)
     */
    public function addContribution($goalId, $userId, $amount, $walletId = null, $source = 'manual', $note = null)
    {
        $this->db->table('saving_contributions')->insert([
            'goal_id'    => $goalId,
            'user_id'    => $userId,
            'wallet_id'  => $walletId,
            'amount'     => $amount,
            'source'     => $source,
            'note'       => $note,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Deduct from wallet if specified
        if ($walletId) {
            $wallet = $this->db->table('wallets')->where('id', $walletId)->get()->getRowArray();
            if ($wallet) {
                $newSaldo = (float) $wallet['saldo'] - (float) $amount;
                $this->db->table('wallets')->where('id', $walletId)->update(['saldo' => $newSaldo]);
            }
        }

        // Update current_amount on the goal
        $goal = $this->find($goalId);
        $newAmount = (float) $goal['current_amount'] + (float) $amount;
        $updateData = ['current_amount' => $newAmount];

        // Auto-complete if target reached
        if ($newAmount >= (float) $goal['target_amount']) {
            $updateData['status'] = 'completed';
            $updateData['completed_at'] = date('Y-m-d H:i:s');
        }

        $this->update($goalId, $updateData);

        return true;
    }

    /**
     * Get contributions for a goal
     */
    public function getContributions($goalId)
    {
        return $this->db->table('saving_contributions sc')
            ->select('sc.*, u.username as contributor_name')
            ->join('users u', 'u.id = sc.user_id', 'left')
            ->where('sc.goal_id', $goalId)
            ->orderBy('sc.created_at', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Get wallets for a user
     */
    public function getWalletsByUser($userId)
    {
        return $this->db->table('wallets')
            ->where('user_id', $userId)
            ->get()->getResultArray();
    }

    /**
     * Run auto-allocation for a user
     */
    public function runAutoAllocation($userId)
    {
        $month = (int) date('n');
        $year = (int) date('Y');

        $incomeResult = $this->db->table('transaksi')
            ->selectSum('harga')
            ->where('user_id', $userId)
            ->where('type', 'income')
            ->where('MONTH(tanggal)', $month)
            ->where('YEAR(tanggal)', $year)
            ->get()->getRowArray();
        $totalIncome = (float) ($incomeResult['harga'] ?? 0);

        $expenseResult = $this->db->table('transaksi')
            ->selectSum('harga')
            ->where('user_id', $userId)
            ->where('type', 'expense')
            ->where('MONTH(tanggal)', $month)
            ->where('YEAR(tanggal)', $year)
            ->get()->getRowArray();
        $totalExpense = (float) ($expenseResult['harga'] ?? 0);

        $sisaBudget = $totalIncome - $totalExpense;
        if ($sisaBudget <= 0) return ['allocated' => 0, 'details' => []];

        // Get active auto-allocation rules, ordered by goal priority
        $rules = $this->db->table('saving_auto_rules sar')
            ->select('sar.*, sg.priority, sg.target_amount, sg.current_amount, sg.name as goal_name')
            ->join('saving_goals sg', 'sg.id = sar.goal_id')
            ->where('sar.user_id', $userId)
            ->where('sar.is_active', 1)
            ->where('sg.status', 'active')
            ->orderBy('sg.priority', 'DESC')
            ->get()->getResultArray();

        $totalAllocated = 0;
        $details = [];

        foreach ($rules as $rule) {
            if ($sisaBudget <= 0) break;

            $remaining = (float) $rule['target_amount'] - (float) $rule['current_amount'];
            if ($remaining <= 0) continue;

            if ($rule['allocation_type'] === 'percentage') {
                $alokasi = $sisaBudget * ((float) $rule['allocation_value'] / 100);
            } else {
                $alokasi = min((float) $rule['allocation_value'], $sisaBudget);
            }

            $alokasi = min($alokasi, $remaining);
            $alokasi = round($alokasi, 2);

            if ($alokasi > 0) {
                $this->addContribution($rule['goal_id'], $userId, $alokasi, null, 'auto_allocation', 'Auto-allocation bulan ' . date('F Y'));
                $sisaBudget -= $alokasi;
                $totalAllocated += $alokasi;
                $details[] = [
                    'goal_name' => $rule['goal_name'],
                    'amount'    => $alokasi,
                ];
            }
        }

        return ['allocated' => $totalAllocated, 'details' => $details];
    }

    /**
     * Get auto-allocation rules for a user
     */
    public function getAutoRules($userId)
    {
        return $this->db->table('saving_auto_rules sar')
            ->select('sar.*, sg.name as goal_name')
            ->join('saving_goals sg', 'sg.id = sar.goal_id')
            ->where('sar.user_id', $userId)
            ->orderBy('sg.priority', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Upsert auto-allocation rule
     */
    public function upsertAutoRule($userId, $goalId, $allocationType, $allocationValue)
    {
        $existing = $this->db->table('saving_auto_rules')
            ->where('user_id', $userId)
            ->where('goal_id', $goalId)
            ->get()->getRowArray();

        if ($existing) {
            $this->db->table('saving_auto_rules')
                ->where('id', $existing['id'])
                ->update([
                    'allocation_type'  => $allocationType,
                    'allocation_value' => $allocationValue,
                    'is_active'        => 1,
                    'updated_at'       => date('Y-m-d H:i:s'),
                ]);
        } else {
            $this->db->table('saving_auto_rules')->insert([
                'user_id'          => $userId,
                'goal_id'          => $goalId,
                'allocation_type'  => $allocationType,
                'allocation_value' => $allocationValue,
                'is_active'        => 1,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
