<?php

namespace App\Modules\Transaction\Controller;
use Config\Database;

use App\Controllers\BaseController;

class TransactionController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function index(): string
    {
        return view('../Modules/Transaction/View/transaction');
    }

    public function create()
    {
        $data = $this->request->getPost();

        $arrayTransaksi = [
            'tanggal' => $data['tanggal'],
            'nama_transaksi' => $data['nama_transaksi'],
            'harga' => $data['harga'],
            'kategori' => $data['kategori'],
        ];

        // data dimasukkan ke db
        $insert = $this->db->table('transaksi')->insert($arrayTransaksi);
        if ($insert) {
            return $this->response->setJSON(['status' => true, 'message' => 'Data transaksi berhasil disimpan.', 'data' => $arrayTransaksi]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal menyimpan data transaksi.']);
    }

    public function list() {
        $transaksi = $this->db->table('transaksi')->get()->getResultArray();

        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }
}
