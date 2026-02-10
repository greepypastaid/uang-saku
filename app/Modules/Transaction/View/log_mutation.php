<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2.5rem] border border-gray-100 shadow-sm">
        <div>
            <h1 class="text-2xl font-black text-gray-900 mb-1">Log Mutasi Rekening</h1>
            <p class="text-xs text-gray-500 font-medium">Riwayat lengkap semua aliran dana masuk and keluar.</p>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-[2.5rem] p-6 shadow-sm border border-gray-100 overflow-hidden">
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