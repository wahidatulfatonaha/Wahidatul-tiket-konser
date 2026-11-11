<div>
  <form method="get">
    <input name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari event / lokasi">
    <button type="submit">Cari</button>
  </form>
  <a href="<?= base_url('admin/event_form') ?>">+ Tambah Event</a>
</div>

<div>
  <table>
    <thead><tr><th>Event</th><th>Kategori</th><th>Tanggal</th><th>Lokasi</th><th>Sisa</th><th>Status</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($events as $e): ?>
      <tr>
        <td><?= htmlspecialchars($e->nama) ?></td>
        <td><?= htmlspecialchars($e->kategori) ?></td>
        <td><?= date('d M Y, H:i', strtotime($e->tanggal)) ?></td>
        <td><?= htmlspecialchars($e->lokasi) ?></td>
        <td><?= (int)$e->sisa ?></td>
        <td><?= $e->status === 'selesai' ? '<span>Selesai</span>' : '<span>Aktif</span>' ?></td>
        <td>
          <a href="<?= base_url('admin/event_form/' . $e->id) ?>">Edit</a>
          <a href="<?= base_url('admin/event_hapus/' . $e->id) ?>" onclick="return confirm('Hapus event beserta tiketnya?')">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
    <?php if (!$events): ?><tr><td colspan="7">Tidak ada data.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>