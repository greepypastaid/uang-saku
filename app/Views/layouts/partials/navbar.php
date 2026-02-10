<?php
$request = service('request');
$currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
?>

<nav class="bg-white shadow-sm border-b sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Brand Mobile -->
            <div class="flex items-center lg:hidden">
                <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" class="w-10 h-10 mr-2">
                <a class="text-xl font-bold text-gray-900" href="/">Uang Saku</a>
            </div>

            <!-- Toggler -->
            <div class="flex items-center lg:hidden">
                <button type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-500"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <i class="bi bi-list text-2xl"></i>
                </button>
            </div>

            <!-- Brand Desktop -->
            <div class="hidden lg:flex items-center">
                <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" class="w-10 h-10 mr-2">
                <a class="text-xl font-bold text-gray-900" href="/">Uang Saku</a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden lg:flex items-center space-x-8">
                <a class="text-sm font-medium <?= $currentPath === '/' ? 'text-black font-bold border-b-2 border-yellow-400 pb-1' : 'text-gray-500 hover:text-gray-900' ?>" href="/">Home</a>
                <a class="text-sm font-medium <?= $currentPath === '/whyus' ? 'text-black font-bold border-b-2 border-yellow-400 pb-1' : 'text-gray-500 hover:text-gray-900' ?>" href="/whyus">Why Us?</a>
                <a class="text-sm font-medium <?= $currentPath === '/about' ? 'text-black font-bold border-b-2 border-yellow-400 pb-1' : 'text-gray-500 hover:text-gray-900' ?>" href="/about">About</a>
                <a class="text-sm font-medium <?= $currentPath === '/contact' ? 'text-black font-bold border-b-2 border-yellow-400 pb-1' : 'text-gray-500 hover:text-gray-900' ?>" href="/contact">Contact</a>
            </div>

            <!-- Desktop Auth Action -->
            <div class="hidden lg:flex items-center">
                <?php if (auth()->loggedIn()) : ?>
                    <a href="/dashboard" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-bold rounded-full shadow-sm text-black bg-primary hover:bg-yellow-400 transition-colors">
                        <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                    </a>
                <?php else : ?>
                    <a href="/register" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-bold rounded-full shadow-sm text-black bg-primary hover:bg-yellow-400 transition-colors">
                        Coba Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="collapse lg:hidden" id="navbarNav">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white border-t">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentPath === '/' ? 'bg-gray-100 text-black font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' ?>">Home</a>
            <a href="/whyus" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentPath === '/whyus' ? 'bg-gray-100 text-black font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' ?>">Why Us?</a>
            <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentPath === '/about' ? 'bg-gray-100 text-black font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' ?>">About</a>
            <a href="/contact" class="block px-3 py-2 rounded-md text-base font-medium <?= $currentPath === '/contact' ? 'bg-gray-100 text-black font-bold' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' ?>">Contact</a>

            <div class="pt-4 pb-2 border-t border-gray-200">
                <?php if (auth()->loggedIn()) : ?>
                    <a href="/dashboard" class="block w-full text-center px-6 py-3 border border-transparent text-base font-bold rounded-full shadow-sm text-black bg-primary hover:bg-yellow-400">
                        <i class="bi bi-speedometer2 mr-2"></i> Dashboard
                    </a>
                <?php else : ?>
                    <a href="/register" class="block w-full text-center px-6 py-3 border border-transparent text-base font-bold rounded-full shadow-sm text-black bg-primary hover:bg-yellow-400">
                        Coba Sekarang
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>