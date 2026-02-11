<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Hutang & Piutang</h1>
            <p class="text-xs text-gray-500 font-medium">Bayar Hutangmu dan tagihlah hakmu tepat waktu!</p>
        </div>
        <div class="w-full md:w-auto">
            <button onclick="openCreateModal()" class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-gradient-to-r from-[#2d5a3f] to-[#3b7a57] hover:from-[#1a3a2a] hover:to-[#2d5a3f] text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all">
                <i data-lucide="plus" class="mr-2 w-5 h-5"></i> Catat Baru
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="arrow-down-left" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">Hutang</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Hutang</p>
            <h3 class="text-xl font-extrabold text-red-500 mt-1" id="hp-hutang">Rp 0</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Piutang</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Piutang</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1" id="hp-piutang">Rp 0</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full">Paid</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Sudah Lunas</p>
            <h3 class="text-xl font-extrabold text-blue-600 mt-1" id="hp-lunas">0</h3>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" id="table-HutangPiutang">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 rounded-l-xl">Tipe</th>
                        <th class="px-6 py-4">Nama Orang</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                        <th class="px-6 py-4 text-center">Status</th>
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

<!-- Modal Create -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">Catat Hutang/Piutang</h1>
                    <p class="text-xs text-gray-400">Isi detail transaksi dengan lengkap</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-create">
                <div class="p-8 space-y-4">
                    <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4 flex items-start">
                        <i data-lucide="alert-circle" class="text-yellow-600 mr-2 mt-0.5 w-4 h-4"></i>
                        <p class="text-[10px] text-yellow-700 uppercase font-bold leading-tight">
                            Saldo dompet yang dipilih akan otomatis <span class="text-black">bertambah</span> (Hutang) atau <span class="text-black">berkurang</span> (Piutang).
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Tipe Transaksi</label>
                        <select name="type" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                            <option value="hutang">Hutang (Saya Pinjam Uang)</option>
                            <option value="piutang">Piutang (Saya Pinjamkan Uang)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Wallet</label>
                        <select name="wallet_id" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                            <option value="">-- Pilih Wallet --</option>
                            <?php foreach ($wallets as $w): ?>
                                <option value="<?= $w['id'] ?>"><?= $w['nama'] ?> (Rp <?= number_format($w['saldo']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Orang</label>
                        <input type="text" name="person_name" required placeholder="Contoh: Budi" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jumlah (Rp)</label>
                            <input type="number" name="amount" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jatuh Tempo</label>
                            <input type="date" name="due_date" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <textarea name="description" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all" rows="2"></textarea>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-sm hover:shadow-md transition-all">
                        Simpan & Update Wallet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">Edit Data</h1>
                    <p class="text-xs text-gray-400">Perbarui informasi yang diperlukan</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="p-8 space-y-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Nama Orang</label>
                        <input type="text" name="person_name" id="edit_person_name" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" name="amount" id="edit_amount" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Catatan</label>
                        <textarea name="description" id="edit_description" class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all" rows="2"></textarea>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-sm hover:shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Pelunasan -->
<div class="modal fade" id="modalPelunasan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900">Lunasi Transaksi?</h1>
                    <p class="text-xs text-gray-400">Pilih wallet untuk pelunasan</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form-pelunasan">
                <input type="hidden" name="id" id="pelunasan_id">
                <div class="p-8 space-y-4">
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start">
                        <i data-lucide="info" class="text-blue-600 mr-2 mt-0.5 w-4 h-4"></i>
                        <p class="text-xs text-blue-700 font-bold italic">Saldo dompet akan otomatis terupdate setelah konfirmasi.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Pilih Wallet untuk Pelunasan</label>
                        <select name="wallet_id" required class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                            <option value="">-- Pilih Wallet --</option>
                            <?php foreach ($wallets as $w): ?>
                                <option value="<?= $w['id'] ?>"><?= $w['nama'] ?> (Rp <?= number_format($w['saldo']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" class="px-6 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-full transition-colors" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="px-8 py-2 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full shadow-sm hover:shadow-md transition-all">
                        Konfirmasi Lunas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("hutangpiutang") ?>';
    var table;

    $(document).ready(function() {
        // Fetch HP stats
        fetch(`${baseUrl}/list?start=0&length=1000`).then(r => r.json()).then(d => {
            const items = d.data || [];
            let hutang = 0, piutang = 0, lunas = 0;
            items.forEach(i => {
                const amt = parseFloat(i.amount || 0);
                if (i.type === 'hutang') hutang += (i.status !== 'paid' ? amt : 0);
                if (i.type === 'piutang') piutang += (i.status !== 'paid' ? amt : 0);
                if (i.status === 'paid') lunas++;
            });
            document.getElementById('hp-hutang').innerText = 'Rp ' + hutang.toLocaleString('id-ID');
            document.getElementById('hp-piutang').innerText = 'Rp ' + piutang.toLocaleString('id-ID');
            document.getElementById('hp-lunas').innerText = lunas + ' Transaksi';
        }).catch(() => {});

        table = $('#table-HutangPiutang').DataTable({
            serverSide: true,
            processing: true,
            ajax: `${baseUrl}/list`,
            columns: [{
                    data: 'type',
                    className: 'px-6 py-4',
                    render: function(data) {
                        const colorClass = data === 'hutang' ? 'bg-red-50 text-red-600 border-red-100' : 'bg-green-50 text-green-600 border-green-100';
                        return `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border ${colorClass}">${data.toUpperCase()}</span>`;
                    }
                },
                {
                    data: 'person_name',
                    className: 'px-6 py-4 font-bold text-gray-900'
                },
                {
                    data: 'amount',
                    className: 'px-6 py-4 text-right font-black text-gray-900',
                    render: (data) => 'Rp ' + parseFloat(data).toLocaleString('id-ID')
                },
                {
                    data: 'status',
                    className: 'px-6 py-4 text-center',
                    render: function(data) {
                        const colorClass = data === 'paid' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-gray-100 text-gray-400 border-gray-200';
                        const label = data === 'paid' ? 'LUNAS' : 'BELUM LUNAS';
                        return `<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border ${colorClass}">${label}</span>`;
                    }
                },
                {
                    data: null,
                    className: 'px-6 py-4 text-right',
                    render: function(data) {
                        let btnPelunasan = '';
                        if (data.status !== 'paid') {
                            btnPelunasan = `
                                <button class="px-3 py-1 text-xs bg-green-50 text-green-600 border border-green-200 rounded-full font-bold hover:bg-green-600 hover:text-white transition-all mr-2" onclick="openPelunasanModal(${data.id})">
                                    <i data-lucide="check-circle" class="mr-1 w-3 h-3"></i> LU-NA-SI
                                </button>`;
                        } else {
                            btnPelunasan = `<span class="text-xs text-gray-400 font-bold mr-2 italic flex items-center"><i data-lucide="check-circle" class="mr-1 w-3 h-3"></i>Selesai</span>`;
                        }

                        return `
                            <div class="flex items-center justify-end">
                                ${btnPelunasan}
                                <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition-colors" onclick="openEditModal(${data.id})" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors ml-1" onclick="deleteHutangPiutang(${data.id})" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>`;
                    }
                }
            ],
            pageLength: 10
        });

        // AJAX handlers (unchanged logic, just IDs)
        $('#form-create').submit(function(e) {
            e.preventDefault();
            $.post(`${baseUrl}/create`, $(this).serialize(), function(res) {
                if (res.status) {
                    $('#modalCreate').modal('hide');
                    table.ajax.reload();
                    showAlert('success', 'Berhasil', res.message);
                } else {
                    showAlert('error', 'Gagal', res.message);
                }
            }, 'json');
        });

        $('#form-edit').submit(function(e) {
            e.preventDefault();
            $.post(`${baseUrl}/update`, $(this).serialize(), function(res) {
                if (res.status) {
                    $('#modalEdit').modal('hide');
                    table.ajax.reload();
                    showAlert('success', 'Berhasil', res.message);
                }
            }, 'json');
        });

        $('#form-pelunasan').submit(function(e) {
            e.preventDefault();
            $.post(`${baseUrl}/pelunasan`, $(this).serialize(), function(res) {
                if (res.status) {
                    $('#modalPelunasan').modal('hide');
                    table.ajax.reload();
                    showAlert('success', 'Berhasil Lunas', res.message);
                } else {
                    showAlert('error', 'Gagal', res.message);
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
            if (res.status) {
                let d = res.data;
                $('#edit_id').val(d.id);
                $('#edit_person_name').val(d.person_name);
                $('#edit_amount').val(d.amount);
                $('#edit_description').val(d.description);
                $('#modalEdit').modal('show');
            } else {
                showAlert('error', 'Error', res.message);
            }
        });
    }

    function deleteHutangPiutang(id) {
        Swal.fire({
            title: 'Hapus data?',
            text: 'Data akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post(`${baseUrl}/delete`, {
                    id: id
                }, function(res) {
                    table.ajax.reload();
                    showAlert('success', 'Terhapus', res.message);
                });
            }
        });
    }
</script>
<?= $this->endSection() ?>