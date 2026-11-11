<form method="get">
  <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nama / email">
  <button type="submit">Cari</button>
</form>

<div>
  <table>
    <thead><tr><th>Nama</th><th>Email</th><th>Telepon</th><th>Transaksi</th><th>Total Belanja</th><th>Terdaftar</th></tr></thead>
    <tbody>
    <?php foreach ($pemesan as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p->nama) ?></td>
        <td><?= htmlspecialchars($p->email) ?></td>
        <td><?= htmlspecialchars($p->telepon) ?></td>
        <td><?= $p->jml_transaksi ?></td>
        <td><?= rupiah($p->total_belanja) ?></td>
        <td><?= date('d M Y', strtotime($p->created_at)) ?></td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$pemesan): ?><tr><td colspan="6">Tidak ada data.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>