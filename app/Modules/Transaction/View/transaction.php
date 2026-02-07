<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="">
        <h1 class="fw-bold">Halaman Transaksi</h1>
        <div class="page-header">
            <div class="page-header-text">
                <p class="mb-0">Tambah dan kurangi transaksi Anda dengan mudah disini!</p>
            </div>

            <div class="page-header-actions">
                <button id="btn-tambah" class="btn px-4 rounded-5 shadow-sm"
                    style="background-color: #FFD600; color: #000000; border: none;">
                    <i class="bi bi-plus-lg"></i> Tambah Transaksi
                </button>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row mb-3">
                </div>
                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-hover" id="table-transaksi">
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
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center" id="pagination-container">
                        </ul>
                    </nav>
                </div>

                <!-- Form Modal -->
                <form id="form_transaksi">
                    <div class="modal fade" id="transaksiModal" tabindex="-1" aria-labelledby="transaksiModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-0 bg-light rounded-top-4">
                                    <div>
                                        <h1 class="modal-title fs-5 fw-bold mb-1" id="transaksiModalLabel">Form Transaksi</h1>
                                        <small class="text-muted">Catat transaksi baru atau perbarui data</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <input type="hidden" name="id_transaksi" id="id_transaksi" value="" />
                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal<sup
                                                class="text-danger">*</sup></label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_transaksi" class="form-label">Nama Transaksi<sup
                                                class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="nama_transaksi"
                                            name="nama_transaksi" placeholder="Contoh: Beli Basreng" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="harga" class="form-label">Harga<sup
                                                class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" id="harga" name="harga"
                                            placeholder="0" required />
                                    </div>
                                    <div class="mb-3">
                                        <label for="kategori" class="form-label">Kategori<sup
                                                class="text-danger">*</sup></label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="Makanan">Makanan</option>
                                            <option value="Transportasi">Transportasi</option>
                                            <option value="Hiburan">Hiburan</option>
                                            <option value="Belanja">Belanja</option>
                                            <option value="Kesehatan">Kesehatan</option>
                                            <option value="Pendidikan">Pendidikan</option>
                                            <option value="Tagihan">Tagihan</option>
                                            <option value="Pemasukkan">Pemasukkan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Budget Info Alert -->
                                    <div id="budget-info-container" style="display: none;">
                                        <div class="alert mb-3" id="budget-info-alert" role="alert">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-calculator me-2"></i>
                                                <strong>Budget Limitator</strong>
                                            </div>
                                            <div id="budget-info-content">
                                                <!-- Budget info will be inserted here -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="type" class="form-label">Tipe Transaksi<sup
                                                class="text-danger">*</sup></label>
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
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 bg-light rounded-bottom-4">
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-warning rounded-pill px-4">Simpan</button>
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
        var baseUrl = '<?= base_url("transaction") ?>';
        var walletApi = '<?= base_url("wallet") ?>';
        var table;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            table = $('#table-transaksi').DataTable({
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
                order: [[1, 'desc']],
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
                    { data: 'tanggal' },
                    { data: 'nama_transaksi' },
                    {
                        data: 'harga',
                        className: 'text-end',
                        render: function (data) {
                            return 'Rp ' + parseFloat(data || 0).toLocaleString('id-ID');
                        }
                    },
                    { data: 'kategori' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-end',
                        render: function (data) {
                            return `
        <button class="btn badge rounded-pill bg-warning-subtle text-warning-emphasis border-0 me-1 px-3 py-2 btn-edit" data-id="${data.id}">
            <i class="bi bi-pencil-square me-1"></i> Edit
        </button>
        <button class="btn badge rounded-pill bg-danger-subtle text-danger border-0 px-3 py-2 btn-delete" data-id="${data.id}">
            <i class="bi bi-trash me-1"></i> Hapus
        </button>
    `;
                        }
                    }
                ],
                language: { emptyTable: "Tidak ada data transaksi" },
                pageLength: 10
            });

            let delayTimer;
            $('#search-input').on('keyup', function () {
                clearTimeout(delayTimer);
                let val = $(this).val();
                delayTimer = setTimeout(function () {
                    table.search(val).draw();
                }, 400);
            });

            $('#btn-tambah').click(function () {
                $('#form_transaksi')[0].reset();
                $('#id_transaksi').val('');
                $('#budget-info-container').hide();
                $('#transaksiModal').modal('show');
            });

            // Load budget info when category or date changes
            function loadBudgetInfo() {
                const category = $('#kategori').val();
                const date = $('#tanggal').val() || new Date().toISOString().split('T')[0];
                const type = $('#type').val();

                if (!category || type !== 'expense') {
                    $('#budget-info-container').hide();
                    return;
                }

                $.ajax({
                    url: '<?= base_url("budget/info") ?>',
                    type: 'GET',
                    data: { category: category, date: date },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status && res.has_budget) {
                            const data = res.data;
                            let alertClass = 'alert-info';
                            let statusIcon = 'bi-info-circle';
                            
                            if (data.percentage >= 100) {
                                alertClass = 'alert-danger';
                                statusIcon = 'bi-exclamation-triangle';
                            } else if (data.percentage >= 80) {
                                alertClass = 'alert-warning';
                                statusIcon = 'bi-exclamation-circle';
                            } else if (data.percentage >= 50) {
                                alertClass = 'alert-warning';
                                statusIcon = 'bi-exclamation-circle';
                            } else {
                                alertClass = 'alert-success';
                                statusIcon = 'bi-check-circle';
                            }

                            $('#budget-info-alert').removeClass('alert-info alert-success alert-warning alert-danger')
                                                   .addClass(alertClass);
                            
                            let content = `
                                <small>
                                    <div class="mb-1"><strong>Limit Budget:</strong> Rp ${data.formatted.budget_limit}</div>
                                    <div class="mb-1"><strong>Sudah Terpakai:</strong> Rp ${data.formatted.current_spent} (${data.percentage}%)</div>
                                    <div><strong>Sisa:</strong> Rp ${data.formatted.remaining}</div>
                                </small>
                            `;
                            
                            if (data.remaining <= 0) {
                                content += '<small class="text-danger"><br><i class="bi bi-exclamation-triangle me-1"></i>Budget sudah habis!</small>';
                            }
                            
                            $('#budget-info-content').html(content);
                            $('#budget-info-container').slideDown();
                        } else {
                            $('#budget-info-container').slideUp();
                        }
                    },
                    error: function() {
                        $('#budget-info-container').hide();
                    }
                });
            }

            $('#kategori, #tanggal, #type').on('change', function() {
                loadBudgetInfo();
            });

            $('#form_transaksi').submit(function (e) {
                e.preventDefault();
                let form = new FormData(this);
                let id = $('#id_transaksi').val();
                let url = id ? `${baseUrl}/update` : `${baseUrl}/create`;
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (res) {
                        $('#transaksiModal').modal('hide');
                        if (res.status) {
                            Swal.fire('Berhasil', res.message, 'success');
                            table.ajax.reload(null, false);
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
                    url: `${walletApi}/list?start=0&length=100`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        let opts = '<option value="" selected disabled>Pilih Wallet</option>';

                        if (!res.data || res.data.length === 0) {
                            opts = '<option value="" disabled>Anda belum memiliki Wallet!</option>';
                            $('#form_transaksi button[type="submit"]').prop('disabled', true);
                        } else {
                            $('#form_transaksi button[type="submit"]').prop('disabled', false);

                            res.data.forEach(function (w) {
                                opts += `<option value="${w.id}">${w.nama} (Sisa: Rp ${parseFloat(w.saldo || 0).toLocaleString('id-ID')})</option>`;
                            });
                        }
                        $('#wallet_id').html(opts);
                    }
                });
            }

            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!'
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
                                } else {
                                    Swal.fire('Gagal', response.message, 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Terjadi kesalahan saat menghapus.', 'error');
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
                            $('#form_transaksi')[0].reset();
                            $('#budget-info-container').hide();
                            $('#id_transaksi').val(data.id);
                            $('#tanggal').val(data.tanggal);
                            $('#nama_transaksi').val(data.nama_transaksi);
                            $('#harga').val(data.harga);
                            $('#kategori').val(data.kategori);
                            $('#type').val(data.type);
                            $('#wallet_id').val(data.wallet_id);
                            $('#transaksiModal').modal('show');
                            
                            // Load budget info after setting values
                            setTimeout(function() {
                                loadBudgetInfo();
                            }, 100);
                        } else {
                            Swal.fire('Gagal', response.message || 'Gagal ambil data', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                    }
                });
            });
            loadWalletOptions();
        });
    </script>


    <?= $this->endSection() ?>