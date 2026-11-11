<?php
$tot_kuota = $tot_terjual = $tot_sisa = $tot_uang = 0;
foreach ($rekap as $x) {
    $tot_kuota   += $x->kuota;
    $tot_terjual += $x->terjual;
    $tot_sisa    += $x->sisa;
    $tot_uang    += $x->pendapatan;
}
?>
<div>
  <span>Rekap tiket terjual dan tersisa per jenis tiket.</span>
  <button type="button" onclick="window.print()">Cetak Laporan</button>
</div>

<div>
  <table>
    <thead><tr><th>Event</th><th>Tiket</th><th>Harga</th><th>Kuota</th><th>Terjual</th><th>Sisa</th><th>Pendapatan</th></tr></thead>
    <tbody>
    <?php foreach ($rekap as $x): ?>
      <tr>
        <td><?= htmlspecialchars($x->event) ?></td>
        <td><?= htmlspecialchars($x->tiket) ?></td>
        <td><?= rupiah($x->harga) ?></td>
        <td><?= $x->kuota ?></td>
        <td><?= $x->terjual ?></td>
        <td><?= $x->sisa ?></td>
        <td><?= rupiah($x->pendapatan) ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr><th colspan="3">Total</th><th><?= $tot_kuota ?></th><th><?= $tot_terjual ?></th><th><?= $tot_sisa ?></th><th><?= rupiah($tot_uang) ?></th></tr>
    </tfoot>
  </table>
</div>