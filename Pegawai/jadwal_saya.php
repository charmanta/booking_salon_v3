<?php
date_default_timezone_set('Asia/Jakarta');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ikon garis (stroke) */
function ikon($nama) {
    $p = [
        'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
        'booking'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 14h8M8 17.500h5"/>',
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'cek'      => '<circle cx="12" cy="12" r="9"/><path d="M8 12.500l3 3 5-6"/>',
        'panah'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',     false],
    ['detail_booking.php',   'Pesanan Masuk',    'daftar',   false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking',  false],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', true],
    ['profil.php',           'Profil',           'user',     false],
];

$namaHari = [1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
$bulan    = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$hariIni  = (int)date('N');

/*
 * Jadwal milik pegawai yang sedang login, diatur admin di halaman Pegawai.
 * Nanti dari database, contoh:
 *   SELECT hari_kerja, jam_masuk, jam_pulang FROM pegawai WHERE id = ?   (id dari sesi login)
 */
$jadwal = ['hari' => [1, 2, 3, 4, 5, 6], 'masuk' => '09:00', 'pulang' => '17:00'];

/* presensi hari ini (diisi pegawai di Dashboard): null = belum, atau ['jam' => 'H:i'] */
$presensiHariIni = null;

/* tanggal tiap hari pada pekan ini */
$senin = strtotime('monday this week');
$tgl   = [];
foreach ($namaHari as $no => $h) {
    $t = strtotime('+' . ($no - 1) . ' day', $senin);
    $tgl[$no] = date('j', $t) . ' ' . $bulan[(int)date('n', $t)];
}
$minggu  = strtotime('+6 day', $senin);
$rentang = date('j', $senin) . ' ' . $bulan[(int)date('n', $senin)] . ' – ' . date('j', $minggu) . ' ' . $bulan[(int)date('n', $minggu)] . ' ' . date('Y', $minggu);

/* durasi & total */
$menitSehari = (strtotime($jadwal['pulang']) - strtotime($jadwal['masuk'])) / 60;
function fmtJam($menit) {
    return rtrim(rtrim(number_format($menit / 60, 1, ',', ''), '0'), ',');
}
$jmlHari   = count($jadwal['hari']);
$hariLibur = array_values(array_diff(array_keys($namaHari), $jadwal['hari']));
$namaLibur = $hariLibur ? implode(', ', array_map(function ($h) use ($namaHari) { return $namaHari[$h]; }, $hariLibur)) : 'Tidak ada';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Saya</title>
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
                <h1>Jadwal Saya</h1>
                <p>Jadwal kerja mingguan Anda, diatur oleh admin salon.</p>
            </section>


            <!-- RINGKASAN -->

            <section class="ad-stats">
                <div class="ad-stat">
                    <div class="ad-ic tan"><?= ikon('kalender') ?></div>
                    <div>
                        <div class="nilai"><?= $jmlHari ?> hari</div>
                        <div class="judul">Kerja per pekan</div>
                    </div>
                </div>
                <div class="ad-stat">
                    <div class="ad-ic amber"><?= ikon('jam') ?></div>
                    <div>
                        <div class="nilai"><?= e(fmtJam($jmlHari * $menitSehari)) ?> jam</div>
                        <div class="judul">Total jam per pekan</div>
                    </div>
                </div>
                <div class="ad-stat">
                    <div class="ad-ic green"><?= ikon('cek') ?></div>
                    <div>
                        <div class="nilai"><?= e($namaLibur) ?></div>
                        <div class="judul">Hari libur</div>
                    </div>
                </div>
            </section>


            <!-- JADWAL PEKAN INI -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Jadwal Pekan Ini</h2>
                    <span class="ad-jumlah"><?= e($rentang) ?></span>
                </div>

                <p class="ad-tip">Jadwal ini berulang setiap pekan. Kirim presensi di Dashboard pada hari kerja Anda.</p>

                <div class="ad-pekan">
                    <?php foreach ($namaHari as $no => $nama): ?>
                        <?php
                            $kerja = in_array($no, $jadwal['hari'], true);
                            $ini   = ($no === $hariIni);
                            $kelas = trim(($ini ? 'ini ' : '') . ($kerja ? '' : 'libur'));
                        ?>
                        <div class="ad-hr<?= $kelas ? ' ' . $kelas : '' ?>">

                            <?php if ($ini): ?><span class="tag">Hari ini</span><?php endif; ?>

                            <span class="nm"><?= e($nama) ?></span>
                            <span class="tg"><?= e($tgl[$no]) ?></span>

                            <?php if ($kerja): ?>
                                <span class="jam"><?= e($jadwal['masuk']) ?> – <?= e($jadwal['pulang']) ?></span>
                                <span class="dur"><?= e(fmtJam($menitSehari)) ?> jam</span>
                            <?php else: ?>
                                <span class="jam">Libur</span>
                            <?php endif; ?>

                            <?php if ($ini && $kerja): ?>
                                <div class="pres">
                                    <?php if ($presensiHariIni): ?>
                                        <span class="ad-pil ok">Presensi <?= e($presensiHariIni['jam']) ?></span>
                                    <?php else: ?>
                                        <span class="ad-pil off">Belum presensi</span>
                                        <a href="dashboard.php#presensi">Kirim presensi</a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; ?>
                </div>

                <p class="ad-catatan">Ingin menukar hari atau mengubah jam kerja? Hubungi admin salon.</p>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>




    <!-- Script Interaktivitas Global Admin & Ripple Wave -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>
