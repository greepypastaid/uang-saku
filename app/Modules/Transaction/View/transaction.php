<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
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
                            <th scope="col" class="py-3">Tipe</th>
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
                                        <option value="Pemasukkan">Pemasukkan</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Tipe Transaksi<sup class="text-danger">*</sup></label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="" selected disabled>Pilih Tipe</option>
                                        <option value="income">Income</option>
                                        <option value="expense">Expense</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label">Wallet<sup
                                            class="text-danger">*</sup></label>
                                    <select class="form-select" id="wallet_id" name="wallet_id" required>
                                        <option value="" selected disabled>Pilih Wallet</option>
                                        <?php foreach ($wallets as $wallet): ?>
                                            <option value="<?= $wallet['id'] ?>"><?= $wallet['nama'] ?>
</option>
                                        <?php endforeach; ?>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = window.location.href;

    $(document).ready(function() {
        $('#btn-tambah').click(function() {
            $('#form_transaksi')[0].reset();
            $('#id_transaksi').val('');
            $('#transaksiModal').modal('show');
        });

        $('#form_transaksi').submit(function(e) {
            e.preventDefault();
            submitData();
            $('#transaksiModal').modal('hide');
            showData();
        });

        deleteData();
        editData();
        showData();
    })

    function submitData() {
        let id = $('#id_transaksi').val();
        let tanggal = $('#tanggal').val();
        let nama_transaksi = $('#nama_transaksi').val();
        let harga = $('#harga').val();
        let kategori = $('#kategori').val();
        let type = $('#type').val();
        let wallet_id = $('#wallet_id').val();

        let form = new FormData();
        form.append('id', id);
        form.append('tanggal', tanggal);
        form.append('nama_transaksi', nama_transaksi);
        form.append('harga', harga);
        form.append('kategori', kategori);
        form.append('type', type);
        form.append('wallet_id', wallet_id);

        let url = `${baseUrl}/create`;
        if (id !== '') {
            url = `${baseUrl}/update`;
            form.append("id", id);
        }

        let settings = {
            "url": url,
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function(response) {
            response = JSON.parse(response);
            console.log(response);
            if (response.status) {
                alert(response.message);
            } else {
                alert(response.message);
            }
        });
    }

    function showData() {
        $.ajax({
            url: `${baseUrl}/list`,
            method: "GET",
            dataType: "json",
            success: function(response) {
                let tbody = '';
                response.data.forEach(function(item, index) {
                    tbody += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.tanggal}</td>
                        <td class="fw-medium">${item.nama_transaksi}</td>
                        <td class="text-danger fw-bold">Rp ${item.harga}</td>
                        <td><span class="badge bg-info text-dark">${item.kategori}</span></td>
                        <td><span class="badge bg-${item.type === 'income' ? 'success' : 'danger'} text-white">${item.type === 'income' ? 'Pemasukan' : 'Pengeluaran'}</span></td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary btn-edit" data-id="${item.id}">Edit</button>
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>
                    `;
                });
                $('#tabel-transaksi tbody').html(tbody);
            }
        })
    }

    function deleteData() {
        $(document).on("click", ".btn-delete", function() {
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `${baseUrl}/delete?id=${id}`,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert(response.message);
                            showData();
                        } else {
                            alert(response.message);
                        }
                    }
                });
            }
        });
    }

    function editData() {
        $(document).on("click", ".btn-edit", function() {
            let id = $(this).data('id');

            var settings = {
                "url": `${baseUrl}/read?id=${id}`,
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function(response) {
                if (response.status === false) {
                    alert(response.message);
                    return;
                } else {
                    let data = response.data;
                    $('#form_transaksi')[0].reset();
                    $('#id_transaksi').val(data.id);
                    $('#tanggal').val(data.tanggal);
                    $('#nama_transaksi').val(data.nama_transaksi);
                    $('#harga').val(data.harga);
                    $('#kategori').val(data.kategori);
                    $('#type').val(data.type);
                    $('#wallet_id').val(data.wallet_id);
                    $('#wallet_id').trigger('change');
                    $('#transaksiModal').modal('show');
                }
            });
        });
    }
</script>


<?= $this->endSection() ?>