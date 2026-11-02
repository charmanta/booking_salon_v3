<?php
date_default_timezone_set('Asia/Jakarta');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ikon garis (stroke) */
function ikon($nama) {
    $p = [
        'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'booking'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 14h8M8 17.500h5"/>',
        'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA', 'salon' => 'Luna Salon'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    false],
    ['detail_booking.php',   'Pesanan Masuk',    'daftar',  false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', false],
    ['profil.php',           'Profil',           'user',    true],
];

$akun = [
    'nama'    => 'Siti Amelia',
    'telepon' => '081234567890',
    'email'   => 'siti@gmail.com',
    'alamat'  => 'Jl. Mawar No. 10',
    'jabatan' => 'Pegawai',
];

/* status hari ini: hanya ditampilkan, diisi dari presensi di Dashboard (true = sudah presensi / Aktif) */
$sudahPresensi = false;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Terpadu Matching Admin & Customer -->
    <link rel="stylesheet" href="../admin/css/admin.css">
    <link rel="stylesheet" href="pegawai.css">
    <!-- Halaman ini berdiri sendiri: semua gaya ada di blok
</head>
<body class="ad-body">

    <!-- ===== SIDEBAR ===== -->
    <aside class="ad-side" id="sidebar" aria-label="Menu pegawai">

        <a class="ad-logo" href="dashboard.php" aria-label="Reservin Salon Booking">
            <span>
                <b>RESERVIN</b>
                <small>Salon Booking</small>
            </span>
            <?= ikon('gunting') ?>
        </a>

        <nav class="ad-nav">
            <?php foreach ($menu as $m): ?>
                <a href="<?= e($m[0]) ?>" class="ad-link<?= $m[3] ? ' active' : '' ?>"<?= $m[3] ? ' aria-current="page"' : '' ?>>
                    <?= ikon($m[2]) ?>
                    <?= e($m[1]) ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="ad-side-bawah">

            <div class="ad-profil">
                <div class="ad-ava"><?= e($pegawai['inisial']) ?></div>
                <div>
                    <b><?= e($pegawai['nama']) ?></b>
                    <small><?= e($pegawai['peran']) ?></small>
                </div>
            </div>

            <a href="../login.php" class="ad-link">
                <?= ikon('logout') ?>
                Logout
            </a>

        </div>

    </aside>

    <div class="ad-overlay" id="overlay"></div>


    <!-- ===== KONTEN ===== -->
    <div class="ad-wrap" id="wrap">

        <header class="ad-top">

            <button
                type="button"
                class="ad-burger"
                id="burger"
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="sidebar">
                <?= ikon('menu') ?>
            </button>

            <div class="ad-user-wrap">

                <button
                    type="button"
                    class="ad-user"
                    id="userBtn"
                    aria-haspopup="true"
                    aria-expanded="false">

                    <span class="ad-ava"><?= e($pegawai['inisial']) ?></span>

                    <span class="ad-user-info">
                        <b><?= e($pegawai['nama']) ?></b>
                        <small><?= e($pegawai['peran']) ?></small>
                    </span>

                    <?= ikon('turun') ?>

                </button>

                <div class="ad-dd" id="userMenu">
                    <a href="profil.php"><?= ikon('user') ?> Profil</a>
                    <a href="../login.php"><?= ikon('logout') ?> Logout</a>
                </div>

            </div>

        </header>


        <main class="ad-main">

            <section class="ad-sapa">
                <h1>Profil</h1>
                <p>Kelola data diri dan keamanan akun Anda.</p>
            </section>


            <!-- IDENTITAS -->

            <section class="ad-kartu">
                <div class="ad-kepala">
                    <div class="ad-ava"><?= e($pegawai['inisial']) ?></div>
                    <div>
                        <b><?= e($akun['nama']) ?></b>
                        <small><?= e($pegawai['peran']) ?> · <?= e($pegawai['salon']) ?></small>
                    </div>
                </div>
            </section>


            <form id="formProfil" onsubmit="return simpanProfil(event)">

                <!-- DATA PRIBADI -->

                <section class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Data Pribadi</h2>
                    </div>
                    <p class="ad-sub">Informasi kontak yang digunakan salon.</p>

                    <div class="ad-form-grid">

                        <div class="ad-field">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" value="<?= e($akun['nama']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="telepon">No. Telepon</label>
                            <input type="text" id="telepon" value="<?= e($akun['telepon']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?= e($akun['email']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="alamat">Alamat</label>
                            <textarea id="alamat"><?= e($akun['alamat']) ?></textarea>
                        </div>

                    </div>

                </section>


                <!-- INFORMASI PEKERJAAN -->

                <section class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Informasi Pekerjaan</h2>
                    </div>
                    <p class="ad-sub">Diatur oleh admin salon, tidak bisa diubah di sini.</p>

                    <div class="ad-form-grid">

                        <div class="ad-field">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" id="jabatan" value="<?= e($akun['jabatan']) ?>" readonly>
                        </div>

                        <div class="ad-field">
                            <label for="salon">Salon</label>
                            <input type="text" id="salon" value="<?= e($pegawai['salon']) ?>" readonly>
                        </div>

                        <div class="ad-field">
                            <span class="lbl">Status Hari Ini</span>
                            <div><span class="ad-pil <?= $sudahPresensi ? 'ok' : 'off' ?>"><?= $sudahPresensi ? 'Aktif' : 'Nonaktif' ?></span></div>
                            <p class="ad-bantu">Berubah menjadi Aktif setelah Anda mengirim presensi di <a href="dashboard.php#presensi">Dashboard</a>.</p>
                        </div>

                    </div>

                </section>


                <!-- KEAMANAN -->

                <section class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Keamanan Akun</h2>
                    </div>
                    <p class="ad-sub">Kosongkan jika tidak ingin mengganti password.</p>

                    <div class="ad-field" style="max-width:480px">
                        <label for="password">Password Baru</label>
                        <div class="ad-sandi">
                            <input type="password" id="password" placeholder="Minimal 8 karakter" autocomplete="new-password">
                            <button type="button" class="ad-btn kedua" id="btnLihat">Lihat</button>
                        </div>
                    </div>

                    <div class="ad-aksi">
                        <button type="submit" class="ad-btn utama">Simpan Perubahan</button>
                        <button type="button" class="ad-btn kedua" onclick="window.location.href='dashboard.php'">Kembali</button>
                    </div>

                </section>

            </form>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


<script>

/* ===== profil ===== */

function simpanProfil(e) {

    if (e) e.preventDefault();

    if (document.getElementById("nama").value.trim() === "") {
        alert("Nama lengkap wajib diisi.");
        return false;
    }

    const sandi = document.getElementById("password").value;

    if (sandi !== "" && sandi.length < 8) {
        alert("Password baru minimal 8 karakter.");
        return false;
    }

    alert("Perubahan profil berhasil disimpan.");
    return false;

}

document.getElementById("btnLihat").addEventListener("click", function () {
    const p = document.getElementById("password");
    const tampil = p.type === "password";
    p.type = tampil ? "text" : "password";
    this.textContent = tampil ? "Sembunyikan" : "Lihat";
});


</script>

    <!-- Script Interaktivitas Global Admin & Ripple Wave -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>
