<?php
/* =====================================================================
   RESERVIN — PROFIL ADMIN & SALON (admin/profil.php)
   Halaman profil akun pemilik/admin salon dan ringkasan data salon.
   ===================================================================== */

$page_title   = 'Profil';
$current_page = 'profil.php';

require_once __DIR__ . '/includes/init.php';

/* ===== DATA CONTOH (Nantinya diganti dari database) ===== */

$akun = [
    'nama'    => 'Siti Amelia',
    'telepon' => '081234567890',
    'email'   => 'sitiamelia@gmail.com',
    'peran'   => 'Pemilik / Admin Salon',
];

$salon = [
    'nama'    => 'Luna Salon',
    'telepon' => '081234567890',
    'alamat'  => 'Jl. Merdeka No. 10, Bandung',
    'lokasi'  => 'Bandung',
    'buka'    => '09:00',
    'tutup'   => '20:00',
    'status'  => 'Aktif',
];

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- SAMBUTAN / JUDUL HALAMAN -->
<section class="ad-sapa">
    <h1>Profil</h1>
    <p>Kelola informasi akun dan salon Anda.</p>
</section>

<form id="formProfil" onsubmit="return simpanProfil(event)">

    <!-- INFORMASI AKUN PEMILIK -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Informasi Akun</h2>
        </div>
        <p class="ad-sub">Informasi pemilik akun yang digunakan untuk mengelola salon.</p>

        <div class="ad-kepala">
            <div class="ad-ava"><?= e($admin['inisial']) ?></div>
            <div>
                <b><?= e($akun['nama']) ?></b>
                <small><?= e($akun['peran']) ?></small>
            </div>
        </div>

        <div class="ad-form-grid">
            <div class="ad-field">
                <label for="namaPemilik">Nama Pemilik</label>
                <input type="text" id="namaPemilik" value="<?= e($akun['nama']) ?>">
            </div>

            <div class="ad-field">
                <label for="telepon">Nomor Telepon</label>
                <input type="text" id="telepon" value="<?= e($akun['telepon']) ?>">
            </div>

            <div class="ad-field full">
                <label for="email">Email</label>
                <input type="email" id="email" value="<?= e($akun['email']) ?>">
            </div>
        </div>
    </section>

    <!-- INFORMASI SALON -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Informasi Salon</h2>
        </div>
        <p class="ad-sub">Informasi salon yang ditampilkan kepada pelanggan.</p>

        <div class="ad-form-grid">
            <div class="ad-field">
                <label for="namaSalon">Nama Salon</label>
                <input type="text" id="namaSalon" value="<?= e($salon['nama']) ?>">
            </div>

            <div class="ad-field">
                <label for="teleponSalon">Nomor Telepon Salon</label>
                <input type="text" id="teleponSalon" value="<?= e($salon['telepon']) ?>">
            </div>

            <div class="ad-field full">
                <label for="alamatSalon">Alamat Salon</label>
                <textarea id="alamatSalon"><?= e($salon['alamat']) ?></textarea>
            </div>

            <div class="ad-field">
                <label for="jamBuka">Jam Buka</label>
                <input type="time" id="jamBuka" value="<?= e($salon['buka']) ?>">
            </div>

            <div class="ad-field">
                <label for="jamTutup">Jam Tutup</label>
                <input type="time" id="jamTutup" value="<?= e($salon['tutup']) ?>">
            </div>
        </div>

        <div class="ad-aksi">
            <button type="button" class="ad-btn kedua" onclick="batal()">Batal</button>
            <button type="submit" class="ad-btn utama">Simpan Perubahan</button>
        </div>
    </section>

</form>

<!-- RINGKASAN SALON -->
<section class="ad-kartu">
    <div class="ad-kartu-head">
        <h2>Ringkasan Salon</h2>
    </div>
    <p class="ad-sub">Informasi utama salon Anda.</p>

    <div class="ad-info-grid">
        <div class="ad-info">
            <div class="ad-ic rose"><?= ikon('store') ?></div>
            <div>
                <small>Nama Salon</small>
                <b><?= e($salon['nama']) ?></b>
            </div>
        </div>

        <div class="ad-info">
            <div class="ad-ic violet"><?= ikon('pin') ?></div>
            <div>
                <small>Lokasi</small>
                <b><?= e($salon['lokasi']) ?></b>
            </div>
        </div>

        <div class="ad-info">
            <div class="ad-ic blue"><?= ikon('jam') ?></div>
            <div>
                <small>Jam Operasional</small>
                <b><?= e(str_replace(':', '.', $salon['buka'])) ?> – <?= e(str_replace(':', '.', $salon['tutup'])) ?></b>
            </div>
        </div>

        <div class="ad-info">
            <div class="ad-ic green"><?= ikon('cek') ?></div>
            <div>
                <small>Status Salon</small>
                <b><?= e($salon['status']) ?></b>
            </div>
        </div>
    </div>
</section>

<?php
// Script khusus halaman profil
$extra_js = '
<script>
function simpanProfil(e) {
    if (e) e.preventDefault();

    const nama = document.getElementById("namaPemilik").value.trim();
    const salon = document.getElementById("namaSalon").value.trim();

    if (nama === "" || salon === "") {
        alert("Nama pemilik dan nama salon wajib diisi.");
        return false;
    }

    alert("Perubahan profil berhasil disimpan.");
    return false;
}

function batal() {
    location.reload();
}
</script>
';

// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php';
?>
