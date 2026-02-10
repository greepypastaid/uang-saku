<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-gray-900 mb-1">Daftar Transaksi</h1>
            <p class="text-xs text-gray-500 font-medium">Kelola rincian pengeluaran and pemasukan Anda.</p>
        </div>
        <div class="w-full md:w-auto">
            <button type="button" id="btn-tambah" class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-2xl shadow-sm hover:shadow-md transition-all border-2 border-primary/20 hover:border-primary">
                <i data-lucide="plus" class="mr-2 w-5 h-5"></i> Tambah Transaksi
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" id="table-transaksi">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 rounded-l-xl">#</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Nama Transaksi</th>
                        <th class="px-6 py-4 text-right">Harga</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-right rounded-r-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <!-- DataTables magic -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="transaksiModal" tabindex="-1" aria-labelledby="transaksiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900" id="transaksiModalLabel">Form Transaksi</h1>
                    <p class="text-xs text-gray-400">Catat transaksi baru atau perbarui data aktif</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form_transaksi">
                <div class="p-8 space-y-4">
                    <input type="hidden" name="id_transaksi" id="id_transaksi" value="" />

                    <div>
                        <label for="tanggal" class="block text-sm font-bold text-gray-700 mb-1">Tanggal<span class="text-red-500 ml-1">*</span></label>
                        <input type="date" name="tanggal" id="tanggal" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>

                    <div>
                        <label for="nama_transaksi" class="block text-sm font-bold text-gray-700 mb-1">Nama Transaksi<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" name="nama_transaksi" id="nama_transaksi" required placeholder="Contoh: Makan Siang"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>

                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)<span class="text-red-500 ml-1">*</span></label>
                        <input type="number" name="harga" id="harga" required placeholder="0"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="kategori" class="block text-sm font-bold text-gray-700 mb-1">Kategori<span class="text-red-500 ml-1">*</span></label>
                            <select name="kategori" id="kategori" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
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
                        <div>
                            <label for="type" class="block text-sm font-bold text-gray-700 mb-1">Tipe Transaksi<span class="text-red-500 ml-1">*</span></label>
                            <select name="type" id="type" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                                <option value="" selected disabled>Pilih Tipe</option>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="wallet_id" class="block text-sm font-bold text-gray-700 mb-1">Wallet<span class="text-red-500 ml-1">*</span></label>
                        <select name="wallet_id" id="wallet_id" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                            <option value="" selected disabled>Pilih Wallet</option>
                        </select>
                    </div>

                    <!-- Budget Info Alert -->
                    <div id="budget-info-container" style="display: none;">
                        <div id="budget-info-alert" class="p-4 rounded-2xl border flex items-start">
                            <i data-lucide="info" class="mr-3 mt-1 w-4 h-4"></i>
                            <div id="budget-info-content" class="text-xs"></div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-sm hover:shadow-md transition-all">
                        Simpan
                    </button>
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

    $(document).ready(function() {
        table = $('#table-transaksi').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ajax: {
                url: `${baseUrl}/list`,
                type: 'GET',
                dataSrc: function(json) {
                    return json.data || [];
                }
            },
            order: [
                [1, 'desc']
            ],
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-6 py-4 text-center',
                    render: function(data, type, row, meta) {
                        return `<span class="text-gray-400">${meta.row + meta.settings._iDisplayStart + 1}</span>`;
                    }
                },
                {
                    data: 'tanggal',
                    className: 'px-6 py-4',
                    render: function(data) {
                        return `<span class="text-xs font-bold text-gray-500 uppercase">${data}</span>`;
                    }
                },
                {
                    data: 'nama_transaksi',
                    className: 'px-6 py-4 font-bold text-gray-900'
                },
                {
                    data: 'harga',
                    className: 'px-6 py-4 text-right font-black',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data || 0).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'kategori',
                    className: 'px-6 py-4',
                    render: function(data) {
                        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">${data}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'px-6 py-4 text-right',
                    render: function(data) {
                        return `
                            <div class="flex justify-end gap-2">
                                <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors btn-edit" data-id="${data.id}" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors btn-delete" data-id="${data.id}" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            pageLength: 10
        });

        $('#btn-tambah').click(function() {
            $('#form_transaksi')[0].reset();
            $('#id_transaksi').val('');
            $('#budget-info-container').hide();
            $('#transaksiModalLabel').text('Tambah Transaksi');
            $('#transaksiModal').modal('show');
        });

        function loadBudgetInfo() {
            const category = $('#kategori').val();
            const date = $('#tanggal').val() || new Date().toISOString().split('T')[0];
            const type = $('#type').val();

            if (category && type === 'expense') {
                $.ajax({
                    url: `${baseUrl}/check-budget`,
                    type: 'GET',
                    data: {
                        category,
                        date
                    },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status && res.has_budget) {
                            const data = res.data;
                            let alertColor = 'blue';

                            if (data.percentage >= 100) alertColor = 'red';
                            else if (data.percentage >= 80) alertColor = 'yellow';
                            else alertColor = 'green';

                            $('#budget-info-alert')
                                .removeClass('bg-blue-50 border-blue-100 text-blue-700 bg-red-50 border-red-100 text-red-700 bg-yellow-50 border-yellow-100 text-yellow-700 bg-green-50 border-green-100 text-green-700')
                                .addClass(`bg-${alertColor}-50 border-${alertColor}-100 text-${alertColor}-700`);

                            let content = `
                                <div class="space-y-1">
                                    <div><strong>Limit Budget:</strong> Rp ${data.formatted.budget_limit}</div>
                                    <div><strong>Sudah Terpakai:</strong> Rp ${data.formatted.current_spent} (${data.percentage}%)</div>
                                    <div class="font-bold">Sisa: Rp ${data.formatted.remaining}</div>
                                </div>
                            `;

                            if (data.remaining <= 0) {
                                content += '<div class="mt-2 font-black uppercase text-[10px] bg-red-600 text-white px-2 py-0.5 rounded inline-block">Budget Habis!</div>';
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
            } else {
                $('#budget-info-container').slideUp();
            }
        }

        $('#kategori, #tanggal, #type').on('change', function() {
            loadBudgetInfo();
        });

        $('#form_transaksi').submit(function(e) {
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
                success: function(res) {
                    if (res.status) {
                        $('#transaksiModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        table.ajax.reload(null, false);
                    } else {
                        showAlert('error', 'Gagal', res.message || 'Gagal');
                    }
                },
                error: function() {
                    showAlert('error', 'Error', 'Terjadi kesalahan sistem');
                }
            });
        });

        function loadWalletOptions() {
            $.ajax({
                url: `${walletApi}/list?start=0&length=100`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    let opts = '<option value="" selected disabled>Pilih Wallet</option>';
                    if (!res.data || res.data.length === 0) {
                        opts = '<option value="" disabled>Anda belum memiliki Wallet!</option>';
                        $('#form_transaksi button[type="submit"]').prop('disabled', true);
                    } else {
                        $('#form_transaksi button[type="submit"]').prop('disabled', false);
                        res.data.forEach(function(w) {
                            opts += `<option value="${w.id}">${w.nama} (Rp ${parseFloat(w.saldo || 0).toLocaleString('id-ID')})</option>`;
                        });
                    }
                    $('#wallet_id').html(opts);
                }
            });
        }

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data ini akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
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
                        success: function(response) {
                            if (response.status) {
                                showAlert('success', 'Berhasil', response.message);
                                table.ajax.reload(null, false);
                            } else {
                                showAlert('error', 'Gagal', response.message);
                            }
                        },
                        error: function() {
                            showAlert('error', 'Error', 'Terjadi kesalahan saat menghapus.');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `${baseUrl}/read`,
                type: 'GET',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(response) {
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
                        $('#transaksiModalLabel').text('Edit Transaksi');
                        $('#transaksiModal').modal('show');
                        setTimeout(loadBudgetInfo, 100);
                    } else {
                        showAlert('error', 'Gagal', response.message || 'Gagal ambil data');
                    }
                },
                error: function() {
                    showAlert('error', 'Error', 'Terjadi kesalahan sistem');
                }
            });
        });

        loadWalletOptions();
    });
</script>
<?= $this->endSection() ?>