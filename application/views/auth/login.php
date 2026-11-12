<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <meta name="description" content="Login">
    <meta name="author" content="Spark Admin Team">
    
    <link rel="icon" type="image/png" href="assets/images/favicon.ico">
    
    <link rel="stylesheet" href="assets/libs/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/libs/bootstrap-icons/bootstrap-icons.css">
    
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<div>
    <h2>Masuk</h2>
    <?= form_open('login') ?>
      <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= set_value('email') ?>">
        <?= form_error('email', '<div>', '</div>') ?>
      </div>
      <div>
        <label>Password</label>
        <input type="password" name="password">
        <?= form_error('password', '<div>', '</div>') ?>
      </div>
      <button type="submit">Masuk</button>
    <?= form_close() ?>
    <p>Belum punya akun? <a href="<?= base_url('register') ?>">Daftar</a></p>
  </div>
</div>

    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/auth.js"></script>
</body>
</html>
