<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title fw-bold mb-0">Transaction Page</h2>
                <button class="btn btn-primary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Transaksi
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3">#</th>
                            <th scope="col" class="py-3">Tanggal</th>
                            <th scope="col" class="py-3">Nama Transaksi</th>
                            <th scope="col" class="py-3">Harga</th>
                            <th scope="col" class="py-3">Kategori</th>
                            <th scope="col" class="py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>2026-01-05</td>
                            <td class="fw-medium">Beli Basreng</td>
                            <td class="text-danger fw-bold">Rp 15.000</td>
                            <td><span class="badge bg-info text-dark">Makanan</span></td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-outline-secondary">Edit</button>
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>