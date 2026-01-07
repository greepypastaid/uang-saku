<?php $request = service('request');
$currentPath = $request->getUri()->getPath(); ?>
<div class="vh-100">
  <nav class="navbar navbar-expand-lg navbar-dark flex-column align-items-start p-3"
    style="width: 250px; height: 100%; background-color: #2196f3;">
    <div class="d-flex align-items-center">
      <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40"
        class="d-inline-block align-text-top me-2" style="transform: scale(1.0);">
      <a class="navbar-brand fw-bold" href="/" style="">Uang Saku </a>
    </div>
    <hr class="w-100" style="border-top: 1px solid #ffffff;">
    <ul class="navbar-nav flex-column w-100">
      <li class="nav-item w-100">
        <a class="nav-link <?= $currentPath == '/index.php/dashboard' ? 'fw-bold text-white' : '' ?>"
          href="<?= base_url('/dashboard') ?>">Dashboard</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link <?= ($currentPath == '/index.php/transaction') ? 'fw-bold text-white' : '' ?>"
          href="/transaction">Transactions</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link <?= ($currentPath == '/index.php/wallet') ? 'fw-bold text-white' : '' ?>"
          href="<?= base_url('/wallet') ?>">Wallets</a>
      </li>
    </ul>
  </nav>
</div>