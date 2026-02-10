<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6">Mengapa Memilih Uang Saku?</h1>
        <p class="text-xl text-gray-500 leading-relaxed">
            Uang Saku adalah solusi finance tracker yang membantu Anda mencapai tujuan keuangan dengan fitur-fitur canggih and antarmuka yang ramah pengguna.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
        <!-- Feature 1 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0 mr-6">
                    <i class="bi bi-cash-stack text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-xl font-bold text-gray-900 mb-2">Pelacakan Otomatis</h5>
                    <p class="text-gray-500 leading-relaxed">Otomatisasi pelacakan transaksi untuk menghemat waktu and mengurangi kesalahan manual.</p>
                </div>
            </div>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0 mr-6">
                    <i class="bi bi-bar-chart-line text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-xl font-bold text-gray-900 mb-2">Laporan Detail</h5>
                    <p class="text-gray-500 leading-relaxed">Dapatkan insight mendalam dengan laporan keuangan yang visual and mudah dipahami.</p>
                </div>
            </div>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0 mr-6">
                    <i class="bi bi-lock-fill text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-xl font-bold text-gray-900 mb-2">Privasi & Keamanan</h5>
                    <p class="text-gray-500 leading-relaxed">Data Anda dilindungi dengan teknologi enkripsi terdepan, sehingga aman dari ancaman.</p>
                </div>
            </div>
        </div>

        <!-- Feature 4 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-start">
                <div class="w-14 h-14 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-600 flex-shrink-0 mr-6">
                    <i class="bi bi-phone text-2xl"></i>
                </div>
                <div>
                    <h5 class="text-xl font-bold text-gray-900 mb-2">Akses Dimana Saja</h5>
                    <p class="text-gray-500 leading-relaxed">Kelola keuangan Anda dari perangkat apa saja, kapan saja, dengan aplikasi mobile-friendly.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-20 text-center">
        <a href="/dashboard" class="inline-flex items-center px-8 py-4 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            Coba Gratis Sekarang
            <i class="bi bi-arrow-right ml-2 text-xl"></i>
        </a>
    </div>
</div>
<?= $this->endSection() ?>