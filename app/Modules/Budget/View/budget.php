<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="">
        <h1 class="fw-bold">Budget Limitator</h1>
        <div class="page-header">
            <div class="page-header-text">
                <p class="mb-0">Atur batas maksimal pengeluaran per kategori setiap bulan</p>
            </div>

            <div class="page-header-actions">
                <button id="btn-tambah" class="btn px-4 rounded-5 shadow-sm"
                    style="background-color: #FFD600; color: #000000; border: none;">
                    <i class="bi bi-plus-lg"></i> Tambah Budget
                </button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <!-- Filter Section -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="filter-month" class="form-label">Bulan</label>
                        <select class="form-select" id="filter-month">
                            <option value="1" <?= $currentMonth == 1 ? 'selected' : '' ?>>Januari</option>
                            <option value="2" <?= $currentMonth == 2 ? 'selected' : '' ?>>Februari</option>
                            <option value="3" <?= $currentMonth == 3 ? 'selected' : '' ?>>Maret</option>
                            <option value="4" <?= $currentMonth == 4 ? 'selected' : '' ?>>April</option>
                            <option value="5" <?= $currentMonth == 5 ? 'selected' : '' ?>>Mei</option>
                            <option value="6" <?= $currentMonth == 6 ? 'selected' : '' ?>>Juni</option>
                            <option value="7" <?= $currentMonth == 7 ? 'selected' : '' ?>>Juli</option>
                            <option value="8" <?= $currentMonth == 8 ? 'selected' : '' ?>>Agustus</option>
                            <option value="9" <?= $currentMonth == 9 ? 'selected' : '' ?>>September</option>
                            <option value="10" <?= $currentMonth == 10 ? 'selected' : '' ?>>Oktober</option>
                            <option value="11" <?= $currentMonth == 11 ? 'selected' : '' ?>>November</option>
                            <option value="12" <?= $currentMonth == 12 ? 'selected' : '' ?>>Desember</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter-year" class="form-label">Tahun</label>
                        <input type="number" class="form-control" id="filter-year" value="<?= $currentYear ?>" min="2000" max="2100">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="btn-filter" class="btn btn-primary">
                            <i class="bi bi-funnel"></i> Filter
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="table-budget">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3">#</th>
                                <th scope="col" class="py-3">Kategori</th>
                                <th scope="col" class="py-3">Limit Budget</th>
                                <th scope="col" class="py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Form Budget -->
                <form id="form_budget">
                    <div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg rounded-4">
                                <div class="modal-header border-0 bg-light rounded-top-4">
                                    <div>
                                        <h1 class="modal-title fs-5 fw-bold mb-1" id="budgetModalLabel">Form Budget Limitator</h1>
                                        <small class="text-muted">Atur batas maksimal pengeluaran</small>
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <input type="hidden" name="id_budget" id="id_budget" value="" />
                                    
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori<sup
                                                class="text-danger">*</sup></label>
                                        <select class="form-select" id="category" name="category" required>
                                            <option value="" selected disabled>Pilih Kategori</option>
                                            <option value="Makanan">Makanan</option>
                                            <option value="Transportasi">Transportasi</option>
                                            <option value="Hiburan">Hiburan</option>
                                            <option value="Belanja">Belanja</option>
                                            <option value="Kesehatan">Kesehatan</option>
                                            <option value="Pendidikan">Pendidikan</option>
                                            <option value="Tagihan">Tagihan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Limit Budget (Maksimal Pengeluaran)<sup
                                                class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" id="amount" name="amount"
                                            placeholder="0" required min="0" step="0.01" />
                                        <small class="text-muted">Transaksi yang melebihi limit ini akan ditolak</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="month" class="form-label">Bulan<sup
                                                class="text-danger">*</sup></label>
                                        <select class="form-select" id="month" name="month" required>
                                            <option value="1">Januari</option>
                                            <option value="2">Februari</option>
                                            <option value="3">Maret</option>
                                            <option value="4">April</option>
                                            <option value="5">Mei</option>
                                            <option value="6">Juni</option>
                                            <option value="7">Juli</option>
                                            <option value="8">Agustus</option>
                                            <option value="9">September</option>
                                            <option value="10">Oktober</option>
                                            <option value="11">November</option>
                                            <option value="12">Desember</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="year" class="form-label">Tahun<sup
                                                class="text-danger">*</sup></label>
                                        <input type="number" class="form-control" id="year" name="year"
                                            value="<?= $currentYear ?>" required min="2000" max="2100" />
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("budget") ?>';
    var table;
    var currentMonth = <?= $currentMonth ?>;
    var currentYear = <?= $currentYear ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function () {
        // Initialize DataTable
        table = $('#table-budget').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: {
                url: `${baseUrl}/list`,
                type: 'GET',
                data: function(d) {
                    d.month = $('#filter-month').val();
                    d.year = $('#filter-year').val();
                },
                dataSrc: function (json) {
                    return json.data || [];
                }
            },
            order: [[1, 'asc']],
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
                { data: 'category' },
                {
                    data: 'amount',
                    className: 'text-end',
                    render: function (data) {
                        return 'Rp ' + data;
                    }
                },
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
            language: { emptyTable: "Tidak ada budget yang diatur" },
            pageLength: 10
        });

        // Filter Button
        $('#btn-filter').click(function() {
            table.ajax.reload();
        });

        // Add Button
        $('#btn-tambah').click(function () {
            $('#form_budget')[0].reset();
            $('#id_budget').val('');
            $('#month').val($('#filter-month').val());
            $('#year').val($('#filter-year').val());
            $('#budgetModal').modal('show');
        });

        // Form Submit
        $('#form_budget').submit(function (e) {
            e.preventDefault();
            let id = $('#id_budget').val();
            let url = id ? `${baseUrl}/update/${id}` : `${baseUrl}/create`;
            let formData = {
                category: $('#category').val(),
                amount: $('#amount').val(),
                month: $('#month').val(),
                year: $('#year').val()
            };

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    $('#budgetModal').modal('hide');
                    if (res.status) {
                        Swal.fire('Berhasil', res.message, 'success');
                        table.ajax.reload(null, false);
                    } else {
                        let errorMsg = res.message;
                        if (res.errors) {
                            errorMsg = Object.values(res.errors).join('<br>');
                        }
                        Swal.fire('Gagal', errorMsg, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                }
            });
        });

        // Edit Button
        $(document).on('click', '.btn-edit', function () {
            let row = table.row($(this).closest('tr')).data();
            
            $('#form_budget')[0].reset();
            $('#id_budget').val(row.id);
            $('#category').val(row.category);
            
            // Remove "Rp " and dots from the formatted number
            let amount = row.amount.replace(/[^\d]/g, '');
            $('#amount').val(amount);
            
            $('#month').val(row.month);
            $('#year').val(row.year);
            $('#budgetModal').modal('show');
        });

        // Delete Button
        $(document).on('click', '.btn-delete', function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Budget limitator ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/delete/${id}`,
                        type: 'POST',
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
    });
</script>
<?= $this->endSection() ?>
