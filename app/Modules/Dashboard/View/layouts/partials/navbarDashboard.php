<?php
$request = service('request');
$currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
?>

<div class="vh-100">
  <nav
    class="navbar navbar-expand-lg navbar-dark flex-column align-items-start p-3 border-end bg-white d-none d-lg-flex"
    style="width: 250px; height: 100%;">
    <div class="d-flex align-items-center">
      <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40"
        class="d-inline-block align-text-top me-2" style="transform: scale(1.0);">
      <a class="navbar-brand fw-bold text-black" href="/">Uang Saku </a>
    </div>
    <hr class="w-100" style="border-top: 1px solid #080808;">
    <ul class="navbar-nav flex-column w-100">
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/dashboard' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/dashboard') ?>" style="font-size: 1.2em;"><i
            class="bi bi-house-door me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/transaction' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/transaction') ?>" style="font-size: 1.2em;"><i
            class="bi bi-arrow-left-right me-2"></i>Transactions</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/hutangpiutang' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/hutangpiutang') ?>" style="font-size: 1.2em;"><i
            class="bi bi-credit-card-2-front me-2"></i>Hutang & Piutang</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/wallet' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/wallet') ?>" style="font-size: 1.2em;"><i class="bi bi-wallet2 me-2"></i>Wallets</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/transaction/log' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/transaction/log') ?>" style="font-size: 1.2em;"><i
            class="bi bi-card-list me-2"></i>Log Mutasi</a>
      </li>
      <li class="nav-item w-100">
        <a id="logout-link"
          class="nav-link text-secondary<?= $currentPath === '/logout' ? ' fw-bold text-black' : '' ?>"
          href="<?= base_url('/logout') ?>" style="font-size: 1.2em;"><i
            class="bi bi-box-arrow-right me-2"></i>Logout</a>
      </li>
    </ul>
  </nav>

  <script> // popup logout ya c
    document.addEventListener('DOMContentLoaded', function () {
      const logout = document.getElementById('logout-link');
      if (!logout) return;

      logout.addEventListener('click', function (e) {
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
            cancelButtonText: 'Batal'
          }).then((res) => { if (res.isConfirmed) doLogout(); });
        } else {
          if (confirm('Yakin ingin logout?')) doLogout();
        }
      });
    });
  </script>
</div>