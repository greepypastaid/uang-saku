<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Dummy bikinan AI -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-center mb-4">Hubungi Kami</h1>
            <p class="lead text-muted text-center mb-5">
                Ada pertanyaan tentang Uang Saku? Kami siap membantu Anda mengelola keuangan dengan lebih baik.
            </p>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Pesan</label>
                    <textarea class="form-control" id="message" rows="4" placeholder="Tulis pesan Anda"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-lg rounded-pill px-4 py-3 fw-bold" style="background-color: #FFD600; color: #000000; border: none;">
                        Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
