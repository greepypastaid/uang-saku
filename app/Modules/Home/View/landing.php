<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center bg-white overflow-hidden py-12 lg:py-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            <!-- Image Section -->
            <div class="w-full lg:w-1/2 order-2 lg:order-1 relative">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-yellow-400 to-yellow-200 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000"></div>
                    <img src="/img/jumbotron.png"
                        class="relative rounded-2xl shadow-2xl transform hover:scale-[1.02] transition duration-500 ease-in-out w-full"
                        alt="App Interface Mockup">
                </div>
            </div>

            <!-- Text Section -->
            <div class="w-full lg:w-1/2 order-1 lg:order-2">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-yellow-50 text-yellow-700 text-sm font-bold mb-6">
                    <span>Uang Saku</span>
                    <span class="w-1 h-1 rounded-full bg-yellow-400"></span>
                    <span class="font-medium text-yellow-600">Finance Tracker App</span>
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 leading-tight mb-6">
                    Tracking Keuangan <br class="hidden md:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-yellow-300">Masa Depan</span><br>
                    Mudah & Praktis!
                </h1>

                <p class="text-lg md:text-xl text-gray-500 mb-10 leading-relaxed max-w-xl">
                    Kelola keuangan Anda dengan mudah menggunakan Uang Saku membantu Anda melacak pengeluaran dan pemasukan dengan mudah!
                </p>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/dashboard" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-full shadow-lg text-black bg-primary hover:bg-yellow-400 hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                        Yuk Coba Sekarang!
                        <i class="bi bi-arrow-right ml-2 text-xl"></i>
                    </a>
                </div>

                <!-- Trust badges or something extra -->
                <div class="mt-12 pt-8 border-t border-gray-100 flex items-center space-x-6 text-gray-400">
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-shield-check text-xl"></i>
                        <span class="text-sm">Secure Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="bi bi-lightning text-xl"></i>
                        <span class="text-sm">Real-time Tracking</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>