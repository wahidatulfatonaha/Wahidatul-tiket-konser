<div>
  <a href="<?= base_url('event/' . $tiket->event_id) ?>">&larr; Kembali</a>
  <div>

    <div>
      <div>
        <h5><?= htmlspecialchars($tiket->event_nama) ?></h5>
        <p>📅 <?= date('d M Y, H:i', strtotime($tiket->tanggal)) ?><br>📍 <?= htmlspecialchars($tiket->lokasi) ?></p>
        <hr>
        <div><span>Tiket <?= htmlspecialchars($tiket->nama) ?></span><span><?= rupiah($tiket->harga) ?></span></div>
        <div><span>Sisa kuota</span><span><?= (int)$tiket->sisa ?></span></div>
        <hr>
        <div><b>Total Bayar</b><span id="total"><?= rupiah($tiket->harga) ?></span></div>
      </div>
    </div>

    <div>
      <div>
        <h4>Data Pemesan</h4>
        <?php if ($selesai): ?><div>Event sudah selesai.</div>
        <?php elseif ($tiket->sisa <= 0): ?><div>Tiket sudah habis.</div><?php endif; ?>

        <?= form_open_multipart('pesan/' . $tiket->id) ?>
          <div>
            <label>Nama Pemesan</label>
            <input name="nama_pemesan" value="<?= set_value('nama_pemesan', $u['nama']) ?>">
            <?= form_error('nama_pemesan', '<div>', '</div>') ?>
          </div>
          <div>
            <label>Email</label>
            <input name="email" type="email" value="<?= set_value('email', $u['email']) ?>">
            <?= form_error('email', '<div>', '</div>') ?>
          </div>
          <div>
            <label>No. Telepon</label>
            <input name="telepon" value="<?= set_value('telepon', $u['telepon']) ?>">
            <?= form_error('telepon', '<div>', '</div>') ?>
          </div>
          <div>
            <label>Jumlah Tiket (maks. <?= (int)$tiket->sisa ?>)</label>
            <input name="jumlah" id="jumlah" type="number" min="1" value="<?= set_value('jumlah', 1) ?>">
            <?= form_error('jumlah', '<div>', '</div>') ?>
          </div>

          <div>
            <label>Metode Pembayaran</label>
            <select name="metode" id="metode">
              <?php foreach (info_bayar() as $nama => $i): ?>
                <option <?= set_select('metode', $nama) ?>><?= $nama ?></option>
              <?php endforeach; ?>
            </select>
            <?= form_error('metode', '<div>', '</div>') ?>
          </div>

          <?php foreach (info_bayar() as $nama => $i): ?>
            <div class="info-bayar" data-metode="<?= $nama ?>">
              <small><?= $i['label'] ?></small>
              <div><?= $i['nomor'] ?></div>
              <div><?= $i['atas'] ?></div>
              <small><?= $i['catatan'] ?></small>
            </div>
          <?php endforeach; ?>

          <div>
            <label>Bukti Pembayaran (jpg/png/pdf, maks. 2 MB) - boleh diupload nanti</label>
            <input type="file" name="bukti">
          </div>

          <button type="submit" <?= ($selesai || $tiket->sisa <= 0) ? 'disabled' : '' ?>>Buat Pesanan</button>
        <?= form_close() ?>
      </div>
    </div>
  </div>
</div>

<script>
var harga = <?= (int)$tiket->harga ?>;
var jml   = document.getElementById('jumlah');
var total = document.getElementById('total');
function hitung() {
  var n = parseInt(jml.value) || 0;
  total.textContent = 'Rp ' + (n > 0 ? n * harga : 0).toLocaleString('id-ID');
}
jml.addEventListener('input', hitung);
hitung();

var pilih = document.getElementById('metode');
function tampilInfo() {
  document.querySelectorAll('.info-bayar').forEach(function (el) {
    el.style.display = (el.dataset.metode === pilih.value) ? 'block' : 'none';
  });
}
pilih.addEventListener('change', tampilInfo);
tampilInfo();
</script>