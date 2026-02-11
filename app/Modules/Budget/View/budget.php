<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Budget Limitator</h1>
            <p class="text-xs text-gray-500 font-medium">Atur batas maksimal pengeluaran per kategori setiap bulan.</p>
        </div>
        <div class="w-full md:w-auto">
            <button type="button" id="btn-tambah" class="inline-flex items-center justify-center w-full md:w-auto px-6 py-3 bg-gradient-to-r from-[#2d5a3f] to-[#3b7a57] hover:from-[#1a3a2a] hover:to-[#2d5a3f] text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-xl transition-all">
                <i data-lucide="plus" class="mr-2 w-5 h-5"></i> Tambah Budget
            </button>
        </div>
    </div>

    <!-- Budget Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="target" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded-full">Active</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Budget Aktif</p>
            <h3 class="text-xl font-extrabold text-gray-900 mt-1" id="budget-count">-</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="banknote" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">Limit</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Limit Bulan Ini</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1" id="budget-total-limit">Rp 0</h3>
        </div>
    </div>

    <!-- Filter & Table Card -->
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100">
        <!-- Filter Section -->
        <div class="flex flex-col md:flex-row gap-4 mb-6 items-end">
             <div class="w-full md:w-1/3">
                <label for="filter-month" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Bulan</label>
                <select id="filter-month" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-primary transition-all">
                    <?php
                    $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
                    foreach ($months as $idx => $m):
                    ?>
                        <option value="<?= $idx + 1 ?>" <?= $currentMonth == ($idx + 1) ? 'selected' : '' ?>><?= $m ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="w-full md:w-1/3">
                <label for="filter-year" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Tahun</label>
                <input type="number" id="filter-year" value="<?= $currentYear ?>" min="2000" max="2100" class="w-full bg-gray-50 border-0 rounded-xl px-4 py-3 text-sm font-bold text-gray-700 focus:ring-2 focus:ring-primary transition-all">
            </div>
             <div class="w-full md:w-auto">
                <button id="btn-filter" class="w-full md:w-auto px-6 py-3 bg-gray-900 text-white font-bold rounded-xl shadow-lg shadow-gray-200 hover:shadow-xl hover:scale-105 transition-all">
                    <i data-lucide="filter" class="mr-2 w-4 h-4"></i> Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-hidden rounded-2xl border border-gray-100">
             <table class="w-full text-sm text-left" id="table-budget">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                         <th class="px-6 py-4 rounded-l-xl">#</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-right">Limit Budget</th>
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

<!-- Modal Form Budget -->
<div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-0 shadow-2xl rounded-3xl">
            <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-extrabold text-gray-900" id="budgetModalLabel">Budget Limitator</h1>
                    <p class="text-xs text-gray-400">Atur batas maksimal pengeluaran</p>
                </div>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors" data-bs-dismiss="modal">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <form id="form_budget">
                <div class="p-8 space-y-4">
                    <input type="hidden" name="id_budget" id="id_budget" value="" />

                    <div>
                        <label for="category" class="block text-sm font-bold text-gray-700 mb-1">Kategori<span class="text-red-500 ml-1">*</span></label>
                        <select name="category" id="category" required
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
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

                    <div>
                        <label for="amount" class="block text-sm font-bold text-gray-700 mb-1">Limit Budget (Rp)<span class="text-red-500 ml-1">*</span></label>
                        <input type="number" name="amount" id="amount" required placeholder="0" min="0" step="0.01"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
                        <p class="mt-1 text-[10px] text-gray-400 uppercase font-black italic">Transaksi yang melebihi limit ini akan memunculkan peringatan</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="month" class="block text-sm font-bold text-gray-700 mb-1">Bulan<span class="text-red-500 ml-1">*</span></label>
                            <select name="month" id="month" required
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all cursor-pointer">
                                <?php foreach ($months as $idx => $m): ?>
                                    <option value="<?= $idx + 1 ?>"><?= $m ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="year" class="block text-sm font-bold text-gray-700 mb-1">Tahun<span class="text-red-500 ml-1">*</span></label>
                            <input type="number" name="year" id="year" value="<?= $currentYear ?>" required min="2000" max="2100"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all">
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
    var baseUrl = '<?= base_url("budget") ?>';
    var table;

    $(document).ready(function() {
        // Fetch budget stats
        const fmtCurrency = (v) => 'Rp ' + parseFloat(v || 0).toLocaleString('id-ID');
        const m = $('#filter-month').val();
        const y = $('#filter-year').val();
        fetch(`${baseUrl}/list?start=0&length=100&month=${m}&year=${y}`).then(r => r.json()).then(d => {
            const budgets = d.data || [];
            document.getElementById('budget-count').innerText = budgets.length + ' Budget';
            let total = 0;
            budgets.forEach(b => { total += parseFloat(String(b.amount).replace(/[^0-9]/g,'') || 0); });
            document.getElementById('budget-total-limit').innerText = fmtCurrency(total);
        }).catch(() => {});

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
                dataSrc: function(json) {
                    return json.data || [];
                }
            },
            order: [
                [1, 'asc']
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
                    data: 'category',
                    className: 'px-6 py-4 font-bold text-gray-900'
                },
                {
                    data: 'amount',
                    className: 'px-6 py-4 text-right font-black text-gray-900',
                    render: function(data) {
                        return 'Rp ' + data;
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

        $('#btn-filter').click(function() {
            table.ajax.reload();
        });

        $('#btn-tambah').click(function() {
            $('#form_budget')[0].reset();
            $('#id_budget').val('');
            $('#month').val($('#filter-month').val());
            $('#year').val($('#filter-year').val());
            $('#budgetModalLabel').text('Tambah Budget');
            $('#budgetModal').modal('show');
        });

        $('#form_budget').submit(function(e) {
            e.preventDefault();
            let id = $('#id_budget').val();
            let url = id ? `${baseUrl}/update/${id}` : `${baseUrl}/create`;
            let formData = $(this).serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        $('#budgetModal').modal('hide');
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

        $(document).on('click', '.btn-edit', function() {
            let row = table.row($(this).closest('tr')).data();
            $('#form_budget')[0].reset();
            $('#id_budget').val(row.id);
            $('#category').val(row.category);
            let amount = row.amount.replace(/[^\d]/g, '');
            $('#amount').val(amount);
            $('#month').val(row.month);
            $('#year').val(row.year);
            $('#budgetModalLabel').text('Edit Budget');
            $('#budgetModal').modal('show');
        });

        $(document).on('click', '.btn-delete', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Budget limitator ini akan dihapus!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/delete/${id}`,
                        type: 'POST',
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
    });
</script>
<?= $this->endSection() ?>