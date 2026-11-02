<?php
/* =====================================================================
   RESERVIN — DATA SALON ADMIN (admin/salon.php)
   Halaman pengelolaan profil salon: informasi salon, jam operasional,
   dan daftar fasilitas salon.
   ===================================================================== */

$page_title   = 'Data Salon';
$current_page = 'salon.php';

require_once __DIR__ . '/includes/init.php';

/* ===== DATA SALON (Nantinya diganti dari database) ===== */

$salon = [
    'nama'      => 'Luna Salon',
    'telepon'   => '081234567890',
    'alamat'    => 'Jl. Mawar No. 10, Surakarta',
    'deskripsi' => 'Salon kecantikan yang menyediakan berbagai layanan perawatan rambut dan kecantikan.',
    'buka'      => '09:00',
    'tutup'     => '20:00',
];

/* [nama fasilitas, aktif?] */
$fasilitas = [
    ['AC', true], ['WiFi', true], ['Ruang Tunggu', true],
    ['Parkir', true], ['Toilet', true], ['Ruang Ganti', true],
    ['Mushola', false], ['Minuman', false], ['TV', false],
];

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- SAMBUTAN / JUDUL HALAMAN -->
<section class="ad-sapa">
    <h1>Data Salon</h1>
    <p>Kelola informasi salon Anda.</p>
</section>

<form id="formSalon" onsubmit="return simpan(event)">

    <!-- INFORMASI DASAR SALON -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Informasi Salon</h2>
        </div>

        <div class="ad-form-grid">
            <div class="ad-field">
                <label for="nama">Nama Salon</label>
                <input type="text" id="nama" name="nama" value="<?= e($salon['nama']) ?>">
            </div>

            <div class="ad-field">
                <label for="telepon">No. Telepon</label>
                <input type="text" id="telepon" name="telepon" value="<?= e($salon['telepon']) ?>">
            </div>

            <div class="ad-field full">
                <label for="alamat">Alamat Salon</label>
                <textarea id="alamat" name="alamat"><?= e($salon['alamat']) ?></textarea>
            </div>

            <div class="ad-field full">
                <label for="deskripsi">Deskripsi Salon</label>
                <textarea id="deskripsi" name="deskripsi"><?= e($salon['deskripsi']) ?></textarea>
            </div>
        </div>
    </section>

    <!-- JAM OPERASIONAL -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Jam Operasional</h2>
        </div>

        <div class="ad-jam">
            <div class="ad-field">
                <label for="buka">Jam Buka</label>
                <input type="time" id="buka" name="buka" value="<?= e($salon['buka']) ?>">
            </div>

            <div class="ad-field">
                <label for="tutup">Jam Tutup</label>
                <input type="time" id="tutup" name="tutup" value="<?= e($salon['tutup']) ?>">
            </div>
        </div>
    </section>

    <!-- FASILITAS SALON -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Fasilitas Salon</h2>
        </div>

        <div class="ad-fas">
            <?php foreach ($fasilitas as $f): ?>
                <label>
                    <input type="checkbox" name="fasilitas[]" value="<?= e($f[0]) ?>"<?= $f[1] ? ' checked' : '' ?>>
                    <span class="ad-kotak"><?= ikon('cek') ?></span>
                    <?= e($f[0]) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <div class="ad-aksi">
            <button type="submit" class="ad-btn utama">Simpan Perubahan</button>
            <button type="button" class="ad-btn kedua" onclick="kembali()">Kembali</button>
        </div>
    </section>

</form>

<?php
// Script khusus halaman data salon
$extra_js = '
<script>
function simpan(e) {
    if (e) e.preventDefault();
    alert("Data salon berhasil disimpan.");
    return false;
}

function kembali() {
    window.location.href = "dashboard.php";
}
</script>
';

// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php';
?>
