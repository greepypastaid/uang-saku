<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="">
            <h1 class="fw-bold">Halaman Wallet</h1>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0">Tambah dan kurangi transaksi Anda dengan mudah disini!</p>

                <button id="btn-tambah" class="btn px-4 rounded-3 shadow-sm"
                    style="background-color: #FFD600; color: #000000; border: none;">
                    <i class="bi bi-plus-lg"></i> Tambah Wallet
                </button>
            </div>
        </div>
        <div class="card-body">
            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabel-transaksi">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="py-3">#</th>
                            <th scope="col" class="py-3">Nama</th>
                            <th scope="col" class="py-3">Saldo</th>
                            <th scope="col" class="py-3 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            <!-- Form Modal -->
            <form id="form_wallet">
                <div class="modal fade" id="walletModal" tabindex="-1" aria-labelledby="walletModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="transaksiModalLabel">Tambah Wallet</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="id" name="id" value="" />
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama<sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Contoh: BCA" required />
                                </div>
                                <div class="mb-3">
                                    <label for="saldo" class="form-label">Saldo<sup class="text-danger">*</sup></label>
                                    <input type="number" class="form-control" id="saldo" name="saldo" placeholder="0"
                                        required />
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

    $(document).ready(function () {
        $('#btn-tambah').click(function () {
            $('#form_wallet')[0].reset();
            $('#id').val('');
            $('#walletModal').modal('show');
        });

        $('#form_wallet').submit(function (e) {
            e.preventDefault();
            submitData();
        });

        deleteData();
        editData();
        showData();
    })

    function submitData() {
        let id = $('#id').val();
        let nama = $('#nama').val();
        let saldo = $('#saldo').val();

        let form = new FormData();
        form.append('id', id);
        form.append('nama', nama);
        form.append('saldo', saldo);

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
            $('#walletModal').modal('hide');
            if (response.status) {
                alert(response.message);
                showData();
            } else {
                alert(response.message);
            }
        });
    }

    function showData() {
        if ($.fn.DataTable.isDataTable('#tabel-transaksi')) {
            $('#tabel-transaksi').DataTable().clear().destroy();
            $('#tabel-transaksi tbody').empty();
        }

        $('#tabel-transaksi').DataTable({
            "ajax": {
                "url": `${baseUrl}/list`,
                "type": "GET"
            },
            "columns": [
                { "data": "id" },
                { "data": "nama" },
                {
                    "data": "saldo",
                    "render": function (data, type, row) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID', { minimumFractionDigits: 2 });
                    }
                },
                {
                    "data": null,
                    "className": "text-end",
                    "render": function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}">Edit</button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${row.id}">Hapus</button>
                        `;
                    }
                }
            ]
        });
    };

    function deleteData() {
        $(document).on("click", ".btn-delete", function () {
            let id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `${baseUrl}/delete?id=${id}`,
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (response) {
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
        $(document).on("click", ".btn-edit", function () {
            let id = $(this).data('id');
            // Fetch data transaksi berdasarkan ID dan isi form
            var settings = {
                "url": `${baseUrl}/read?id=${id}`,
                "method": "GET",
                "timeout": 0,
            };

            $.ajax(settings).done(function (response) {
                // Parse response jika masih string
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                if (response.status === false) {
                    alert(response.message);
                    return;
                } else {
                    let data = response.data;
                    $('#form_wallet')[0].reset();
                    $('#id').val(data.id);
                    $('#nama').val(data.nama);
                    $('#saldo').val(data.saldo);
                    $('#walletModal').modal('show');
                }
            });
        });
    }
</script>


<?= $this->endSection() ?>