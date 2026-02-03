<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .card-dashboard {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 20px; /* Sudut lebih bulat */
    }

    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .icon-box {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Warna Spesifik */
    .bg-income-soft { background-color: #d1fae5; color: #059669; }
    .bg-expense-soft { background-color: #fee2e2; color: #dc2626; }
    .bg-balance-soft { background-color: #e0f2fe; color: #0284c7; }
    
    .text-balance { color: #0284c7; }
    .text-income { color: #059669; }
    .text-expense { color: #dc2626; }
</style>

<div class="container mt-4 mb-5">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold text-dark mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Ringkasan keuangan Anda hari ini.</p>
        </div>
        <div class="mt-3 mt-md-0">
            <a href="<?= base_url('transaction') ?>" class="btn shadow-sm rounded-pill px-4 py-2" 
               style="background-color: #FFD600; color: black;">
               <i class="bi bi-plus-lg me-1"></i> Transaksi Baru
            </a>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        
        <div class="col">
            <div class="card card-dashboard h-100 shadow-sm p-3 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold ls-1">Saldo Saat Ini</span>
                            <h3 class="fw-bold mt-2 text-dark" id="total_saldo">Rp 0</h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i> Total uang tersedia
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-dashboard h-100 shadow-sm p-3 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold ls-1">Total Pemasukan</span>
                            <h3 class="fw-bold mt-2 text-income" id="total_pemasukan">Rp 0</h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-check-circle-fill text-success me-1"></i> Cashflow positif
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card card-dashboard h-100 shadow-sm p-3 bg-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold ls-1">Total Pengeluaran</span>
                            <h3 class="fw-bold mt-2 text-expense" id="total_pengeluaran">Rp 0</h3>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <small class="text-muted">
                            <i class="bi bi-exclamation-circle-fill text-danger me-1"></i> Pantau terus
                        </small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        const formatRupiah = (number) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        };

        $('#total_pengeluaran, #total_pemasukan, #total_saldo').html('<span class="placeholder col-6"></span>');

        $.ajax({
            url: '/dashboard/data',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total_pengeluaran').text(formatRupiah(data.total_pengeluaran || 0));
                $('#total_pemasukan').text(formatRupiah(data.total_pemasukan || 0));
                $('#total_saldo').text(formatRupiah(data.total_saldo || 0));
            },
            error: function (xhr, status, error) {
                console.error('Error fetching dashboard data:', error);
                $('#total_pengeluaran').html('<span class="text-danger fs-6">Gagal memuat</span>');
                $('#total_pemasukan').html('<span class="text-danger fs-6">Gagal memuat</span>');
                $('#total_saldo').html('<span class="text-danger fs-6">Gagal memuat</span>');
            }
        });
    });
</script>
<?= $this->endSection() ?>