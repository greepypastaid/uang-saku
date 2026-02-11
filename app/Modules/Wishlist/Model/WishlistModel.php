<?php

namespace App\Modules\Wishlist\Model;

use CodeIgniter\Model;

class WishlistModel extends Model
{
    protected $table = "wishlist_items";
    protected $primaryKey = "id";
    protected $returnType = "array";
    protected $allowedFields = [
        'user_id', 'goal_id', 'name', 'price', 'category',
        'item_type', 'urgency_level', 'priority_score', 'work_hours_cost',
        'status', 'image_url', 'note', 'purchased_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'user_id'       => 'required|integer',
        'name'          => 'required|min_length[2]|max_length[100]',
        'price'         => 'required|numeric|greater_than[0]',
        'item_type'     => 'permit_empty|in_list[need,want]',
        'urgency_level' => 'permit_empty|in_list[low,medium,high,urgent]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama item harus diisi.',
            'min_length' => 'Nama item minimal 2 karakter.',
        ],
        'price' => [
            'required'     => 'Harga harus diisi.',
            'greater_than' => 'Harga harus lebih dari 0.',
        ],
    ];

    /**
     * Cached work settings per user (avoid repeated queries in loops)
     */
    private $workSettingsCache = [];

    /**
     * Get all wishlist items for a user with linked goal info
     */
    public function getItemsByUser($userId, $type = null)
    {
        $builder = $this->db->table('wishlist_items wi')
            ->select('wi.*, sg.name as goal_name, sg.current_amount as goal_current, sg.target_amount as goal_target, sg.status as goal_status')
            ->join('saving_goals sg', 'sg.id = wi.goal_id', 'left')
            ->where('wi.user_id', $userId);

        if ($type) {
            $builder->where('wi.item_type', $type);
        }

        return $builder->orderBy('wi.priority_score', 'DESC')
            ->orderBy('wi.created_at', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Calculate Priority Score for an item
     */
    public function calculatePriorityScore($item)
    {
        $userId = $item['user_id'] ?? auth()->id();

        // Factor 1: Item Type (30%)
        $typeScore = ($item['item_type'] === 'need') ? 100 : 30;

        // Factor 2: Urgency Level (25%)
        $urgencyMap = ['urgent' => 100, 'high' => 75, 'medium' => 50, 'low' => 25];
        $urgencyScore = $urgencyMap[$item['urgency_level']] ?? 50;

        // Factor 3: Affordability (25%) — based on total wallet balance
        $balanceResult = $this->db->table('wallets')
            ->selectSum('saldo')
            ->where('user_id', $userId)
            ->get()->getRowArray();
        $totalSaldo = (float) ($balanceResult['saldo'] ?? 0);
        $price = (float) $item['price'];
        $affordabilityScore = ($price > 0) ? min(100, ($totalSaldo / $price) * 100) : 100;

        // Factor 4: Waiting Time (20%) — days since created
        $createdAt = $item['created_at'] ?? date('Y-m-d H:i:s');
        $daysSinceCreated = max(0, (time() - strtotime($createdAt)) / 86400);
        $waitingScore = min(100, $daysSinceCreated * 2);

        $score = ($typeScore * 0.30) + ($urgencyScore * 0.25) + ($affordabilityScore * 0.25) + ($waitingScore * 0.20);

        return round(min(100, $score), 2);
    }

    /**
     * Calculate Work Hours Cost for an item
     */
    public function calculateWorkHoursCost($userId, $price)
    {
        // Use cached settings to avoid repeated queries
        $settings = $this->getCachedWorkSettings($userId);

        $workingDays = (int) ($settings['working_days_per_month'] ?? 22);
        $workingHours = (int) ($settings['working_hours_per_day'] ?? 8);
        $customIncome = $settings ? (float) ($settings['custom_monthly_income'] ?? 0) : 0;

        if ($customIncome > 0) {
            $monthlyIncome = $customIncome;
        } else {
            // Calculate average monthly income from last 3 months
            $threeMonthsAgo = date('Y-m-d', strtotime('-3 months'));
            $incomeResult = $this->db->table('transaksi')
                ->selectSum('harga')
                ->where('user_id', $userId)
                ->where('type', 'income')
                ->where('tanggal >=', $threeMonthsAgo)
                ->get()->getRowArray();
            $totalIncome3Months = (float) ($incomeResult['harga'] ?? 0);
            $monthlyIncome = $totalIncome3Months / 3;
        }

        if ($monthlyIncome <= 0) {
            return ['hours' => null, 'days' => null, 'hourly_rate' => 0, 'monthly_income' => 0];
        }

        $hourlyRate = $monthlyIncome / ($workingDays * $workingHours);
        $workHours = (float) $price / $hourlyRate;
        $workDays = $workHours / $workingHours;

        return [
            'hours'          => round($workHours, 1),
            'days'           => round($workDays, 1),
            'hourly_rate'    => round($hourlyRate, 0),
            'monthly_income' => round($monthlyIncome, 0),
        ];
    }

    /**
     * Check and update "Ready to Buy" status using JOIN (no N+1)
     */
    public function updateReadyToBuyStatus($userId)
    {
        // Single query with JOIN instead of loop + individual queries
        $items = $this->db->table('wishlist_items wi')
            ->select('wi.id, wi.price, sg.current_amount as goal_current')
            ->join('saving_goals sg', 'sg.id = wi.goal_id')
            ->where('wi.user_id', $userId)
            ->whereIn('wi.status', ['pending', 'saving'])
            ->where('wi.goal_id IS NOT NULL')
            ->get()->getResultArray();

        $updated = 0;
        $idsToUpdate = [];

        foreach ($items as $item) {
            if ((float) $item['goal_current'] >= (float) $item['price']) {
                $idsToUpdate[] = $item['id'];
                $updated++;
            }
        }

        // Batch update instead of individual updates
        if (!empty($idsToUpdate)) {
            $this->db->table('wishlist_items')
                ->whereIn('id', $idsToUpdate)
                ->update(['status' => 'ready_to_buy', 'updated_at' => date('Y-m-d H:i:s')]);
        }

        return $updated;
    }

    /**
     * Get or create user work settings
     */
    public function getUserWorkSettings($userId)
    {
        $settings = $this->db->table('user_work_settings')
            ->where('user_id', $userId)
            ->get()->getRowArray();

        if (!$settings) {
            $this->db->table('user_work_settings')->insert([
                'user_id'                => $userId,
                'working_days_per_month' => 22,
                'working_hours_per_day'  => 8,
                'created_at'             => date('Y-m-d H:i:s'),
            ]);
            $settings = [
                'working_days_per_month' => 22,
                'working_hours_per_day'  => 8,
                'custom_monthly_income'  => null,
            ];
        }

        // Cache it
        $this->workSettingsCache[$userId] = $settings;

        return $settings;
    }

    /**
     * Upsert user work settings
     */
    public function upsertWorkSettings($userId, $data)
    {
        $settingsData = [
            'working_days_per_month' => (int) ($data['working_days_per_month'] ?? 22),
            'working_hours_per_day'  => (int) ($data['working_hours_per_day'] ?? 8),
            'custom_monthly_income'  => ($data['custom_monthly_income'] ?? '') ?: null,
            'updated_at'             => date('Y-m-d H:i:s'),
        ];

        $existing = $this->db->table('user_work_settings')->where('user_id', $userId)->get()->getRowArray();
        if ($existing) {
            $this->db->table('user_work_settings')->where('user_id', $userId)->update($settingsData);
        } else {
            $settingsData['user_id'] = $userId;
            $settingsData['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('user_work_settings')->insert($settingsData);
        }

        // Clear cache
        unset($this->workSettingsCache[$userId]);
    }

    /**
     * Get active saving goals for a user (for linking)
     */
    public function getActiveSavingGoals($userId)
    {
        return $this->db->table('saving_goals')
            ->where('status', 'active')
            ->groupStart()
                ->where('user_id', $userId)
                ->orWhere('partner_id', $userId)
            ->groupEnd()
            ->get()->getResultArray();
    }

    /**
     * Cached work settings getter (avoids repeated queries in loops)
     */
    private function getCachedWorkSettings($userId)
    {
        if (!isset($this->workSettingsCache[$userId])) {
            $this->workSettingsCache[$userId] = $this->db->table('user_work_settings')
                ->where('user_id', $userId)
                ->get()->getRowArray() ?: [
                    'working_days_per_month' => 22,
                    'working_hours_per_day'  => 8,
                    'custom_monthly_income'  => null,
                ];
        }
        return $this->workSettingsCache[$userId];
    }
}
