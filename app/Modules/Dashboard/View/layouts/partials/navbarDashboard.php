<?php
$request = service('request');
$currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
?>

<!-- Sidebar Brand -->
<div class="flex items-center justify-center h-24 mb-6">
    <a href="<?= base_url('/') ?>" class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center">
            <img src="/img/UangSakuLogo.png" alt="Logo" class="w-10 h-10">
        </div>
        <h1 class="text-xl font-black text-gray-900 tracking-tight">Uang <span class="text-yellow-500">Saku</span></h1>
    </a>
</div>

<!-- Navigation Menu -->
<nav class="flex-1 px-4 space-y-2 overflow-y-auto">
    <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Menu Utama</p>
    
    <a href="<?= base_url('/dashboard') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/dashboard' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/dashboard' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="layout-grid" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Dashboard</span>
    </a>

    <a href="<?= base_url('/transaction') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/transaction' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/transaction' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="repeat" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Transaksi</span>
    </a>

    <a href="<?= base_url('/transaction/log') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/transaction/log' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/transaction/log' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="clock" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Riwayat</span>
    </a>

    <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-6 mb-2">Keuangan</p>

    <a href="<?= base_url('/wallet') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/wallet' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/wallet' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="credit-card" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Dompet</span>
    </a>

    <a href="<?= base_url('/budget') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/budget' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/budget' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="pie-chart" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Budget</span>
    </a>

    <a href="<?= base_url('/hutangpiutang') ?>" 
       class="flex items-center px-4 py-2 rounded-2xl transition-all duration-300 group <?= $currentPath === '/hutangpiutang' ? 'bg-primary text-black font-bold shadow-lg shadow-yellow-200' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' ?>">
        <div class="mr-3.5 <?= $currentPath === '/hutangpiutang' ? 'text-black' : 'text-gray-400 group-hover:text-yellow-500 transition-colors' ?>">
            <i data-lucide="users" class="w-5 h-5"></i>
        </div>
        <span class="text-sm">Hutang</span>
    </a>
</nav>

<!-- Logout Section -->
<div class="p-4 mt-auto">
    <div class="bg-gray-50 rounded-2xl p-4">
        <a id="logout-link" href="<?= base_url('/logout') ?>" 
           class="flex items-center justify-center w-full py-3 bg-white text-red-500 font-bold rounded-xl shadow-sm hover:shadow-md hover:text-red-600 transition-all border border-gray-100">
            <i data-lucide="log-out" class="w-5 h-5 mr-2"></i> Logout
        </a>
    </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const logout = document.getElementById('logout-link');
    if (!logout) return;

    logout.addEventListener('click', function(e) {
      e.preventDefault();
      const href = this.href;
      const doLogout = () => window.location.href = href;

      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: 'Yakin ingin logout?',
          text: 'Anda akan keluar dari akun Anda.',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, Logout',
          cancelButtonText: 'Batal',
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#6b7280',
        }).then((res) => {
          if (res.isConfirmed) doLogout();
        });
      } else {
        if (confirm('Yakin ingin logout?')) doLogout();
      }
    });
  });
</script>