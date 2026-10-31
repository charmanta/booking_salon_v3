<?php
date_default_timezone_set('Asia/Jakarta');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ikon garis (stroke) */
function ikon($nama) {
    $p = [
        'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
        'booking'  => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 14h8M8 17.500h5"/>',
        'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'cek'      => '<circle cx="12" cy="12" r="9"/><path d="M8 12.500l3 3 5-6"/>',
        'bintang'  => '<path d="M12 3.500l2.600 5.300 5.800.8-4.200 4.100 1 5.800-5.200-2.700-5.200 2.700 1-5.800L3.600 9.600l5.800-.8z"/>',
        'panah'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'kamera'   => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.500" r="3.500"/>',
        'kirim'    => '<path d="M4 12l16-8-6 17-3-7z"/><path d="M11 14l9-10"/>',
        'lonceng'  => '<path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4z"/><path d="M10 21a2 2 0 0 0 4 0"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

$hariPendek  = [1 => 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
$bulanPendek = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
function tglHari($ts) {
    global $hariPendek, $bulanPendek;
    return $hariPendek[(int)date('N', $ts)] . ', ' . date('j', $ts) . ' ' . $bulanPendek[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$pegawai = ['nama' => 'Siti Amelia', 'panggilan' => 'Siti', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    true],
    ['detail_booking.php',   'Detail Reservasi', 'daftar',  false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', false],
    ['profil.php',           'Profil',           'user',    false],
];

/* [ikon, warna, nilai, judul] */
$stat = [
    ['daftar',  'tan',   '12',  'Total Booking'],
    ['jam',     'amber', '4',   'Menunggu'],
    ['cek',     'green', '8',   'Dikonfirmasi'],
    ['bintang', 'gold',  '4.8', 'Rating'],
];

/* [kode, pelanggan, layanan, jam, status] */
$booking = [
    ['RSV-001', 'Rina', 'Creambath',     '10:00', 'Menunggu'],
    ['RSV-002', 'Dewi', 'Potong Rambut', '13:00', 'Dikonfirmasi'],
    ['RSV-003', 'Maya', 'Hair Spa',      '15:00', 'Dikonfirmasi'],
];

/* ===== Presensi =====
 * Jadwal diatur admin di halaman Pegawai (hari kerja, jam masuk, jam pulang).
 * Pengingat muncul MENIT_PENGINGAT menit sebelum jam masuk, dan tetap tampil
 * (berubah jadi peringatan terlambat) sampai pegawai mengirim presensi
 * atau jam pulang tiba.
 */
$MENIT_PENGINGAT = 30;

$jadwal       = ['masuk' => '09:00', 'pulang' => '17:00'];
$hariKerja    = [1, 2, 3, 4, 5, 6];                       /* 1 = Senin ... 7 = Minggu */
$kerjaHariIni = in_array((int)date('N'), $hariKerja, true);
$masukTs      = strtotime(date('Y-m-d') . ' ' . $jadwal['masuk']);
$pulangTs     = strtotime(date('Y-m-d') . ' ' . $jadwal['pulang']);

/* presensi hari ini: null = belum, atau ['jam' => 'H:i'] bila sudah terkirim */
$presensiHariIni = null;

/* riwayat beberapa hari terakhir: [timestamp, jam kirim atau null] */
$riwayat = [];
foreach ([1 => '08:51', 2 => '08:47', 3 => null, 4 => '09:02'] as $mundur => $jam) {
    $riwayat[] = [strtotime("-$mundur day"), $jam];
}

$statusTeks = $presensiHariIni
    ? 'Aktif · terkirim ' . $presensiHariIni['jam']
    : ($kerjaHariIni ? 'Belum presensi' : 'Libur');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Halaman ini berdiri sendiri: semua gaya ada di blok <style> di bawah -->
    <style>
        :root {
            --side: 232px;
            --tan: #c4938d;
            --tan-dark: #a9726c;
            --tan-deep: #96605a;
            --tan-soft: #c4938d;
            --ink: #1f1a1a;
            --muted: #6b6470;
            --line: #ece4df;
            --bg: #fbf8f6;
        }

        * { box-sizing: border-box; }
        [hidden] { display: none !important; }

        body.ad-body { margin: 0; font-family: 'Jost', sans-serif; color: var(--ink); background: var(--bg); }
        .ad-body a { color: inherit; }
        .ad-body svg { width: 22px; height: 22px; flex: none; }

        /* ================= SIDEBAR ================= */
        .ad-side {
            position: fixed; top: 0; left: 0; bottom: 0; width: var(--side); z-index: 200;
            background: linear-gradient(180deg, #b07f79 0%, #a36d67 100%);
            color: #fff; display: flex; flex-direction: column; padding: 22px 16px 18px;
            transform: translateX(-100%); overflow-y: auto;
        }
        body.sb-open .ad-side { transform: none; }

        .ad-logo { display: flex; align-items: center; justify-content: space-between; gap: 8px; text-decoration: none; color: #fff; padding: 0 4px 4px; }
        .ad-logo b { display: block; font-size: 20px; font-weight: 600; letter-spacing: .12em; line-height: 1; }
        .ad-logo small { display: block; margin-top: 5px; font-size: 13px; font-weight: 400; opacity: .95; }
        .ad-logo svg { width: 28px; height: 28px; }

        .ad-nav { margin-top: 26px; display: flex; flex-direction: column; gap: 4px; }
        .ad-link {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px; border-radius: 10px;
            color: #fff; text-decoration: none; font-size: 14.5px; opacity: .95;
        }
        .ad-link:hover { background: rgba(255, 255, 255, .13); }
        .ad-link.active { background: rgba(255, 255, 255, .24); font-weight: 600; opacity: 1; }
        .ad-link svg { width: 20px; height: 20px; }

        .ad-side-bawah { margin-top: auto; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, .3); }
        .ad-profil { display: flex; align-items: center; gap: 10px; padding: 4px 4px 12px; }
        .ad-ava { width: 40px; height: 40px; border-radius: 50%; background: #fff; color: #7a4a45; display: grid; place-items: center; font-weight: 700; font-size: 14px; flex: none; }
        .ad-profil b { display: block; font-size: 14.5px; font-weight: 500; }
        .ad-profil small { display: block; font-size: 12.5px; opacity: .85; margin-top: 2px; }

        .ad-overlay { display: none; position: fixed; inset: 0; z-index: 150; background: rgba(30, 18, 16, .5); }

        /* ================= KONTEN ================= */
        .ad-wrap { min-height: 100vh; display: flex; flex-direction: column; }

        .ad-top {
            position: sticky; top: 0; z-index: 100; height: 88px; padding: 0 clamp(18px, 3vw, 44px);
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
            background: linear-gradient(90deg, #f6ece7 0%, #fbf7f5 100%);
            border-bottom: 1px solid var(--line);
        }
        .ad-burger { width: 46px; height: 46px; border: 0; background: transparent; border-radius: 10px; display: grid; place-items: center; cursor: pointer; color: #4a4348; padding: 0; }
        .ad-burger:hover { background: rgba(0, 0, 0, .06); }
        .ad-burger svg { width: 28px; height: 28px; }

        .ad-user-wrap { position: relative; }
        .ad-user { display: flex; align-items: center; gap: 14px; background: transparent; border: 0; cursor: pointer; font-family: inherit; color: inherit; padding: 6px 8px; border-radius: 12px; }
        .ad-user:hover { background: rgba(0, 0, 0, .05); }
        .ad-user .ad-ava { background: var(--tan); color: #fff; width: 48px; height: 48px; font-size: 17px; }
        .ad-user-info { text-align: left; line-height: 1.25; }
        .ad-user-info b { display: block; font-size: 16px; font-weight: 500; }
        .ad-user-info small { display: block; font-size: 14px; color: var(--muted); }
        .ad-user > svg { width: 20px; height: 20px; color: #4a4348; margin-left: 6px; }

        .ad-dd { display: none; position: absolute; right: 0; top: calc(100% + 8px); min-width: 200px; background: #fff; border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 12px 32px rgba(60, 30, 25, .14); padding: 6px; z-index: 300; }
        .ad-dd.show { display: block; }
        .ad-dd a { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 8px; text-decoration: none; font-size: 15px; }
        .ad-dd a:hover { background: #f6ece7; }
        .ad-dd svg { width: 20px; height: 20px; color: var(--tan-dark); }

        .ad-main { flex: 1; padding: 36px clamp(18px, 3vw, 44px) 56px; }

        .ad-sapa h1 { margin: 0; font-size: clamp(28px, 3.2vw, 40px); font-weight: 700; letter-spacing: -.01em; }
        .ad-sapa p { margin: 10px 0 0; font-size: 19px; color: var(--muted); }

        /* kartu statistik */
        .ad-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px; margin-top: 34px; }
        .ad-stat { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 22px 24px 24px; }
        .ad-ic { width: 58px; height: 58px; border-radius: 50%; display: grid; place-items: center; }
        .ad-ic svg { width: 28px; height: 28px; }
        .ad-ic.tan { background: #fbe1de; color: #b4524a; }
        .ad-ic.amber { background: #fdf0d3; color: #8a5a00; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-ic.gold { background: #fbe9b8; color: #a3720a; }
        .ad-stat .nilai { margin-top: 20px; font-size: 32px; font-weight: 700; line-height: 1; }
        .ad-stat .judul { margin-top: 10px; font-size: 16px; color: #4d4650; }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 28px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-semua { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; color: #5d5560; text-decoration: none; white-space: nowrap; }
        .ad-semua:hover { color: var(--tan-deep); }
        .ad-semua svg { width: 17px; height: 17px; }

        /* tabel */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 620px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 15px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; vertical-align: middle; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-tabel .kode { font-weight: 600; }
        .ad-pil { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.tunggu { background: #fdf0d3; color: #8a5a00; }
        .ad-pil.off { background: #f1ebe8; color: #7a6c68; }

        .ad-mini {
            display: inline-flex; align-items: center; font-family: inherit; font-size: 13.5px; font-weight: 500;
            padding: 7px 14px; border-radius: 8px; background: #fff; border: 1px solid #e3d8d2; color: #4d4650; text-decoration: none; cursor: pointer;
        }
        .ad-mini:hover { background: #f6ece7; }

        /* tombol */
        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 14.5px; font-weight: 500; padding: 10px 18px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s; white-space: nowrap;
        }
        .ad-btn svg { width: 18px; height: 18px; }
        .ad-btn.utama { background: var(--tan-dark); color: #fff; }
        .ad-btn.utama:hover { background: var(--tan-deep); }
        .ad-btn[disabled] { opacity: .5; cursor: not-allowed; }

        /* ===== PRESENSI (kartu ringkas) ===== */
        .ad-pres { padding: 18px 22px; }

        .ad-ingat { display: flex; align-items: center; gap: 12px; padding: 11px 14px; margin-bottom: 14px; border-radius: 10px; font-size: 14.5px; line-height: 1.45; }
        .ad-ingat svg { width: 20px; height: 20px; }
        .ad-ingat span { flex: 1; min-width: 0; }
        .ad-ingat .ad-mini { flex: none; }
        .ad-ingat.hampir { background: #fdf0d3; color: #7a4e00; }
        .ad-ingat.telat { background: #fdeceb; color: #a53a33; }

        .ad-pres-isi { display: grid; grid-template-columns: minmax(0, 1fr) auto; gap: 22px; align-items: center; }
        .ad-pres-judul { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
        .ad-pres-judul h2 { margin: 0; font-size: 19px; font-weight: 600; }
        .ad-pres-data { display: flex; flex-wrap: wrap; gap: 4px 22px; margin: 10px 0 0; font-size: 14.5px; color: var(--muted); }
        .ad-pres-data b { color: var(--ink); font-weight: 600; }
        .ad-aturan { margin: 8px 0 0; font-size: 13px; color: var(--muted); }

        .ad-pres-aksi { display: flex; align-items: center; gap: 14px; }
        .ad-drop {
            position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; text-align: center;
            width: 128px; height: 96px; border: 2px dashed #d9cdc8; border-radius: 12px; background: #fbf8f6; cursor: pointer;
            transition: background .15s, border-color .15s;
        }
        .ad-drop:hover, .ad-drop.seret { background: #fbf1ee; border-color: var(--tan-soft); }
        .ad-drop svg { width: 26px; height: 26px; color: var(--tan-soft); }
        .ad-drop b { font-size: 13.5px; font-weight: 600; }
        .ad-drop.mati { opacity: .5; cursor: not-allowed; }
        .ad-drop input { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
        .ad-drop:focus-within { outline: 2px solid var(--tan); outline-offset: 2px; }

        .ad-thumb { position: relative; width: 128px; height: 96px; }
        .ad-thumb img { display: block; width: 100%; height: 100%; object-fit: cover; border-radius: 12px; border: 1px solid var(--line); }
        .ad-thumb button {
            position: absolute; right: 6px; bottom: 6px; padding: 4px 9px; font-family: inherit; font-size: 12px; font-weight: 500;
            border: 0; border-radius: 6px; background: rgba(255, 255, 255, .92); color: #4d4650; cursor: pointer;
        }

        .ad-pres-tombol { display: flex; flex-direction: column; gap: 8px; }

        .ad-pesan { margin: 10px 0 0; padding: 9px 12px; border-radius: 8px; font-size: 14px; display: none; }
        .ad-pesan.salah { display: block; background: #fdeceb; color: #b4423a; }
        .ad-pesan.benar { display: block; background: #dff3e8; color: #1c6f47; }

        .ad-pres-riwayat { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-top: 14px; padding-top: 14px; border-top: 1px solid var(--line); font-size: 13.5px; color: var(--muted); }
        .ad-chip { padding: 4px 10px; border-radius: 8px; font-size: 13px; white-space: nowrap; }
        .ad-chip.ok { background: #dff3e8; color: #1c6f47; }
        .ad-chip.off { background: #f1ebe8; color: #7a6c68; }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible, .ad-mini:focus-visible, .ad-semua:focus-visible, .ad-btn:focus-visible { outline: 2px solid var(--tan); outline-offset: 2px; }

        /* animasi baru aktif setelah halaman siap */
        body.sb-ready .ad-side { transition: transform .3s ease; }
        body.sb-ready .ad-wrap { transition: margin-left .3s ease; }

        /* ================= RESPONSIVE ================= */
        @media (min-width: 1000px) {
            body.sb-open .ad-wrap { margin-left: var(--side); }
        }

        @media (max-width: 999px) {
            body.sb-open .ad-overlay { display: block; }
            .ad-side { box-shadow: 8px 0 30px rgba(0, 0, 0, .3); }
        }

        @media (max-width: 1100px) {
            .ad-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 860px) {
            .ad-pres-isi { grid-template-columns: 1fr; }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
        }

        @media (max-width: 520px) {
            .ad-stats { grid-template-columns: 1fr; }
            .ad-kartu { padding: 20px 16px; }
            .ad-pres { padding: 16px; }
            .ad-ingat { flex-wrap: wrap; }
            .ad-pres-aksi { flex-wrap: wrap; }
        }
    </style>
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

            <!-- SAMBUTAN -->

            <section class="ad-sapa">
                <h1>Halo, <?= e($pegawai['panggilan']) ?>!</h1>
                <p>Berikut informasi booking salon hari ini.</p>
            </section>


            <!-- STATISTIK -->

            <section class="ad-stats">
                <?php foreach ($stat as $s): ?>
                    <div class="ad-stat">
                        <div class="ad-ic <?= e($s[1]) ?>"><?= ikon($s[0]) ?></div>
                        <div class="nilai"><?= e($s[2]) ?></div>
                        <div class="judul"><?= e($s[3]) ?></div>
                    </div>
                <?php endforeach; ?>
            </section>


            <!-- PRESENSI KERJA (ringkas) -->

            <section class="ad-kartu ad-pres" id="presensi" aria-labelledby="judulPresensi">

                <!-- pengingat: diatur oleh script di bawah -->
                <div class="ad-ingat" id="pengingat" role="alert" hidden>
                    <?= ikon('lonceng') ?>
                    <span id="teksPengingat"></span>
                    <button type="button" class="ad-mini" id="btnPengingat">Kirim presensi</button>
                </div>

                <div class="ad-pres-isi">

                    <div>
                        <div class="ad-pres-judul">
                            <h2 id="judulPresensi">Presensi Kerja</h2>
                            <span class="ad-pil <?= $presensiHariIni ? 'ok' : 'off' ?>" id="pilPresensi"><?= $presensiHariIni ? 'Aktif' : ($kerjaHariIni ? 'Belum presensi' : 'Libur') ?></span>
                        </div>

                        <p class="ad-pres-data">
                            <span><?= e(tglHari(time())) ?></span>
                            <span>Jadwal <b><?= $kerjaHariIni ? e($jadwal['masuk']) . ' – ' . e($jadwal['pulang']) : 'libur' ?></b></span>
                            <span>Status <b id="teksStatus"><?= e($statusTeks) ?></b></span>
                        </p>

                        <p class="ad-aturan">Foto diambil di dalam salon · JPG, PNG, atau WEBP · maks. 5 MB · sekali sehari.</p>

                        <div class="ad-pesan" id="pesan" role="status"></div>
                    </div>

                    <div class="ad-pres-aksi">

                        <label class="ad-drop<?= $kerjaHariIni ? '' : ' mati' ?>" id="drop" for="fotoPresensi"<?= $presensiHariIni ? ' hidden' : '' ?>>
                            <?= ikon('kamera') ?>
                            <b>Ambil foto</b>
                            <input type="file" id="fotoPresensi" accept="image/jpeg,image/png,image/webp" capture="user"<?= ($kerjaHariIni && !$presensiHariIni) ? '' : ' disabled' ?>>
                        </label>

                        <div class="ad-thumb" id="preview" hidden>
                            <img id="gambarPreview" alt="Foto presensi">
                            <button type="button" id="btnGanti">Ganti</button>
                        </div>

                        <div class="ad-pres-tombol">
                            <button type="button" class="ad-btn utama" id="btnKirim"<?= ($kerjaHariIni && !$presensiHariIni) ? '' : ' disabled' ?>>
                                <?= ikon('kirim') ?> Kirim Presensi
                            </button>
                        </div>

                    </div>

                </div>

                <?php if ($riwayat): ?>
                    <div class="ad-pres-riwayat">
                        <span>Terakhir:</span>
                        <?php foreach ($riwayat as $r): ?>
                            <span class="ad-chip <?= $r[1] ? 'ok' : 'off' ?>">
                                <?= e($hariPendek[(int)date('N', $r[0])] . ' ' . date('j', $r[0])) ?> · <?= $r[1] ? e($r[1]) : 'tidak masuk' ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </section>


            <!-- BOOKING HARI INI -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Booking Hari Ini</h2>
                    <a class="ad-semua" href="daftar_reservasi.php">Lihat Semua <?= ikon('panah') ?></a>
                </div>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($booking as $b): ?>
                                <tr>
                                    <td class="kode"><?= e($b[0]) ?></td>
                                    <td><?= e($b[1]) ?></td>
                                    <td><?= e($b[2]) ?></td>
                                    <td><?= e($b[3]) ?></td>
                                    <td>
                                        <span class="ad-pil <?= $b[4] === 'Dikonfirmasi' ? 'ok' : 'tunggu' ?>"><?= e($b[4]) ?></span>
                                    </td>
                                    <td>
                                        <a href="detail_booking.php" class="ad-mini">Detail</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


<script>

/* ===== presensi kerja + pengingat ===== */

(function () {

    /* waktu dalam milidetik (epoch) dari server, jadi tidak terpengaruh zona waktu perangkat */
    const JADWAL = {
        kerja: <?= $kerjaHariIni ? 'true' : 'false' ?>,
        masuk: <?= (int)$masukTs ?> * 1000,
        pulang: <?= (int)$pulangTs ?> * 1000,
        jamMasuk: "<?= e($jadwal['masuk']) ?>",
        menitAwal: <?= (int)$MENIT_PENGINGAT ?>
    };

    const MAKS = 5 * 1024 * 1024;
    const JENIS = ["image/jpeg", "image/png", "image/webp"];

    const $ = function (id) { return document.getElementById(id); };
    const input = $("fotoPresensi");
    const drop = $("drop");
    const preview = $("preview");
    const gambar = $("gambarPreview");
    const pesan = $("pesan");
    const btnKirim = $("btnKirim");
    const btnGanti = $("btnGanti");
    const pengingat = $("pengingat");

    let berkas = null;
    let urlSementara = null;
    let sudahPresensi = <?= $presensiHariIni ? 'true' : 'false' ?>;

    /* ---------- pengingat ---------- */

    function durasi(menit) {
        if (menit < 60) return menit + " menit";
        const j = Math.floor(menit / 60), m = menit % 60;
        return j + " jam" + (m ? " " + m + " menit" : "");
    }

    function perbaruiPengingat() {

        const sekarang = Date.now();
        const selisih = JADWAL.masuk - sekarang;
        const menitLagi = Math.ceil(selisih / 60000);

        if (sudahPresensi || !JADWAL.kerja || sekarang > JADWAL.pulang || menitLagi > JADWAL.menitAwal) {
            pengingat.hidden = true;
            return;
        }

        if (selisih > 0) {
            pengingat.className = "ad-ingat hampir";
            $("teksPengingat").textContent =
                "Jam masuk (" + JADWAL.jamMasuk + ") tinggal " + durasi(menitLagi) + " lagi. Jangan lupa kirim presensi.";
        } else {
            const lewat = Math.floor(-selisih / 60000);
            pengingat.className = "ad-ingat telat";
            $("teksPengingat").textContent = lewat === 0
                ? "Sudah waktunya masuk kerja (" + JADWAL.jamMasuk + "). Kirim presensi sekarang."
                : "Anda belum presensi, sudah lewat " + durasi(lewat) + " dari jam masuk (" + JADWAL.jamMasuk + ").";
        }

        pengingat.hidden = false;

    }

    perbaruiPengingat();
    setInterval(perbaruiPengingat, 30000);

    $("btnPengingat").addEventListener("click", function () {
        if (!input.disabled) {
            if (berkas) { btnKirim.focus(); } else { input.click(); }
        }
    });

    /* ---------- foto ---------- */

    function tampilPesan(teks, jenis) {
        pesan.textContent = teks;
        pesan.className = "ad-pesan " + jenis;
    }

    function hapusPesan() {
        pesan.className = "ad-pesan";
        pesan.textContent = "";
    }

    function pilih(file) {

        hapusPesan();

        if (!file) return;

        if (JENIS.indexOf(file.type) === -1) {
            tampilPesan("Format foto harus JPG, PNG, atau WEBP.", "salah");
            return;
        }

        if (file.size > MAKS) {
            tampilPesan("Ukuran foto maksimal 5 MB.", "salah");
            return;
        }

        if (urlSementara) URL.revokeObjectURL(urlSementara);

        berkas = file;
        urlSementara = URL.createObjectURL(file);
        gambar.src = urlSementara;

        drop.hidden = true;
        preview.hidden = false;

    }

    input.addEventListener("change", function () {
        pilih(input.files[0]);
    });

    /* seret & lepas */
    ["dragenter", "dragover"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); if (!input.disabled) drop.classList.add("seret"); });
    });
    ["dragleave", "drop"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); drop.classList.remove("seret"); });
    });
    drop.addEventListener("drop", function (e) {
        if (!input.disabled && e.dataTransfer.files.length) pilih(e.dataTransfer.files[0]);
    });

    btnGanti.addEventListener("click", function () {
        input.value = "";
        input.click();
    });

    function dua(n) { return n < 10 ? "0" + n : "" + n; }

    btnKirim.addEventListener("click", function () {

        if (!berkas) {
            tampilPesan("Pilih atau ambil foto di salon terlebih dahulu.", "salah");
            return;
        }

        /* demo: nanti kirim berkas ke server (FormData + fetch) dan simpan ke ../uploads/presensi/
           server mencatat status 'masuk' + waktu_dicatat di tabel kehadiran */
        const sekarang = new Date();
        const jam = dua(sekarang.getHours()) + ":" + dua(sekarang.getMinutes());

        sudahPresensi = true;
        perbaruiPengingat();

        $("pilPresensi").textContent = "Aktif";
        $("pilPresensi").className = "ad-pil ok";
        $("teksStatus").textContent = "Aktif · terkirim " + jam;

        btnKirim.disabled = true;
        btnGanti.hidden = true;
        tampilPesan("Presensi terkirim pukul " + jam + ". Status Anda sekarang Aktif.", "benar");

    });

})();


/* ===== sidebar & menu pengguna ===== */

(function () {

    const body = document.body;
    const burger = document.getElementById("burger");
    const overlay = document.getElementById("overlay");
    const LEBAR_DESKTOP = 1000;

    function desktop() {
        return window.innerWidth >= LEBAR_DESKTOP;
    }

    function atur(buka, simpan) {

        body.classList.toggle("sb-open", buka);

        burger.setAttribute("aria-expanded", buka ? "true" : "false");
        burger.setAttribute("aria-label", buka ? "Tutup menu" : "Buka menu");

        /* pilihan buka/tutup hanya diingat untuk desktop */
        if (simpan && desktop()) {
            try {
                localStorage.setItem("pegawaiSidebar", buka ? "1" : "0");
            } catch (e) { /* abaikan */ }
        }

    }

    /* keadaan awal: desktop terbuka (kecuali pernah ditutup), HP tertutup */

    let awal = desktop();

    if (desktop()) {
        try {
            const s = localStorage.getItem("pegawaiSidebar");
            if (s !== null) awal = s === "1";
        } catch (e) { /* abaikan */ }
    }

    atur(awal, false);

    requestAnimationFrame(function () {
        requestAnimationFrame(function () {
            body.classList.add("sb-ready");
        });
    });

    burger.addEventListener("click", function () {
        atur(!body.classList.contains("sb-open"), true);
    });

    overlay.addEventListener("click", function () {
        atur(false, false);
    });

    let sebelumnyaDesktop = desktop();

    window.addEventListener("resize", function () {

        const sekarang = desktop();

        if (sekarang !== sebelumnyaDesktop) {
            atur(sekarang, false);
            sebelumnyaDesktop = sekarang;
        }

    });


    /* menu pengguna di kanan atas */

    const userBtn = document.getElementById("userBtn");
    const userMenu = document.getElementById("userMenu");

    function tutupUser() {
        userMenu.classList.remove("show");
        userBtn.setAttribute("aria-expanded", "false");
    }

    userBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        const buka = !userMenu.classList.contains("show");
        userMenu.classList.toggle("show", buka);
        userBtn.setAttribute("aria-expanded", buka ? "true" : "false");
    });

    document.addEventListener("click", function (e) {
        if (!userMenu.contains(e.target)) tutupUser();
    });

    document.addEventListener("keydown", function (e) {

        if (e.key !== "Escape") return;

        tutupUser();

        if (body.classList.contains("sb-open") && !desktop()) {
            atur(false, false);
        }

    });

})();

</script>

</body>
</html>
