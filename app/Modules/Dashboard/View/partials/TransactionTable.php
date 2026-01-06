<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="card-title fw-bold mb-0">Transaction Page</h2>
                <button id="btn-tambah" class="btn btn-primary px-4 rounded-pill shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Transaksi
                </button>
            </div>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabel-transaksi">
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
                    </tbody>
                </table>
            </div>

            <!-- Form Modal -->
            <form id="form_transaksi">
                <div class="modal fade" id="transaksiModal" tabindex="-1" aria-labelledby="transaksiModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="transaksiModalLabel">Form Transaksi</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_transaksi" id="id_transaksi" value="" />
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal<sup
                                            class="text-danger">*</sup></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                                </div>
                                <div class="mb-3">
                                    <label for="nama_transaksi" class="form-label">Nama Transaksi<sup
                                            class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="nama_transaksi" name="nama_transaksi"
                                        placeholder="Contoh: Beli Basreng" required />
                                </div>
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga<sup class="text-danger">*</sup></label>
                                    <input type="number" class="form-control" id="harga" name="harga" placeholder="0"
                                        required />
                                </div>
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori<sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        <option value="Makanan">Makanan</option>
                                        <option value="Transportasi">Transportasi</option>
                                        <option value="Hiburan">Hiburan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>