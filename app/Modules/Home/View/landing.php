<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-vh-100 d-flex align-items-center bg-white overflow-hidden" style="margin-top: -3rem;">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1 position-relative">
                <img src="/img/jumbotron.png"
                    class="img-fluid" alt="App Interface Mockup" style="transform: scale(1.1);">
            </div>
            <div class="col-lg-6 order-1 order-lg-2 ps-lg-5">
                <p class="lead pe-lg-5">
                    <strong class="fw-bold">Uang Saku -</strong> <span>Finance Tracker App</span>
                </p>
                <h1 class="display-3 fw-bold mb-4" style="text-align: justify;">
                    Tracking Keuangan<br>
                    Masa Depan<br>
                    Mudah & Praktis!
                </h1>

                <p class="lead text-secondary mb-5 pe-lg-5">
                    Kelola keuangan Anda dengan mudah menggunakan Uang Saku membantu Anda melacak pengeluaran dan pemasukan dengan mudah!
                </p>

                <div class="d-flex gap-3 mb-5">
                    <a href="/dashboard" class="btn fw-bold rounded-pill px-4 py-3" style="background-color: #FFD600; color: #000000; border: none;">
                        Yuk Coba Sekarang!
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?= $this->endSection() ?>