<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Screen - Spark Admin Premium Bootstrap 5 Admin Dashboard Template</title>
    
    <!-- SEO Optimization -->
    <meta name="description" content="Login Screen - Spark Admin Premium Bootstrap 5 Admin Dashboard Template">
    <meta name="author" content="Spark Admin Team">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    
    <!-- Local Third-Party Libraries (100% Offline Compatible) -->
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    
    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<div>
  <div>
    <h2>Daftar Pelanggan</h2>
    <?= form_open('register') ?>
      <?php
      $field = array(
        'nama'       => array('Nama Lengkap', 'text'),
        'email'      => array('Email', 'email'),
        'telepon'    => array('No. Telepon', 'text'),
        'password'   => array('Password', 'password'),
        'konfirmasi' => array('Konfirmasi Password', 'password'),
      );
      foreach ($field as $nama => $d): ?>
      <div>
        <label><?= $d[0] ?></label>
        <input type="<?= $d[1] ?>" name="<?= $nama ?>"
               value="<?= $d[1] === 'password' ? '' : set_value($nama) ?>">
        <?= form_error($nama, '<div>', '</div>') ?>
      </div>
      <?php endforeach; ?>
      <button type="submit">Daftar</button>
    <?= form_close() ?>
    <p>Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk</a></p>
  </div>
</div>

 <!-- Local Bootstrap bundle -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Authentication interactions script -->
    <script src="assets/js/auth.js"></script>
</body>
</html>
