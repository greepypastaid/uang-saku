<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
    <!-- Header Section -->
    <div class="text-center max-w-3xl mx-auto mb-16">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-6">Tentang Uang Saku</h1>
        <p class="text-xl text-gray-500 leading-relaxed">
            Uang Saku adalah aplikasi finance tracker yang dirancang untuk membantu Anda mengelola keuangan pribadi dengan mudah dan efisien. Dari pelacakan pengeluaran hingga perencanaan anggaran, kami hadir untuk membuat hidup finansial Anda lebih terorganisir.
        </p>
    </div>

    <!-- Features Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-500 mb-6 group-hover:bg-yellow-200 transition-colors">
                <i class="bi bi-graph-up text-3xl"></i>
            </div>
            <h5 class="text-xl font-bold text-gray-900 mb-3">Pelacakan Real-Time</h5>
            <p class="text-gray-500">Pantau pengeluaran dan pemasukan Anda secara real-time dengan laporan yang akurat.</p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-500 mb-6">
                <i class="bi bi-shield-check text-3xl"></i>
            </div>
            <h5 class="text-xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h5>
            <p class="text-gray-500">Data keuangan Anda aman dengan enkripsi tingkat tinggi dan autentikasi yang ketat.</p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 hover:shadow-xl transition-shadow duration-300 flex flex-col items-center text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center text-yellow-500 mb-6">
                <i class="bi bi-lightning-charge text-3xl"></i>
            </div>
            <h5 class="text-xl font-bold text-gray-900 mb-3">Mudah Digunakan</h5>
            <p class="text-gray-500">Interface yang intuitif memungkinkan Anda mengelola keuangan tanpa kesulitan.</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="mt-20 text-center">
        <a href="/dashboard" class="inline-flex items-center px-8 py-4 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
            Mulai Sekarang
            <i class="bi bi-arrow-right ml-2 text-xl"></i>
        </a>
    </div>
</div>
<?= $this->endSection() ?>