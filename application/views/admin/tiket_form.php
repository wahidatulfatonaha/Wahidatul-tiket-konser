<div>
  <p>Event: <b><?= htmlspecialchars($event->nama) ?></b></p>
  <?php if ($tiket): ?>
    <p>Sudah terjual <?= (int)$tiket->terjual ?> tiket. Untuk menambah stok, naikkan angka kuota.</p>
  <?php endif; ?>

  <?= form_open('admin/tiket_form/' . $event->id . ($tiket ? '/' . $tiket->id : '')) ?>
    <div>
      <label>Nama Jenis Tiket</label>
      <input name="nama" placeholder="Regular / VIP" value="<?= set_value('nama', $tiket ? $tiket->nama : '') ?>">
      <?= form_error('nama', '<div>', '</div>') ?>
    </div>
    <div>
      <label>Harga (Rp)</label>
      <input name="harga" value="<?= set_value('harga', $tiket ? $tiket->harga : '') ?>">
      <?= form_error('harga', '<div>', '</div>') ?>
    </div>
    <div>
      <label>Kuota (total stok)</label>
      <input name="kuota" value="<?= set_value('kuota', $tiket ? $tiket->kuota : '') ?>">
      <?= form_error('kuota', '<div>', '</div>') ?>
    </div>
    <button type="submit">Simpan</button>
    <a href="<?= base_url('admin/tiket') ?>">Batal</a>
  <?= form_close() ?>
</div>