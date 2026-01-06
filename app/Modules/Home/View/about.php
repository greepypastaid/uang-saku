<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Dummy bikinan AI -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <h1 class="display-4 fw-bold mb-4">Tentang Uang Saku</h1>
            <p class="lead text-muted mb-5">
                Uang Saku adalah aplikasi finance tracker yang dirancang untuk membantu Anda mengelola keuangan pribadi dengan mudah dan efisien. Dari pelacakan pengeluaran hingga perencanaan anggaran, kami hadir untuk membuat hidup finansial Anda lebih terorganisir.
            </p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Pelacakan Real-Time</h5>
                    <p class="card-text text-muted">Pantau pengeluaran dan pemasukan Anda secara real-time dengan laporan yang akurat.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-shield-check fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Keamanan Terjamin</h5>
                    <p class="card-text text-muted">Data keuangan Anda aman dengan enkripsi tingkat tinggi dan autentikasi yang ketat.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="bi bi-lightning-charge fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Mudah Digunakan</h5>
                    <p class="card-text text-muted">Interface yang intuitif memungkinkan Anda mengelola keuangan tanpa kesulitan.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-6 text-center">
            <a href="/dashboard" class="btn btn-lg rounded-pill px-4 py-3 fw-bold" style="background-color: #FFD600; color: #000000; border: none;">
                Mulai Sekarang
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
