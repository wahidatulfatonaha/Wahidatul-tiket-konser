<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    
    <meta name="description" content="Register">
    <meta name="author" content="Spark Admin Team">
    
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card">
            
            <a href="index.html" class="login-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>Tiket Konser</span>
            </a>
            
            <p class="login-subtitle">Daftar agar punya Akun</p>

<div>
  <div>
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
      <br>
      <button type="submit" class="btn-login" id="btn-submit">
          <span>Daftar</span>
          <i class="bi bi-arrow-right"></i>
      </button>
    <?= form_close() ?>
    <p>Sudah punya akun? <a href="<?= base_url('login') ?>">Masuk</a></p>
  </div>
</div>

    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/auth.js"></script>
</body>
</html>
