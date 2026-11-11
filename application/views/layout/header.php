<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $title ?></title>
</head>
<body>
<?php $u = user_login(); ?>
<nav>
  <div>
    <a href="<?= base_url() ?>">TiketKonser</a>
    <div>
      <?php if ($u && $u['role'] === 'admin'): ?>
        <a href="<?= base_url('admin') ?>">Panel Admin</a>
        <a href="<?= base_url('logout') ?>">Keluar</a>
      <?php elseif ($u): ?>
        <a href="<?= base_url('pelanggan') ?>">Jenis Tiket</a>
        <a href="<?= base_url('pelanggan/pesanan') ?>">Pesanan Saya</a>
        <a href="<?= base_url('logout') ?>">Keluar</a>
      <?php else: ?>
        <a href="<?= base_url('login') ?>">Masuk</a>
        <a href="<?= base_url('register') ?>">Daftar</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div>
  <?php if ($m = $this->session->flashdata('success')): ?><div><?= htmlspecialchars($m) ?></div><?php endif; ?>
  <?php if ($m = $this->session->flashdata('error')): ?><div><?= htmlspecialchars($m) ?></div><?php endif; ?>
</div>