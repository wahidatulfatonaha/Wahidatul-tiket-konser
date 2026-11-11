<div class="container py-4">
  <h2 class="mb-3">Pesanan Saya</h2>
  <div class="panel table-responsive">
    <table class="table table-dark align-middle mb-0">
      <thead><tr><th>Kode</th><th>Event</th><th>Tiket</th><th>Jml</th><th>Total</th><th>Metode</th><th>Bukti</th><th>Status</th></tr></thead>
      <tbody>
      <?php foreach ($pesanan as $p): ?>
        <tr>
          <td><?= $p->kode ?></td>
          <td><?= htmlspecialchars($p->event) ?></td>
          <td><?= htmlspecialchars($p->tiket) ?></td>
          <td><?= $p->jumlah ?></td>
          <td><?= rupiah($p->total) ?></td>
          <td><?= htmlspecialchars($p->metode_bayar) ?></td>
          <td>
            <?php if ($p->bukti_bayar): ?>
              <a href="<?= base_url('uploads/bukti/' . $p->bukti_bayar) ?>" target="_blank">Lihat</a>
            <?php elseif ($p->status === 'Menunggu Pembayaran'): ?>
              <?= form_open_multipart('pelanggan/upload_bukti/' . $p->kode, 'class="d-flex gap-1"') ?>
                <input type="file" name="bukti" class="form-control form-control-sm" style="min-width:170px" required>
                <button class="btn btn-neon btn-sm">Kirim</button>
              <?= form_close() ?>
              <small class="muted">Bayar sebelum <?= date('d M, H:i', strtotime($p->batas_bayar)) ?></small>
            <?php else: ?>
              <span class="muted">-</span>
            <?php endif; ?>
          </td>
          <td><?= badge_status($p->status) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$pesanan): ?>
        <tr><td colspan="8" class="text-center muted py-4">Belum ada pesanan. <a href="<?= base_url('pelanggan') ?>">Lihat daftar tiket</a></td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>