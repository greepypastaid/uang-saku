<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-900 mb-1">Log Mutasi Rekening</h1>
            <p class="text-xs text-gray-500 font-medium">Riwayat lengkap semua aliran dana masuk dan keluar.</p>
        </div>
    </div>

    <!-- Flow Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                    <i data-lucide="arrow-down-circle" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full">↑ Masuk</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Dana Masuk</p>
            <h3 class="text-xl font-extrabold text-emerald-600 mt-1" id="log-income">Rp 0</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                    <i data-lucide="arrow-up-circle" class="w-5 h-5"></i>
                </div>
                <span class="text-[10px] font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded-full">↓ Keluar</span>
            </div>
            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Dana Keluar</p>
            <h3 class="text-xl font-extrabold text-red-500 mt-1" id="log-expense">Rp 0</h3>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left" id="table-log">
                <thead class="bg-gray-50/50 text-gray-400 text-[10px] font-black uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 rounded-l-xl">Tanggal</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4 text-center rounded-r-xl">Arus</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    <!-- DataTables magic -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("transaction") ?>';

    $(document).ready(function() {
        // Fetch flow stats
        const fmtCurrency = (v) => new Intl.NumberFormat('id-ID', { style:'currency', currency:'IDR', minimumFractionDigits:0 }).format(v);
        fetch('<?= base_url("dashboard/get_data") ?>').then(r => r.json()).then(d => {
            document.getElementById('log-income').innerText = fmtCurrency(d.total_pemasukan);
            document.getElementById('log-expense').innerText = fmtCurrency(d.total_pengeluaran);
        }).catch(() => {});

        $('#table-log').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ordering: false,
            ajax: {
                url: `${baseUrl}/list`,
                type: 'GET',
                data: function(d) {
                    d.mode = 'all';
                },
                dataSrc: function(json) {
                    return json.data || [];
                }
            },
            columns: [{
                    data: 'tanggal',
                    className: 'px-6 py-4',
                    render: function(data) {
                        let date = new Date(data);
                        return `<span class="text-xs font-bold text-gray-500 uppercase">${date.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</span>`;
                    }
                },
                {
                    data: 'nama_transaksi',
                    className: 'px-6 py-4',
                    render: function(data) {
                        return `<span class="font-bold text-gray-900">${data}</span>`;
                    }
                },
                {
                    data: 'kategori',
                    className: 'px-6 py-4',
                    render: function(data, type, row) {
                        let label = data;
                        let badgeClass = 'bg-gray-100 text-gray-600 border-gray-200';

                        if (data === 'Hutang/Piutang') {
                            let desc = row.nama_transaksi.toLowerCase();
                            if (desc.includes('pinjaman dari')) {
                                label = 'Hutang';
                                badgeClass = 'bg-red-50 text-red-600 border-red-100';
                            } else if (desc.includes('meminjamkan ke')) {
                                label = 'Piutang';
                                badgeClass = 'bg-blue-50 text-blue-600 border-blue-100';
                            } else if (desc.includes('pelunasan hutang')) {
                                label = 'Bayar Hutang';
                                badgeClass = 'bg-green-50 text-green-600 border-green-100';
                            } else if (desc.includes('pelunasan piutang')) {
                                label = 'Terima Piutang';
                                badgeClass = 'bg-primary/10 text-black border-primary/20';
                            } else {
                                label = 'Hutang/Piutang';
                                badgeClass = 'bg-yellow-50 text-yellow-700 border-yellow-100';
                            }
                        }

                        return `<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border ${badgeClass}">
                                    ${label}
                                </span>`;
                    }
                },
                {
                    data: 'harga',
                    className: 'px-6 py-4 text-right font-black',
                    render: function(data, type, row) {
                        let color = row.type === 'income' ? 'text-green-600' : 'text-red-600';
                        let prefix = row.type === 'income' ? '+' : '-';
                        return `<span class="${color}">
                                    ${prefix} Rp ${parseFloat(data || 0).toLocaleString('id-ID')}
                                </span>`;
                    }
                },
                {
                    data: 'type',
                    className: 'px-6 py-4 text-center',
                    render: function(data) {
                        return data === 'income' ?
                            '<i data-lucide="arrow-down-circle" class="text-green-500 w-5 h-5" title="Masuk"></i>' :
                            '<i data-lucide="arrow-up-circle" class="text-red-500 w-5 h-5" title="Keluar"></i>';
                    }
                }
            ],
            pageLength: 10
        });
    });
</script>
<?= $this->endSection() ?>