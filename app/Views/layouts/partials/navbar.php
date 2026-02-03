<?php 
$request = service('request'); 
$currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath()); 
?>

<nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
    <div class="container">
        <div class="d-flex align-items-center d-lg-none">
            <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40" class="me-2">
            <a class="navbar-brand fw-bold mb-0" href="/">Uang Saku</a>
        </div>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex justify-content-between align-items-center w-100 flex-column flex-lg-row">
                
                <div class="d-none d-lg-flex align-items-center">
                    <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40" class="d-inline-block align-text-top me-2">
                    <a class="navbar-brand fw-bold mb-0" href="/">Uang Saku</a>
                </div>
                
                <ul class="navbar-nav d-flex flex-column flex-lg-row gap-2 my-3 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath === '/' ? 'fw-bold text-black' : '' ?>" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath === '/whyus' ? 'fw-bold text-black' : '' ?>" href="/whyus">Why Us?</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath === '/about' ? 'fw-bold text-black' : '' ?>" href="/about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPath === '/contact' ? 'fw-bold text-black' : '' ?>" href="/contact">Contact</a>
                    </li>
                </ul>
                
                <div class="mt-2 mt-lg-0">
                    <?php if (auth()->loggedIn()) : ?>
                        <a href="/dashboard" class="btn rounded-pill px-4 fw-bold w-100 w-lg-auto" style="background-color: #FFD600; color: #000000; border: none;">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    <?php else : ?>
                        <a href="/register" class="btn rounded-pill px-4 fw-bold w-100 w-lg-auto" style="background-color: #FFD600; color: #000000; border: none;">
                            Coba Sekarang
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</nav>