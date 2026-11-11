<?php foreach ($events as $e): ?>
<div>
  <div>
    <div>
      <h5><?= htmlspecialchars($e->nama) ?></h5>
      <small><?= date('d M Y, H:i', strtotime($e->tanggal)) ?> · <?= htmlspecialchars($e->lokasi) ?></small>
    </div>
    <a href="<?= base_url('admin/tiket_form/' . $e->id) ?>">+ Jenis Tiket</a>
  </div>

  <table>
    <thead><tr><th>Jenis</th><th>Harga</th><th>Kuota</th><th>Terjual</th><th>Sisa</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($e->tiket as $t): ?>
      <tr>
        <td><?= htmlspecialchars($t->nama) ?></td>
        <td>Rp <?= number_format($t->harga, 0, ',', '.') ?></td>
        <td><?= $t->kuota ?></td>
        <td><?= $t->terjual ?></td>
        <td><?= $t->sisa ?></td>
        <td>
          <a href="<?= base_url('admin/tiket_form/' . $e->id . '/' . $t->id) ?>">Edit / Tambah Stok</a>
          <a href="<?= base_url('admin/tiket_hapus/' . $t->id) ?>" onclick="return confirm('Hapus jenis tiket?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$e->tiket): ?><tr><td colspan="6">Belum ada jenis tiket.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>
<?php endforeach; ?>