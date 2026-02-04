<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="">
        <div class="">
            <h1 class="fw-bold">Halaman Wallet</h1>
            <div class="page-header">
                <div class="page-header-text">
                    <p class="mb-0">Kelola saldo dan transfer antar wallet disini!</p>
                </div>

                <div class="page-header-actions">
                    <button id="btn-transfer" class="btn px-4 rounded-3 shadow-sm"
                        style="background-color: #ffa600; color: #000000; border: none;">
                        <i class="bi bi-arrow-left-right"></i> Transfer Dana
                    </button>
                    <button id="btn-tambah" class="btn px-4 rounded-3 shadow-sm"
                        style="background-color: #ffd600; color: #000000; border: none;">
                        <i class="bi bi-plus-lg"></i> Tambah Wallet
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row mb-3">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="tabel-wallet">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 text-center">#</th>
                                <th scope="col" class="py-3">Nama Wallet</th>
                                <th scope="col" class="py-3 text-end">Saldo</th>
                                <th scope="col" class="py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <nav class="mt-3">
                        <ul class="pagination justify-content-center" id="pagination-container">
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="form_wallet">
    <div class="modal fade" id="walletModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">Form Wallet</h5>
                        <small class="text-muted">Tambah atau perbarui wallet</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" id="id" name="id" value="" />
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Wallet<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="nama" name="nama" required />
                    </div>
                    <div class="mb-3">
                        <label for="saldo" class="form-label">Saldo Awal<sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control" id="saldo" name="saldo" placeholder="0" required />
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="form-transfer">
    <div class="modal fade" id="transferModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 bg-light rounded-top-4">
                    <div>
                        <h5 class="modal-title fw-bold mb-1">Transfer Dana</h5>
                        <small class="text-muted">Pindahkan saldo antar wallet</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="wallet_from" class="form-label">Dari Wallet<sup class="text-danger">*</sup></label>
                        <select class="form-control" id="wallet_from" name="wallet_from" required>
                            <option value="">Pilih Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wallet_to" class="form-label">Ke Wallet<sup class="text-danger">*</sup></label>
                        <select class="form-control" id="wallet_to" name="wallet_to" required>
                            <option value="">Pilih Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Jumlah<sup class="text-danger">*</sup></label>
                        <input type="number" class="form-control" id="amount" name="amount" required />
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Catatan</label>
                        <input type="text" class="form-control" id="note" name="note" />
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Transfer</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("wallet") ?>';
    var table;

    $(document).ready(function () {
        table = $('#tabel-wallet').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: {
                url: `${baseUrl}/list`,
                type: 'GET',
                dataSrc: function (json) {
                    return json.data || [];
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama' },
                {
                    data: 'saldo',
                    className: 'text-end fw-bold',
                    render: function (data) {
                        // Memberi warna hijau jika saldo positif
                        let colorClass = parseFloat(data) >= 0 ? 'text-success' : 'text-danger';
                        return `<span class="${colorClass}">Rp ` + parseFloat(data || 0).toLocaleString('id-ID') + `</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data) {
                        return `
                <button class="btn badge rounded-pill bg-warning-subtle text-warning-emphasis border-0 me-1 px-3 py-2 btn-edit" data-id="${data.id}" title="Edit Wallet">
                    <i class="bi bi-pencil-square"></i>
                </button>
                
                <button class="btn badge rounded-pill bg-danger-subtle text-danger border-0 px-3 py-2 btn-delete" data-id="${data.id}" title="Hapus Wallet">
                    <i class="bi bi-trash"></i>
                </button>
            `;
                    }
                }
            ],
            language: {
                emptyTable: "Tidak ada data wallet",
                info: "Menampilkan _START_ sampai _END_ dari total data"
            },
            pageLength: 10
        });

        let delayTimer;
        $('#search-input').on('keyup', function () {
            clearTimeout(delayTimer);
            const val = $(this).val();
            delayTimer = setTimeout(function () {
                table.search(val).draw();
            }, 400);
        });

        $('#btn-tambah').click(function () {
            $('#form_wallet')[0].reset();
            $('#id').val('');
            $('#walletModal').modal('show');
        });

        $('#btn-transfer').click(function () {
            $('#form-transfer')[0].reset();
            loadWalletOptions();
            $('#transferModal').modal('show');
        });

        $('#form_wallet').submit(function (e) {
            e.preventDefault();
            let form = new FormData(this);
            let id = $('#id').val();
            let url = id ? `${baseUrl}/update` : `${baseUrl}/create`;
            $.ajax({
                url: url,
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    $('#walletModal').modal('hide');
                    if (res.status) {
                        Swal.fire('Berhasil', res.message, 'success');
                        table.ajax.reload(null, false);
                        loadWalletOptions();
                    } else {
                        Swal.fire('Gagal', res.message || 'Gagal', 'error');
                    }
                }
            });
        });

        $('#form-transfer').submit(function (e) {
            e.preventDefault();
            let payload = {
                from_wallet_id: $('#wallet_from').val(),
                to_wallet_id: $('#wallet_to').val(),
                amount: $('#amount').val(),
                note: $('#note').val()
            };
            $.ajax({
                url: `${baseUrl}/transfer`,
                type: 'POST',
                data: payload,
                dataType: 'json',
                success: function (res) {
                    $('#transferModal').modal('hide');
                    if (res.status) {
                        Swal.fire('Berhasil', res.message, 'success');
                        table.ajax.reload(null, false);
                        loadWalletOptions();
                    } else {
                        Swal.fire('Gagal', res.message || 'Gagal', 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                }
            });
        });

        function loadWalletOptions() {
            $.ajax({
                url: `${baseUrl}/list?start=0&length=100`,
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (!res || !res.data) return;
                    let opts = '<option value="">Pilih Wallet</option>';
                    res.data.forEach(function (w) {
                        opts += `<option value="${w.id}">${w.nama} - Rp ${parseFloat(w.saldo || 0).toLocaleString('id-ID')}</option>`;
                    });
                    $('#wallet_from').html(opts);
                    $('#wallet_to').html(opts);
                }
            });
        }

        $(document).on('click', '.btn-delete', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Saldo di dalam wallet ini akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/delete`,
                        type: 'POST',
                        data: { id: id },
                        dataType: 'json',
                        success: function (response) {
                            if (response.status) {
                                Swal.fire('Berhasil', response.message, 'success');
                                table.ajax.reload(null, false);
                                loadWalletOptions();
                            } else {
                                Swal.fire('Gagal', response.message, 'error');
                            }
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');
            $.ajax({
                url: `${baseUrl}/read`,
                type: 'GET',
                data: { id: id },
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        let data = response.data;
                        $('#form_wallet')[0].reset();
                        $('#id').val(data.id);
                        $('#nama').val(data.nama);
                        $('#saldo').val(data.saldo);
                        $('#walletModal').modal('show');
                    }
                }
            });
        });
        loadWalletOptions();
    });
</script>
<?= $this->endSection() ?>