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