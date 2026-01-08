<?= $this->extend('../Modules/Dashboard/View/layouts/dashboardLayouts') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="">
        <h1 class="fw-bold">Dashboard</h1>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="mb-0">Selamat datang di dashboard Anda!</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <div class="col">
                <div class="card h-100 p-3 shadow-sm border-0">
                    <h3 class="fs-5 text-secondary">Total Pengeluaran</h3>
                    <h5 class="fw-bold" id="total_pengeluaran"></h5>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 p-3 shadow-sm border-0">
                    <h3 class="fs-5 text-secondary">Total Pemasukan</h3>
                    <h5 class="fw-bold" id="total_pemasukan"></h5>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 p-3 shadow-sm border-0">
                    <h3 class="fs-5 text-secondary">Saldo Sekarang</h3>
                    <h5 class="fw-bold" id="total_saldo"></h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $.ajax({
            url: '/dashboard/data',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#total_pengeluaran').text('Rp ' + (data.total_pengeluaran || 0).toLocaleString());
                $('#total_pemasukan').text('Rp ' + (data.total_pemasukan || 0).toLocaleString());
                $('#total_saldo').text('Rp ' + (data.total_saldo || 0).toLocaleString());
            },
            error: function (xhr, status, error) {
                console.error('Error fetching dashboard data:', error);
                $('#total_pengeluaran').text('Error loading');
                $('#total_pemasukan').text('Error loading');
                $('#total_saldo').text('Error loading');
            }
        });
    });
</script>
<?= $this->endSection() ?>