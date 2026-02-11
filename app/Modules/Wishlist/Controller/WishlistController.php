<?php

namespace App\Modules\Wishlist\Controller;

use App\Controllers\BaseController;
use App\Modules\Wishlist\Model\WishlistModel;

class WishlistController extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new WishlistModel();
    }

    public function index(): string
    {
        $userId = auth()->id();

        // Check & update ready_to_buy statuses (now uses JOIN, no N+1)
        $this->model->updateReadyToBuyStatus($userId);

        $items = $this->model->getItemsByUser($userId);

        // Attach work hours cost to each item
        foreach ($items as &$item) {
            $item['work_cost'] = $this->model->calculateWorkHoursCost($userId, $item['price']);
        }

        // Get active saving goals via model (no raw DB in controller)
        $goals = $this->model->getActiveSavingGoals($userId);
        $workSettings = $this->model->getUserWorkSettings($userId);

        $needs = array_filter($items, fn($i) => $i['item_type'] === 'need');
        $wants = array_filter($items, fn($i) => $i['item_type'] === 'want');

        return view('../Modules/Wishlist/View/wishlist', [
            'items'        => $items,
            'needs'        => $needs,
            'wants'        => $wants,
            'goals'        => $goals,
            'workSettings' => $workSettings,
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $itemData = [
            'user_id'       => $userId,
            'name'          => $data['name'] ?? null,
            'price'         => $data['price'] ?? null,
            'category'      => $data['category'] ?? null,
            'item_type'     => $data['item_type'] ?? 'want',
            'urgency_level' => $data['urgency_level'] ?? 'medium',
            'goal_id'       => !empty($data['goal_id']) ? $data['goal_id'] : null,
            'note'          => $data['note'] ?? null,
            'status'        => !empty($data['goal_id']) ? 'saving' : 'pending',
        ];

        // Use model validation
        if (!$this->model->validate($itemData)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $this->model->errors(),
            ]);
        }

        // Calculate priority score & work hours cost
        $itemData['priority_score'] = $this->model->calculatePriorityScore($itemData);
        $whc = $this->model->calculateWorkHoursCost($userId, $itemData['price']);
        $itemData['work_hours_cost'] = $whc['hours'];

        $insertId = $this->model->insert($itemData);

        if ($insertId) {
            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Item berhasil ditambahkan!',
                'data'    => ['id' => $insertId, 'work_cost' => $whc],
            ]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menambahkan item.']);
    }

    public function update($id = null)
    {
        if (!$id) return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);

        $userId = auth()->id();
        $existing = $this->model->where('id', $id)->where('user_id', $userId)->first();
        if (!$existing) return $this->response->setJSON(['status' => false, 'message' => 'Item tidak ditemukan.']);

        $data = $this->request->getPost();
        $updateData = [];
        if (isset($data['name'])) $updateData['name'] = $data['name'];
        if (isset($data['price'])) $updateData['price'] = $data['price'];
        if (isset($data['category'])) $updateData['category'] = $data['category'];
        if (isset($data['item_type'])) $updateData['item_type'] = $data['item_type'];
        if (isset($data['urgency_level'])) $updateData['urgency_level'] = $data['urgency_level'];
        if (isset($data['goal_id'])) $updateData['goal_id'] = $data['goal_id'] ?: null;
        if (isset($data['note'])) $updateData['note'] = $data['note'];
        if (isset($data['status'])) $updateData['status'] = $data['status'];

        // Recalculate scores
        $merged = array_merge($existing, $updateData);
        $updateData['priority_score'] = $this->model->calculatePriorityScore($merged);
        $whc = $this->model->calculateWorkHoursCost($userId, $merged['price']);
        $updateData['work_hours_cost'] = $whc['hours'];

        $this->model->update($id, $updateData);
        return $this->response->setJSON(['status' => true, 'message' => 'Item berhasil diupdate.']);
    }

    public function delete($id = null)
    {
        if (!$id) return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);

        $userId = auth()->id();
        $existing = $this->model->where('id', $id)->where('user_id', $userId)->first();
        if (!$existing) return $this->response->setJSON(['status' => false, 'message' => 'Item tidak ditemukan.']);

        $this->model->delete($id);
        return $this->response->setJSON(['status' => true, 'message' => 'Item berhasil dihapus.']);
    }

    public function markPurchased($id = null)
    {
        if (!$id) return $this->response->setJSON(['status' => false, 'message' => 'ID tidak valid.']);

        $userId = auth()->id();
        $existing = $this->model->where('id', $id)->where('user_id', $userId)->first();
        if (!$existing) return $this->response->setJSON(['status' => false, 'message' => 'Item tidak ditemukan.']);

        $this->model->update($id, [
            'status'       => 'purchased',
            'purchased_at' => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON(['status' => true, 'message' => 'Item ditandai sudah dibeli! 🎉']);
    }

    public function saveWorkSettings()
    {
        $data = $this->request->getPost();
        $userId = auth()->id();

        $this->model->upsertWorkSettings($userId, $data);

        return $this->response->setJSON(['status' => true, 'message' => 'Pengaturan kerja berhasil disimpan.']);
    }
}
