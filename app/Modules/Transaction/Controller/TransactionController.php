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
    public function list()
    {
        $transaksi = $this->db->table('transaksi')->get()->getResultArray();

        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function delete()
    {
        $data = $this->request->getPost();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $delete = $this->db->table('transaksi')->delete(['id' => $data['id']]);
        if ($delete === false) {
            return $this->response->setJSON(['status' => false, 'message' => 'Gagal menghapus data transaksi.']);
        }

        return $this->response->setJSON(['status' => true, 'message' => 'Data transaksi berhasil dihapus.']);
    }

    public function read()
    {
        $data = $this->request->getGet();
        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $transaksi = $this->db->table('transaksi')->getWhere(['id' => $data['id']])->getRowArray();
        if (empty($transaksi)) {
            return $this->response->setJSON(['status' => false, 'message' => 'Data transaksi tidak ditemukan.']);
        }

        return $this->response->setJSON(['status' => true, 'data' => $transaksi]);
    }

    public function update()
    {
        $data = $this->request->getPost();

        if (!isset($data['id'])) {
            return $this->response->setJSON(['status' => false, 'message' => 'ID transaksi wajib diisi.']);
        }

        $arrayTransaksi = [
            'tanggal' => $data['tanggal'],
            'nama_transaksi' => $data['nama_transaksi'],
            'harga' => $data['harga'],
            'kategori' => $data['kategori'],
        ];

        $update = $this->db->table('transaksi')->update($arrayTransaksi, ['id' => $data['id']]);

        if ($update) {
            return $this->response->setJSON(['status' => true, 'message' => 'Data berhasil diperbarui!', 'data' => $arrayTransaksi]);
        }

        return $this->response->setJSON(['status' => false, 'message' => 'Gagal memperbarui data transaksi.']);
    }
}
