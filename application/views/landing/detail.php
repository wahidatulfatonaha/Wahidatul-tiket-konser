<div>
  <a href="<?= base_url('#tiket') ?>">&larr; Kembali</a>
  <div>

    <div>
      <div>
        <span>Event</span>
      </div>
      <h1><?= htmlspecialchars($event->nama) ?></h1>
      <p>📅 <?= date('d M Y, H:i', strtotime($event->tanggal)) ?> &nbsp;|&nbsp; 📍 <?= htmlspecialchars($event->lokasi) ?></p>
      <?php if ($selesai): ?>
        <div>Event ini sudah selesai. Pemesanan ditutup.</div>
      <?php endif; ?>
      <p><?= nl2br(htmlspecialchars($event->deskripsi)) ?></p>
    </div>

    <div>
      <div>
        <h4>Pilih Tiket</h4>
        <?php if (!$tiket): ?><p>Jenis tiket belum tersedia.</p><?php endif; ?>

        <?php foreach ($tiket as $t): ?>
          <div>
            <div>
              <b><?= htmlspecialchars($t->nama) ?></b>
              <span><?= rupiah($t->harga) ?></span>
            </div>
            <div>
              <small>Sisa <?= (int)$t->sisa ?> dari <?= (int)$t->kuota ?></small>
              <?php if ($selesai): ?>
                <span>Selesai</span>
              <?php elseif ($t->sisa <= 0): ?>
                <span>Habis</span>
              <?php else: ?>
                <a href="<?= base_url('pesan/' . $t->id) ?>">Pesan</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</div>