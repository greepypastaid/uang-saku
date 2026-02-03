<?php

namespace App\Modules\Hutangpiutang\Models;

use CodeIgniter\Model;

class HutangPiutangModel extends Model
{
    protected $table = 'hutangpiutang';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id', 'wallet_id', 'type', 'person_name', 'amount', 
        'description', 'due_date', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    // sementara pake ini dulu deh anjay 
    public function getHutangPiutangByUser($userId) {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }
}