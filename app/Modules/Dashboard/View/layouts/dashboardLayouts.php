<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= base_url('img/UangSakuLogo.png') ?>" type="image/x-icon">
    <title>Dashboard - Uang Saku</title>

    <!-- Google Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            important: true,
            theme: {
                extend: {
                    colors: {
                        primary: '#FFD600',
                        secondary: '#6c757d',
                    }
                }
            }
        }
    </script>

    <!-- Keep Bootstrap CSS for component behaviors like offcanvas/modal until fully converted -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <!-- Modern DataTable Styling -->
    <style>
        /* Container styling */
        .dataTables_wrapper {
            padding-top: 1rem;
        }
        
        /* Filter/Search styling */
        .dataTables_filter {
            margin-bottom: 1.5rem !important;
            float: none !important;
            text-align: left !important;
        }
        
        /* Length & Info styling */
        .dataTables_length, .dataTables_info {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #9ca3af !important;
            text-transform: uppercase !important;
            letter-spacing: 0.1em !important;
        }
        
        /* Pagination Modern Styling */
        .dataTables_paginate {
            margin-top: 2rem !important;
            display: flex !important;
            justify-content: flex-end !important;
            gap: 0.5rem !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: none !important;
            border-radius: 0.75rem !important;
            padding: 0.5rem 1rem !important;
            font-size: 0.875rem !important;
            font-weight: 700 !important;
            transition: all 0.2s !important;
            background: #f9fafb !important;
            color: #6b7280 !important;
            margin-left: 0 !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f3f4f6 !important;
            color: #000000 !important;
            border: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #FFD600 !important;
            color: #000000 !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            border: none !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background: #f9fafb !important;
            color: #9ca3af !important;
        }
        
        /* Table overrides */
        table.dataTable.no-footer {
            border-bottom: none !important;
        }
        
        table.dataTable thead th {
            border-bottom: 2px solid #f3f4f6 !important;
        }

        /* Processing overlay */
        .dataTables_processing {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(4px) !important;
            border: none !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1) !important;
            border-radius: 1.5rem !important;
            font-weight: 800 !important;
            color: #000000 !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            width: auto !important;
            padding: 2rem !important;
        }
    </style>

    <?= csrf_meta() ?>
</head>

<body class="bg-[#f0f5f0] min-h-screen" style="font-family: 'Inter', sans-serif;">
    <?php
    $request = service('request');
    $currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
    ?>
    <!-- Screen Wrapper -->
    <div class="flex h-screen overflow-hidden bg-gray-50">
        
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 bg-white border-r border-gray-100/50 relative z-20">
            <?= $this->include('../Modules/Dashboard/View/layouts/partials/navbarDashboard') ?>
        </aside>

        <!-- Mobile Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-start border-0 rounded-r-3xl" tabindex="-1" id="sidebarOffcanvas" aria-labelledby="sidebarOffcanvasLabel">
            <div class="offcanvas-body p-0">
                <?= $this->include('../Modules/Dashboard/View/layouts/partials/navbarDashboard') ?>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden relative">
            
            <!-- Topbar -->
            <header class="flex items-center justify-between px-6 py-4 bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-10 mx-6 mt-4 rounded-3xl shadow-sm/50">
                <!-- Mobile Toggle -->
                <div class="lg:hidden mr-4">
                    <button class="p-2 text-gray-500 hover:text-gray-900 transition-colors" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>

                <!-- Page Title / Search -->
                <div class="flex-1 flex items-center">
                   <div class="relative w-full max-w-md hidden md:block">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </div>
                        <input type="text" placeholder="Cari transaksi, menu, atau bantuan..." 
                            class="w-full bg-gray-50/50 border-0 rounded-2xl pl-11 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all placeholder:text-gray-400">
                   </div>
                   <h1 class="text-lg font-bold text-gray-800 md:hidden">Uang Saku</h1>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center gap-3 md:gap-4 ml-4">
                    <!-- Notifications -->
                    <button class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 hover:bg-yellow-50 text-gray-500 hover:text-yellow-600 transition-all">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2.5 right-3 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    <!-- Profile -->
                    <div class="flex items-center gap-3 pl-2 md:pl-4 md:border-l border-gray-100">
                        <div class="text-right hidden md:block">
                            <h6 class="text-sm font-bold text-gray-900 leading-tight">Halo, User!</h6>
                            <span class="text-[10px] text-gray-400 uppercase tracking-wider font-bold">Personal Plan</span>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-100 to-yellow-300 border-2 border-white shadow-sm flex items-center justify-center text-yellow-700 font-bold text-sm">
                            US
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Scroll Area -->
            <main class="flex-1 overflow-y-auto p-2">
                <div class="container mx-auto max-w-7xl pt-4 pb-20">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        function showAlert(type, title, text) {
            Swal.fire({
                icon: type,
                title: title || (type === 'success' ? 'Berhasil' : 'Gagal'),
                text: text,
            });
        }

        // Global DataTable Defaults
        if ($.fn.dataTable) {
            $.extend(true, $.fn.dataTable.defaults, {
                responsive: true,
                language: {
                    search: "",
                    searchPlaceholder: "Cari data...",
                    lengthMenu: "_MENU_",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        previous: '<i data-lucide="chevron-left"></i>',
                        next: '<i data-lucide="chevron-right"></i>'
                    },
                    processing: '<div class="flex items-center justify-center space-x-2"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-black"></div><span>Sedang memuat...</span></div>'
                },
                drawCallback: function() {
                    $('.dataTables_filter input').addClass('w-full md:w-64 border border-gray-300 rounded-xl px-4 py-2 focus:ring-2 focus:ring-yellow-400 outline-none transition-all');
                    $('.dataTables_length select').addClass('border border-gray-300 rounded-lg px-2 py-1 outline-none mx-2 mb-4 focus:ring-2 focus:ring-yellow-400 transition-all');
                    $('.dataTables_paginate').addClass('mt-4');
                    
                    // Re-init Lucide Icons on Draw
                    lucide.createIcons();
                }
            });
        }
        
        $(document).ready(function() {
            lucide.createIcons();
            
            $(document).ajaxComplete(function() {
                lucide.createIcons();
            });
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>

</html>