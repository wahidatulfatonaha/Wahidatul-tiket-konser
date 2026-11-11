<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $title ?> - Admin</title>
</head>
<body>
<?php
$seg = $this->uri->segment(2);
$menu = array(
    ''          => 'Dashboard',
    'events'    => 'Kelola Event',
    'tiket'     => 'Jenis Tiket',
    'pemesan'   => 'Data Pemesan',
    'transaksi' => 'Transaksi',
    'laporan'   => 'Laporan',
);
?>
<div><div>
  <div>
    <a href="<?= base_url() ?>">TiketKonser</a>
    <?php foreach ($menu as $k => $v): ?>
     <a href="<?= base_url('admin' . ($k ? '/' . $k : '')) ?>"><?= $v ?></a>
    <?php endforeach; ?>
    <hr>
    <a href="<?= base_url() ?>">&larr; Landing Page</a>
    <a href="<?= base_url('logout') ?>">Keluar</a>
  </div>
  <div>
    <?php if ($m = $this->session->flashdata('success')): ?><div><?= htmlspecialchars($m) ?></div><?php endif; ?>
    <?php if ($m = $this->session->flashdata('error')): ?><div><?= htmlspecialchars($m) ?></div><?php endif; ?>
    <h2><?= $title ?></h2>