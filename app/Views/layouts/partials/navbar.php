<!-- kata gemini pakai request dulu biar muncul itu buat bagian penanda activenya -->
<?php $request = service('request'); $currentPath = $request->getUri()->getPath(); ?>
<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="d-flex align-items-center">
                    <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40" class="d-inline-block align-text-top me-2" style="transform: scale(1.0);">
                    <a class="navbar-brand fw-bold" href="/">Uang Saku</a>
                </div>
                
                <ul class="navbar-nav d-flex flex-row gap-2">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath == '/index.php/' ? 'fw-bold text-black' : '' ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath == '/index.php/whyus' ? 'fw-bold text-black' : '' ?>" href="/whyus">Why Us?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath == '/index.php/about' ? 'fw-bold text-black' : '' ?>" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath == '/index.php/contact' ? 'fw-bold text-black' : '' ?>" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div>
                    <a href="/dashboard" class="btn rounded-pill px-4 fw-bold" style="background-color: #FFD600; color: #000000; border: none;">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>