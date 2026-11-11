<section>
  <div>
    <h1>Nikmati <em>Acara </em><br>Yang Tak Terlupakan</h1>
    <p>Pesan tiket konser dan event lokal favoritmu dengan mudah.</p>
  </div>
</section>

<section id="tiket">
  <h2>Tiket Tersedia</h2>

  <?php if (empty($events)): ?>
    <div>Belum ada event.</div>
  <?php endif; ?>

  <div>
    <?php foreach ($events as $e): ?>
    <div>
      <div>
        <div><span><?= htmlspecialchars($e->kategori) ?></span></div>
        <div>
          <h4><?= htmlspecialchars($e->nama) ?></h4>
          <div>TANGGAL = <?= date('d M Y, H:i', strtotime($e->tanggal)) ?></div>
          <div>LOKASI = <?= htmlspecialchars($e->lokasi) ?></div>
          <div>
            <div>
              <small>Mulai dari</small>
              <span>Rp <?= number_format($e->harga_min, 0, ',', '.') ?></span>
            </div>
            <span>Sisa <?= (int)$e->sisa ?></span>
          </div>
          <a href="<?= base_url('event/' . $e->id) ?>">Lihat Tiket</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</section>