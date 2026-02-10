<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-gray-900 mb-1">Halaman Wallet</h1>
            <p class="text-xs text-gray-500 font-medium">Kelola saldo and transfer antar wallet Anda.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <button id="btn-transfer" class="inline-flex items-center justify-center px-6 py-3 bg-gray-900 hover:bg-black text-white font-bold rounded-2xl shadow-sm hover:shadow-md transition-all">
                <i data-lucide="repeat" class="mr-2 w-4 h-4"></i> Transfer Dana
            </button>
            <button id="btn-tambah" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-yellow-400 text-black font-bold rounded-2xl shadow-sm hover:shadow-md transition-all border-2 border-primary/20 hover:border-primary">
                <i data-lucide="plus" class="mr-2 w-5 h-5"></i> Tambah Wallet
            </button>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" id="tabel-wallet">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 text-center w-20 rounded-l-xl">#</th>
                        <th class="px-6 py-4">Nama Wallet</th>
                        <th class="px-6 py-4 text-right">Saldo</th>
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

<!-- Modal Form Wallet -->
<div class="modal fade" id="walletModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">Form Wallet</h1>
                    <p class="text-xs text-gray-400">Tambah atau perbarui data dompet</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form_wallet">
                <div class="p-8 space-y-4">
                    <input type="hidden" id="id" name="id" value="" />
                    <div>
                        <label for="nama" class="block text-sm font-bold text-gray-700 mb-1">Nama Wallet<span class="text-red-500 ml-1">*</span></label>
                        <input type="text" id="nama" name="nama" required placeholder="Contoh: Dompet Utama"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>
                    <div>
                        <label for="saldo" class="block text-sm font-bold text-gray-700 mb-1">Saldo Awal (Rp)<span class="text-red-500 ml-1">*</span></label>
                        <input type="number" id="saldo" name="saldo" required placeholder="0"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
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

<!-- Modal Transfer Dana -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">Transfer Dana</h1>
                    <p class="text-xs text-gray-400">Pindahkan saldo antar wallet</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-transfer">
                <div class="p-8 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="wallet_from" class="block text-sm font-bold text-gray-700 mb-1">Dari Wallet</label>
                            <select id="wallet_from" name="wallet_from" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 outline-none transition-all cursor-pointer">
                                <option value="">Pilih Wallet</option>
                            </select>
                        </div>
                        <div>
                            <label for="wallet_to" class="block text-sm font-bold text-gray-700 mb-1">Ke Wallet</label>
                            <select id="wallet_to" name="wallet_to" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-green-400 focus:border-green-400 outline-none transition-all cursor-pointer">
                                <option value="">Pilih Wallet</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="amount_transfer" class="block text-sm font-bold text-gray-700 mb-1">Jumlah Transfer (Rp)</label>
                        <input type="number" id="amount_transfer" name="amount" required placeholder="0" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>
                    <div>
                        <label for="note" class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <input type="text" id="note" name="note" placeholder="Contoh: Pindah saldo kas" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2 bg-gray-900 hover:bg-black text-white font-bold rounded-full shadow-sm hover:shadow-md transition-all">
                        Transfer Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("wallet") ?>';
    var table;

    $(document).ready(function() {
        table = $('#tabel-wallet').DataTable({
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
                    data: 'nama',
                    className: 'px-6 py-4 font-bold text-gray-900'
                },
                {
                    data: 'saldo',
                    className: 'px-6 py-4 text-right font-black',
                    render: function(data) {
                        const colorClass = parseFloat(data) >= 0 ? 'text-green-600' : 'text-red-600';
                        return `<span class="${colorClass}">Rp ` + parseFloat(data || 0).toLocaleString('id-ID') + `</span>`;
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
                                <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors btn-edit" data-id="${data.id}" title="Edit Wallet">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors btn-delete" data-id="${data.id}" title="Hapus Wallet">
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
            $('#form_wallet')[0].reset();
            $('#id').val('');
            $('#walletModal').modal('show');
        });

        $('#btn-transfer').click(function() {
            $('#form-transfer')[0].reset();
            loadWalletOptions();
            $('#transferModal').modal('show');
        });

        $('#form_wallet').submit(function(e) {
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
                success: function(res) {
                    if (res.status) {
                        $('#walletModal').modal('hide');
                        showAlert('success', 'Berhasil', res.message);
                        table.ajax.reload(null, false);
                        loadWalletOptions();
                    } else {
                        showAlert('error', 'Gagal', res.message || 'Gagal');
                    }
                }
            });
        });

        $('#form-transfer').submit(function(e) {
            e.preventDefault();
            let payload = {
                from_wallet_id: $('#wallet_from').val(),
                to_wallet_id: $('#wallet_to').val(),
                amount: $('#amount_transfer').val(),
                note: $('#note').val()
            };
            $.ajax({
                url: `${baseUrl}/transfer`,
                type: 'POST',
                data: payload,
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#transferModal').modal('hide');
                        showAlert('success', 'Transfer Berhasil', res.message);
                        table.ajax.reload(null, false);
                        loadWalletOptions();
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
                url: `${baseUrl}/list?start=0&length=100`,
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (!res || !res.data) return;
                    let opts = '<option value="">Pilih Wallet</option>';
                    res.data.forEach(function(w) {
                        opts += `<option value="${w.id}">${w.nama} - Rp ${parseFloat(w.saldo || 0).toLocaleString('id-ID')}</option>`;
                    });
                    $('#wallet_from').html(opts);
                    $('#wallet_to').html(opts);
                }
            });
        }

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Yakin hapus?',
                text: "Saldo di dalam wallet ini akan hilang!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Hapus'
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
                                showAlert('success', 'Terhapus', response.message);
                                table.ajax.reload(null, false);
                                loadWalletOptions();
                            } else {
                                showAlert('error', 'Gagal', response.message);
                            }
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