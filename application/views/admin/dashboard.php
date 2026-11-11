<div>
  <div><div><small>Jumlah Event</small><b><?= $r->jml_event ?></b></div></div>
  <div><div><small>Pelanggan</small><b><?= $r->jml_pelanggan ?></b></div></div>
  <div><div><small>Tiket Terjual</small><b><?= $r->tiket_terjual ?></b></div></div>
  <div><div><small>Pendapatan</small><b><?= rupiah($r->pendapatan) ?></b></div></div>
</div>

<?php if ($r->perlu_verifikasi > 0): ?>
  <div>
    <span><b><?= $r->perlu_verifikasi ?></b> pesanan menunggu verifikasi pembayaran.</span>
    <a href="<?= base_url('admin/transaksi?status=Menunggu+Verifikasi') ?>">Periksa sekarang</a>
  </div>
<?php else: ?>
  <div>Tidak ada pesanan yang menunggu verifikasi.</div>
<?php endif; ?>