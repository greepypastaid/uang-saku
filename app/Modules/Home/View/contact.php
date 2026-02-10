<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
    <div class="max-w-xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Hubungi Kami</h1>
            <p class="text-lg text-gray-500">
                Ada pertanyaan tentang Uang Saku? Kami siap membantu Anda mengelola keuangan dengan lebih baik.
            </p>
        </div>

        <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
            <form action="#" method="POST" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all"
                        placeholder="Masukkan nama Anda">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all"
                        placeholder="Masukkan email Anda">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Pesan</label>
                    <textarea name="message" id="message" rows="4" required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all"
                        placeholder="Tulis pesan Anda disini..."></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-8 py-4 bg-primary hover:bg-yellow-400 text-black font-bold rounded-full shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                        Kirim Pesan
                        <i class="bi bi-send ml-2 text-lg"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact info -->
        <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-8 text-center sm:text-left">
            <div>
                <h6 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Email Support</h6>
                <p class="text-gray-500">support@uangsaku.id</p>
            </div>
            <div>
                <h6 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Lokasi</h6>
                <p class="text-gray-500">Jakarta, Indonesia</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>