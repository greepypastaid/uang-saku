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
                <button id="btn-tambah" class="btn px-4 rounded-3 shadow-sm"
                    style="background-color: #FFD600; color: #000000; border: none;">
                    <i class="bi bi-plus-lg"></i> Tambah Transaksi
                </button>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="search-input" placeholder="Cari transaksi...">
                        </div>
                    </div>
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
                                            <option value="Pemasukkan">Pemasukkan</option>
                                            <option value="Lainnya">Lainnya</option>
                                        </select>
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
                                            <?php foreach ($wallets as $wallet): ?>
                                                <option value="<?= $wallet['id'] ?>"><?= $wallet['nama'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn"
                                        style="background-color: #ffffff; color: #000000; border: 1px solid #000000;"
                                        data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn"
                                        style="background-color: #FFD600; color: #000000; border: none;">Simpan</button>
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
        var currentPage = 1;
        var currentKeyword = '';
        var table;

        $(document).ready(function () {
            table = $('#table-transaksi').DataTable({
                paging: false,
                info: true,
                searching: false,
                ordering: true,
                responsive: true,
                language: {
                    emptyTable: "Tidak ada data transaksi"
                },
                columnDefs: [
                    { className: "text-end", targets: [5] }
                ]
            });

            $('#btn-tambah').click(function () {
                $('#form_transaksi')[0].reset();
                $('#id_transaksi').val('');
                $('#transaksiModal').modal('show');
            });

            $('#form_transaksi').submit(function (e) {
                e.preventDefault();
                submitData();
                $('#transaksiModal').modal('hide');
                loadData(currentPage, currentKeyword);
            });

            let delayTimer;

            // buat search
            $('#search-input').on('keyup', function () {
                clearTimeout(delayTimer);
                let keyword = $(this).val();

                delayTimer = setTimeout(function () {
                    currentKeyword = keyword;
                    currentPage = 1;
                    loadData(currentPage, currentKeyword);
                }, 500); // waktu delayne 500ms mas
            });


            deleteData();
            editData();
            loadData(currentPage, currentKeyword);
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

            $.ajax(settings).done(function (response) {
                response = JSON.parse(response);
                console.log(response);
                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    });
                    loadData(currentPage, currentKeyword);
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                    });
                }
            });
        }

        function loadData(page, keyword = '') {
            $.ajax({
                url: `${baseUrl}/list?page=${page}&keyword=${keyword}`, type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status) {
                        renderTable(response.data, (page - 1) * response.perPage);
                        renderPagination(response.currentPage, response.totalPages);
                    }
                }
            })
        }

        function renderTable(data, startIndex) {
            table.clear();

            let newRows = [];

            if (data.length > 0) {
                data.forEach(function (item, index) {
                    let formatHarga = 'Rp ' + parseFloat(item.harga).toLocaleString('id-ID');

                    let btnAksi = `
                <button class="btn btn-sm btn-primary btn-edit" data-id="${item.id}"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}"><i class="bi bi-trash"></i></button>
            `;
                    newRows.push([
                        startIndex + index + 1, // Kolom #
                        item.tanggal,           // Kolom Tanggal
                        item.nama_transaksi,    // Kolom Nama
                        formatHarga,            // Kolom Harga
                        item.kategori,          // Kolom Kategori
                        btnAksi                 // Kolom Aksi
                    ]);
                });
            }

            table.rows.add(newRows).draw();
        }

        function renderPagination(current, total) {
            let html = '';

            html += `
        <li class="page-item ${current === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current - 1}">Previous</a>
        </li>`;

            for (let i = 1; i <= total; i++) {
                html += `
            <li class="page-item ${i === current ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>`;
            }

            html += `
        <li class="page-item ${current === total ? 'disabled' : ''}">
            <a class="page-link" href="#" data-page="${current + 1}">Next</a>
        </li>`;

            $('#pagination-container').html(html);
        }

        // Event handler untuk klik pagination
        $(document).on('click', '#pagination-container .page-link', function (e) {
            e.preventDefault();
            let page = parseInt($(this).data('page'));
            if (!isNaN(page) && page > 0) {
                currentPage = page;
                loadData(currentPage, currentKeyword);
            }
        });

        function deleteData() {
            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data ini akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `${baseUrl}/delete`,
                            type: 'POST',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                    });
                                    loadData(currentPage, currentKeyword);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message,
                                    });
                                }
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Terjadi kesalahan saat menghapus.',
                                });
                            }
                        });
                    }
                });
            });
        }

        function editData() {
            $(document).on("click", ".btn-edit", function () {
                let id = $(this).data('id');

                var settings = {
                    "url": `${baseUrl}/read?id=${id}`,
                    "method": "GET",
                    "timeout": 0,
                };

                $.ajax(settings).done(function (response) {
                    if (response.status === false) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message,
                        });
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