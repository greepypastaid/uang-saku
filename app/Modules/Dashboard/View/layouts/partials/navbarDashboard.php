<?php
$request = service('request');
$currentPath = preg_replace('#^/index\.php#', '', $request->getUri()->getPath());
?>

<div class="vh-100">
  <nav class="navbar navbar-expand-lg navbar-dark flex-column align-items-start p-3 border-end bg-white d-none d-lg-flex"
       style="width: 250px; height: 100%;">
    <div class="d-flex align-items-center">
      <img src="/img/UangSakuLogo.png" alt="Uang Saku Logo" width="40" height="40" class="d-inline-block align-text-top me-2" style="transform: scale(1.0);">
      <a class="navbar-brand fw-bold text-black" href="/">Uang Saku </a>
    </div>
    <hr class="w-100" style="border-top: 1px solid #080808;">
    <ul class="navbar-nav flex-column w-100">
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/dashboard' ? ' fw-bold text-black' : '' ?>" href="<?= base_url('/dashboard') ?>" style="font-size: 1.2em;"><i class="bi bi-house-door me-2"></i>Dashboard</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/transaction' ? ' fw-bold text-black' : '' ?>" href="<?= base_url('/transaction') ?>" style="font-size: 1.2em;"><i class="bi bi-arrow-left-right me-2"></i>Transactions</a>
      </li>
      <li class="nav-item w-100">
        <a class="nav-link text-secondary<?= $currentPath === '/wallet' ? ' fw-bold text-black' : '' ?>" href="<?= base_url('/wallet') ?>" style="font-size: 1.2em;"><i class="bi bi-wallet2 me-2"></i>Wallets</a>
      </li>
    </ul>
  </nav>
</div>