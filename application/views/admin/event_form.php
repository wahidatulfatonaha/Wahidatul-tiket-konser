<div>
<?= form_open('admin/event_form' . ($event ? '/' . $event->id : '')) ?>
  <div>
    <label>Nama Event</label>
    <input name="nama" value="<?= set_value('nama', $event ? $event->nama : '') ?>">
    <?= form_error('nama', '<div>', '</div>') ?>
  </div>

  <div>
    <div>
      <label>Kategori</label>
      <select name="kategori_id">
        <?php foreach ($kategori as $k): ?>
          <option value="<?= $k->id ?>" <?= set_select('kategori_id', $k->id, $event && $event->kategori_id == $k->id) ?>><?= htmlspecialchars($k->nama) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div>
      <label>Tanggal &amp; Jam</label>
      <input type="datetime-local" name="tanggal" value="<?= set_value('tanggal', $event ? date('Y-m-d\TH:i', strtotime($event->tanggal)) : '') ?>">
      <?= form_error('tanggal', '<div>', '</div>') ?>
    </div>
  </div>

  <div>
    <label>Lokasi</label>
    <input name="lokasi" value="<?= set_value('lokasi', $event ? $event->lokasi : '') ?>">
    <?= form_error('lokasi', '<div>', '</div>') ?>
  </div>

  <div>
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4"><?= set_value('deskripsi', $event ? $event->deskripsi : '') ?></textarea>
  </div>

  <div>
    <label>Status</label>
    <select name="status">
      <option value="aktif" <?= set_select('status', 'aktif', !$event || $event->status === 'aktif') ?>>Aktif</option>
      <option value="selesai" <?= set_select('status', 'selesai', $event && $event->status === 'selesai') ?>>Selesai</option>
    </select>
  </div>

  <button type="submit">Simpan</button>
  <a href="<?= base_url('admin/events') ?>">Batal</a>
<?= form_close() ?>
</div>