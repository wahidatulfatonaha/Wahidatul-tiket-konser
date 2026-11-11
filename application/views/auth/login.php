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

    <!-- Local Bootstrap bundle -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Authentication interactions script -->
    <script src="assets/js/auth.js"></script>
</body>
</html>
