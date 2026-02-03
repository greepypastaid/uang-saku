<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<style>
    /* Styling khusus untuk Log agar lebih enak dilihat */
    #table-log tbody tr td {
        vertical-align: middle;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    .amount-text {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
</style>

<div class="container mt-4">
    <div class="">
        <h1 class="fw-bold">Log Mutasi Rekening</h1>
        <div class="page-header">
            <div class="page-header-text">
                <p class="mb-0 text-muted">Riwayat lengkap semua aliran dana masuk dan keluar (termasuk hutang & piutang).</p>
            </div>
            </div>

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="table-log">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3">Tanggal</th>
                                <th scope="col" class="py-3">Keterangan</th>
                                <th scope="col" class="py-3">Kategori</th>
                                <th scope="col" class="py-3 text-end">Nominal</th>
                                <th scope="col" class="py-3 text-center">Arus</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    var baseUrl = '<?= base_url("transaction") ?>';

    $(document).ready(function () {
        $('#table-log').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            ordering: false,
            ajax: {
                url: `${baseUrl}/list`,
                type: 'GET',
                data: function (d) {
                    d.mode = 'all';
                },
                dataSrc: function (json) {
                    return json.data || [];
                }
            },
            columns: [
                { 
                    data: 'tanggal',
                    render: function(data) {
                        let date = new Date(data);
                        return `<span class="fw-medium">${date.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</span>`;
                    }
                },
                { 
                    data: 'nama_transaksi',
                    render: function(data) {
                        return `<span class="fw-bold text-dark">${data}</span>`;
                    }
                },
                {
                    data: 'kategori',
                    render: function (data, type, row) {
                        let label = data;
                        let badgeClass = 'bg-light text-dark border';

                        if (data === 'Hutang/Piutang') {
                            let desc = row.nama_transaksi.toLowerCase();

                            if (desc.includes('pinjaman dari')) {
                                label = 'Hutang';
                                badgeClass = 'bg-danger-subtle text-danger border border-danger-subtle';
                            }
                            else if (desc.includes('meminjamkan ke')) {
                                label = 'Piutang';
                                badgeClass = 'bg-info-subtle text-info border border-info-subtle';
                            }
                            else if (desc.includes('pelunasan hutang')) {
                                label = 'Bayar Hutang';
                                badgeClass = 'bg-success-subtle text-success border border-success-subtle';
                            }
                            else if (desc.includes('pelunasan piutang')) {
                                label = 'Terima Piutang';
                                badgeClass = 'bg-primary-subtle text-primary border border-primary-subtle'; 
                            }
                            else {
                                label = 'Hutang/Piutang';
                                badgeClass = 'bg-warning-subtle text-warning-emphasis border border-warning-subtle';
                            }
                        }
                        else {
                            badgeClass = 'bg-light text-secondary border';
                        }

                        return `<span class="badge rounded-pill fw-medium px-3 py-2 ${badgeClass}">
                                    ${label}
                                </span>`;
                    }
                },
                {
                    data: 'harga',
                    className: 'text-end',
                    render: function (data, type, row) {
                        let color = row.type === 'income' ? 'text-success' : 'text-danger';
                        let prefix = row.type === 'income' ? '+' : '-';
                        return `<span class="amount-text fs-6 ${color}">
                                    ${prefix} Rp ${parseFloat(data || 0).toLocaleString('id-ID')}
                                </span>`;
                    }
                },
                {
                    data: 'type',
                    className: 'text-center',
                    render: function(data) {
                        return data === 'income' 
                            ? '<i class="bi bi-arrow-down-circle-fill text-success fs-5" title="Masuk"></i>' 
                            : '<i class="bi bi-arrow-up-circle-fill text-danger fs-5" title="Keluar"></i>';
                    }
                }
            ],
            language: { emptyTable: "Belum ada riwayat transaksi" },
            pageLength: 10
        });
    });
</script>
<?= $this->endSection() ?>