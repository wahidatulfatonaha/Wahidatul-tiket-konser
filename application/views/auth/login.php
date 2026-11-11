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