<div>
  <h2>Daftar Tiket</h2>

  <?php if (empty($events)): ?>
    <div>Belum ada event.</div>
  <?php endif; ?>

  <div>
    <?php foreach ($events as $e): ?>
    <div>
      <div>
        <div><span><?= htmlspecialchars($e->kategori) ?></span></div>
        <div>
          <h5><?= htmlspecialchars($e->nama) ?></h5>
          <div>TANGGAL = <?= date('d M Y, H:i', strtotime($e->tanggal)) ?></div>
          <div>LOKASI = <?= htmlspecialchars($e->lokasi) ?></div>
          <div>
            <span><?= $e->harga_min !== NULL ? rupiah($e->harga_min) : '-' ?></span>
            <span>Sisa <?= (int)$e->sisa ?></span>
          </div>
          <a href="<?= base_url('event/' . $e->id) ?>">Pilih Tiket</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>