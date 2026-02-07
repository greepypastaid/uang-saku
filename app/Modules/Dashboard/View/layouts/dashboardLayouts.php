<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/UangSakuLogo.png') ?>" type="image/x-icon">
    <title>Dashboard - Uang Saku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-header-text {
            flex: 1;
            min-width: 200px;
        }

        .page-header-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        @media (max-width: 576px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .page-header-text {
                text-align: left;
                margin-bottom: 0.5rem;
            }

            .page-header-actions {
                justify-content: center;
                width: 100%;
            }

            .page-header-actions .btn {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 0.75rem !important;
            }

            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }

            h1.fw-bold {
                font-size: 1.5rem;
            }
        }

        .mobile-header {
            display: none;
            position: sticky;
            top: 0;
            z-index: 1050;
            background: #fff;
            padding: 0.75rem 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            align-items: center;
            justify-content: space-between;
        }

        .mobile-header .brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mobile-header .brand img {
            width: 36px;
            height: 36px;
        }

        .mobile-header .brand span {
            font-weight: 700;
            font-size: 1.1rem;
            color: #000;
        }

        .mobile-header .menu-toggle {
            background: none;
            border: none;
            padding: 0.5rem;
            font-size: 1.5rem;
            color: #333;
            cursor: pointer;
        }

        .mobile-header .menu-toggle:hover {
            color: #000;
        }

        @media (max-width: 991.98px) {
            .mobile-header {
                display: flex;
            }
        }

        :root {
            --pagination-active-bg: #FFD600;
            --pagination-active-text: #000000;
            --pagination-hover-bg: #FFF3A0;
            --pagination-border: transparent;
        }

        .dataTables_wrapper .pagination .page-link {
            color: #000;
            border-color: var(--pagination-border);
        }

        .dataTables_wrapper .pagination .page-link:hover {
            color: #000;
            background-color: var(--pagination-hover-bg);
            border-color: var(--pagination-border);
        }

        .dataTables_wrapper .pagination .page-item.active .page-link {
            color: var(--pagination-active-text);
            background-color: var(--pagination-active-bg);
            border-color: var(--pagination-active-bg);
        }

        .dataTables_wrapper .pagination .page-item.disabled .page-link {
            color: #9CA3AF;
        }
    </style>
    <?= csrf_meta() ?> </head>
</head>

<body class="bg-light">
<?php
    $request = service('request');
    $currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
?>
    <!-- Mobile Bar -->
    <div class="mobile-header d-lg-none">
        <div class="brand">
            <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo">
            <span>Uang Saku</span>
        </div>
        <button class="menu-toggle" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- Sidebar mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
        <div class="offcanvas-header">
            <div class="d-flex align-items-center">
                <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40" class="me-2">
                <h5 id="sidebarOffcanvasLabel" class="m-0 fw-bold">Uang Saku</h5>
            </div>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="navbar bg-white p-3">
                <ul class="navbar-nav flex-column w-100">
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/dashboard' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/transaction' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/transaction') ?>">Transactions</a>
                    </li>
                     <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/budget' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/budget') ?>">Budget Limitator</a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/hutangpiutang' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/hutangpiutang') ?>">Hutang & Piutang</a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/wallet' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/wallet') ?>">Wallets</a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/logmutasi' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/transaction/log') ?>">Log Mutasi</a>
                    </li>
                    <li class="nav-item w-100">
                        <a class="nav-link text-secondary<?= preg_replace('#^/index\.php#', '', service('request')->getUri()->getPath()) === '/wallet' ? ' fw-bold text-black' : '' ?>"
                            href="<?= base_url('/logout') ?>">Logout</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 py-0 d-none d-lg-block">
                <div class="position-fixed vh-100 overflow-auto" style="">
                    <?= $this->include('../Modules/Dashboard/View/layouts/partials/navbarDashboard') ?>
                </div>
            </div>
            <div class="col-12 col-lg-10 offset-lg-2 p-0 d-flex flex-column" style="min-height: 100vh;">
                <main class="">
                    <?= $this->renderSection('content') ?>
                </main>
                <?= $this->include('../Modules/Dashboard/View/layouts/partials/footerDashboard') ?>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAlert(type, title, text) {
            Swal.fire({
                icon: type,
                title: title || (type === 'success' ? 'Berhasil' : 'Gagal'),
                text: text,
            });
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>