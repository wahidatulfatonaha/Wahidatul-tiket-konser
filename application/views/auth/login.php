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

  <div class="login-wrapper">
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <div class="login-card">
            
            <a href="index.html" class="login-brand text-decoration-none">
                <i class="bi bi-asterisk"></i>
                <span>Tiket Konser</span>
            </a>
            
            <p class="login-subtitle">Masuk untuk mengakses Dashboard</p>

      <div>
    <?= form_open('login') ?>
      <div class="login-form-group">
          <label for="email" class="login-form-label">Email Address</label>
          <div class="login-input-group">
              <i class="bi bi-envelope input-icon"></i>
              <input type="email" id="email" name="email" class="login-input" value="<?= set_value('email') ?>">
              <?= form_error('email', '<div>', '</div>') ?>
          </div>
      </div>
      <div class="login-form-group">
          <label for="password" class="login-form-label">Password</label>
          <div class="login-input-group">
              <i class="bi bi-shield-lock input-icon"></i>
              <input type="password" id="password" name="password" class="login-input">
              <?= form_error('password', '<div>', '</div>') ?>
              <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                  <i class="bi bi-eye"></i>
              </button>
          </div>
      </div>
      <button type="submit" class="btn-login" id="btn-submit">
          <span>Masuk</span>
          <i class="bi bi-arrow-right"></i>
      </button>
    <?= form_close() ?>
    <p class="login-footer-text">
        Belum punya akun? <a href="<?= base_url('register') ?>">Daftar</a>
    </p>
  </div>
</div>

    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/auth.js"></script>
</body>
</html>
