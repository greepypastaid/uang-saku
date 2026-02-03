<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Hutang & Piutang</h1>
        <button class="btn btn-warning fw-bold" onclick="openCreateModal()">
            <i class="bi bi-plus-lg"></i> Catat Baru
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="table-HutangPiutang">
                    <thead class="table-light">
                        <tr>
                            <th>Tipe</th>
                            <th>Nama Orang</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form-create" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Catat Hutang/Piutang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning small">
                    <i class="bi bi-exclamation-circle"></i> Saldo Wallet yang dipilih akan otomatis <b>bertambah</b> (jika Hutang) atau <b>berkurang</b> (jika Piutang).
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipe Transaksi</label>
                    <select name="type" class="form-select" required>
                        <option value="hutang">Hutang (Saya Pinjam Uang)</option>
                        <option value="piutang">Piutang (Saya Pinjamkan Uang)</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Pilih Wallet (Sumber/Tujuan Dana)</label>
                    <select name="wallet_id" class="form-select" required>
                        <option value="">-- Pilih Wallet --</option>
                        <?php foreach ($wallets as $w): ?>
                            <option value="<?= $w['id'] ?>"><?= $w['nama'] ?> (Rp <?= number_format($w['saldo']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Orang</label>
                    <input type="text" name="person_name" class="form-control" required placeholder="Contoh: Budi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jatuh Tempo</label>
                    <input type="date" name="due_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan & Update Wallet</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="form-edit" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="edit_id">
                <div class="mb-3">
                    <label class="form-label">Nama Orang</label>
                    <input type="text" name="person_name" id="edit_person_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jumlah (Rp)</label>
                    <input type="number" name="amount" id="edit_amount" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="description" id="edit_description" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalPelunasan" tabindex="-1">
    <div class="modal-dialog">
        <form id="form-pelunasan" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Lunasi Transaksi?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="pelunasan_id">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Saldo Wallet akan otomatis terupdate.
                </div>
                <div class="mb-3">
                    <label class="form-label">Pilih Wallet untuk Pelunasan</label>
                    <select name="wallet_id" class="form-select" required>
                        <option value="">-- Pilih Wallet --</option>
                        <?php foreach ($wallets as $w): ?>
                            <option value="<?= $w['id'] ?>"><?= $w['nama'] ?> (Rp <?= number_format($w['saldo']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Konfirmasi Lunas</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("hutangpiutang") ?>';
    var table;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {

        table = $('#table-HutangPiutang').DataTable({
            serverSide: true,
            processing: true,
            ajax: `${baseUrl}/list`,
            columns: [
                {
                    data: 'type',
                    render: function (data) {
                        return data === 'hutang'
                            ? '<span class="badge bg-danger text-uppercase">Hutang</span>'
                            : '<span class="badge bg-success text-uppercase">Piutang</span>';
                    }
                },
                { data: 'person_name' },
                {
                    data: 'amount', className: 'text-end fw-bold',
                    render: (data) => 'Rp ' + parseFloat(data).toLocaleString('id-ID')
                },
                {
                    data: 'status', className: 'text-center',
                    render: function (data) {
                        return data === 'paid'
                            ? '<span class="badge bg-primary">Lunas</span>'
                            : '<span class="badge bg-secondary">Belum Lunas</span>';
                    }
                },
                {
                    data: null, className: 'text-end',
                    render: function (data) {
                        let btnPelunasan = '';
                        if (data.status !== 'paid') {
                            btnPelunasan = `
                            <button class="btn btn-sm btn-success me-1" onclick="openPelunasanModal(${data.id})" title="Tandai Lunas">
                                <i class="bi bi-check-lg"></i>
                            </button>`;
                        } else {
                            btnPelunasan = `<span class="badge bg-light text-dark me-2 border">Selesai</span>`;
                        }

                        return `
                        ${btnPelunasan}
                        <button class="btn btn-sm btn-primary me-1" onclick="openEditModal(${data.id})" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteHutangPiutang(${data.id})" title="Hapus">
                            <i class="bi bi-trash"></i>
                        </button>`;
                    }
                }
            ]
        });

        // Submit Create
        $('#form-create').submit(function (e) {
            e.preventDefault();
            $.post(`${baseUrl}/create`, $(this).serialize(), function (res) {
                if (res.status) {
                    $('#modalCreate').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses', res.message, 'success');
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }, 'json');
        });

        // Submit Edit
        $('#form-edit').submit(function (e) {
            e.preventDefault();
            $.post(`${baseUrl}/update`, $(this).serialize(), function (res) {
                if (res.status) {
                    $('#modalEdit').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Sukses', res.message, 'success');
                }
            }, 'json');
        });

        // Submit Pelunasan
        $('#form-pelunasan').submit(function (e) {
            e.preventDefault();
            $.post(`${baseUrl}/pelunasan`, $(this).serialize(), function (res) {
                if (res.status) {
                    $('#modalPelunasan').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Lunas!', res.message, 'success');
                } else {
                    Swal.fire('Gagal', res.message, 'error');
                }
            }, 'json');
        });
    });

    function openCreateModal() {
        $('#form-create')[0].reset();
        $('#modalCreate').modal('show');
    }

    function openPelunasanModal(id) {
        $('#pelunasan_id').val(id);
        $('#modalPelunasan').modal('show');
    }

    function openEditModal(id) {
        $.get(`${baseUrl}/read?id=${id}`, function(res) {
            if(res.status) {
                let d = res.data;
                $('#edit_id').val(d.id);
                $('#edit_person_name').val(d.person_name);
                $('#edit_amount').val(d.amount);
                $('#edit_description').val(d.description);
                $('#modalEdit').modal('show');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        });
    }

    function deleteHutangPiutang(id) {
        Swal.fire({
            title: 'Hapus data?',
            text: 'Data akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`${baseUrl}/delete`, { id: id }, function (res) {
                    table.ajax.reload();
                    Swal.fire('Terhapus', res.message, 'success');
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>