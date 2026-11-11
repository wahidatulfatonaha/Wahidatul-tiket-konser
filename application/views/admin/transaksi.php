<form method="get">
  <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari kode / pemesan / event">
  <select name="status">
    <option value="">Semua Status</option>
    <?php foreach (array('Menunggu Pembayaran', 'Menunggu Verifikasi', 'Berhasil', 'Dibatalkan') as $s): ?>
      <option <?= $st === $s ? 'selected' : '' ?>><?= $s ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Cari</button>
</form>

<div>
  <table>
    <thead>
      <tr><th>Kode</th><th>Pemesan</th><th>Event / Tiket</th><th>Jml</th><th>Total</th><th>Metode</th><th>Bukti</th><th>Status</th><th></th></tr>
    </thead>
    <tbody>
    <?php foreach ($pesanan as $p): ?>
      <tr>
        <td><?= $p->kode ?><br><small><?= date('d M H:i', strtotime($p->created_at)) ?></small></td>
        <td><?= htmlspecialchars($p->nama_pemesan) ?><br><small><?= htmlspecialchars($p->telepon) ?></small></td>
        <td><?= htmlspecialchars($p->event) ?><br><small><?= htmlspecialchars($p->tiket) ?> @ <?= rupiah($p->harga) ?></small></td>
        <td><?= $p->jumlah ?></td>
        <td><?= rupiah($p->total) ?></td>
        <td><?= htmlspecialchars($p->metode_bayar) ?></td>
        <td><?= $p->bukti_bayar ? '<a href="' . base_url('uploads/bukti/' . $p->bukti_bayar) . '" target="_blank">Lihat</a>' : '<span>Belum upload</span>' ?></td>
        <td><?= badge_status($p->status) ?></td>
        <td>
          <?php if ($p->status === 'Menunggu Verifikasi'): ?>
            <a href="<?= base_url('admin/verifikasi/' . $p->id) ?>" onclick="return confirm('Bukti sudah sesuai? Verifikasi pesanan ini.')">Verifikasi</a>
          <?php endif; ?>
          <?php if ($p->status !== 'Dibatalkan'): ?>
            <a href="<?= base_url('admin/batalkan/' . $p->id) ?>" onclick="return confirm('Batalkan pesanan ini? Kuota akan dikembalikan.')">Batalkan</a>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$pesanan): ?><tr><td colspan="9">Tidak ada transaksi.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>