<?php
date_default_timezone_set('Asia/Jakarta');

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

/* ikon garis (stroke) */
function ikon($nama) {
    $p = [
        'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'store'    => '<path d="M3 9l1.5-5h15L21 9"/><path d="M4 9v11h16V9"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M10 20v-5h4v5"/>',
        'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
        'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.500 20c0-3.600 2.900-6 6.500-6s6.500 2.400 6.500 6"/><circle cx="17.500" cy="9" r="2.500"/><path d="M17 14.200c2.600.2 4.500 2 4.500 4.800"/>',
        'laporan'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 17v-3M12 17v-5M15 17v-2"/>',
        'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
        'koin'     => '<circle cx="12" cy="12" r="9"/><path d="M14.500 9.200c-.5-.8-1.400-1.200-2.500-1.200-1.400 0-2.500.7-2.500 1.800s1 1.500 2.500 1.900 2.500.8 2.500 1.900S13.400 16 12 16c-1.100 0-2-.4-2.500-1.200"/><path d="M12 6v2M12 16v2"/>',
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
        'kilau'    => '<path d="M12 3l1.800 5.200L19 10l-5.200 1.800L12 17l-1.800-5.200L5 10l5.200-1.800z"/><path d="M19 17l.7 1.800 1.800.7-1.800.7L19 22l-.7-1.800-1.800-.7 1.800-.7z"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function rupiah($n) { return 'Rp' . number_format((int)$n, 0, ',', '.'); }
function jt($v)     { return 'Rp' . str_replace('.', ',', rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.')) . ' jt'; }

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',    false],
    ['salon.php',     'Data Salon', 'store',   false],
    ['layanan.php',   'Layanan',    'gunting', false],
    ['pegawai.php',   'Pegawai',    'users',   false],
    ['laporan.php',   'Laporan',    'laporan', true],
    ['profil.php',    'Profil',     'user',    false],
];

$namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$bulanDipilih = 'Juni';
$tahunDipilih = '2026';

/* layanan: kode => [nama, harga] */
$layanan = [
    'creambath' => ['Creambath',     100000],
    'hairspa'   => ['Hair Spa',      150000],
    'potong'    => ['Potong Rambut',  50000],
    'coloring'  => ['Hair Coloring', 250000],
];

/* pegawai: [nama, keahlian, jumlah booking per layanan pada bulan terpilih] */
$pegawai = [
    ['Dewi Lestari',   'Hair Stylist',    ['creambath' => 6, 'hairspa' => 5, 'potong' => 8,  'coloring' => 0]],
    ['Andi Pratama',   'Barber',          ['creambath' => 0, 'hairspa' => 0, 'potong' => 12, 'coloring' => 0]],
    ['Maya Putri',     'Facial & Beauty', ['creambath' => 9, 'hairspa' => 5, 'potong' => 0,  'coloring' => 0]],
    ['Rani Salsabila', 'Hair Coloring',   ['creambath' => 0, 'hairspa' => 0, 'potong' => 0,  'coloring' => 5]],
];

/* hitung total per layanan */
$perLayanan = [];
foreach ($layanan as $kode => $l) {
    $jumlah = 0;
    foreach ($pegawai as $p) { $jumlah += $p[2][$kode]; }
    $perLayanan[$kode] = ['nama' => $l[0], 'harga' => $l[1], 'jumlah' => $jumlah, 'total' => $jumlah * $l[1]];
}

/* hitung total per pegawai */
$perPegawai = [];
foreach ($pegawai as $p) {
    $booking = 0; $total = 0; $rincian = [];
    foreach ($layanan as $kode => $l) {
        $n = $p[2][$kode];
        if ($n > 0) { $rincian[] = $l[0] . ' ×' . $n; }
        $booking += $n;
        $total   += $n * $l[1];
    }
    $perPegawai[] = ['nama' => $p[0], 'keahlian' => $p[1], 'booking' => $booking, 'total' => $total, 'rincian' => $rincian];
}
usort($perPegawai, function ($a, $b) { return $b['total'] <=> $a['total']; });

$totalPenghasilan = array_sum(array_column($perLayanan, 'total'));
$totalBooking     = array_sum(array_column($perLayanan, 'jumlah'));

/* layanan terlaris = booking terbanyak */
$terlaris = $perLayanan[array_keys($perLayanan)[0]];
foreach ($perLayanan as $pl) { if ($pl['jumlah'] > $terlaris['jumlah']) $terlaris = $pl; }

/* penghasilan bulanan (juta rupiah), bulan terakhir = bulan terpilih */
$bulanan = [
    ['Jan', 3.0], ['Feb', 3.8], ['Mar', 4.2], ['Apr', 4.8], ['Mei', 4.6],
    ['Jun', $totalPenghasilan / 1000000],
];
$skala = 6; /* batas atas grafik (juta) */

function inisial($nama) {
    $k = preg_split('/\s+/', trim($nama));
    $i = mb_strtoupper(mb_substr($k[0], 0, 1));
    if (count($k) > 1) $i .= mb_strtoupper(mb_substr($k[count($k) - 1], 0, 1));
    return $i;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Halaman ini berdiri sendiri: semua gaya ada di blok <style> di bawah -->
    <style>
        :root {
            --side: 232px;
            --rose: #a9726c;
            --rose-dark: #96605a;
            --rose-soft: #c4938d;
            --ink: #1f1a1a;
            --muted: #6b6470;
            --line: #ece4df;
            --bg: #fbf8f6;
        }

        * { box-sizing: border-box; }

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
        .ad-link:hover { background: rgba(255, 255, 255, .12); }
        .ad-link.active { background: rgba(255, 255, 255, .24); font-weight: 600; opacity: 1; }
        .ad-link svg { width: 20px; height: 20px; }

        .ad-side-bawah { margin-top: auto; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, .28); }
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
        .ad-user .ad-ava { background: #c4938d; color: #fff; width: 48px; height: 48px; font-size: 17px; }
        .ad-user-info { text-align: left; line-height: 1.25; }
        .ad-user-info b { display: block; font-size: 16px; font-weight: 500; }
        .ad-user-info small { display: block; font-size: 14px; color: var(--muted); }
        .ad-user > svg { width: 20px; height: 20px; color: #4a4348; margin-left: 6px; }

        .ad-dd { display: none; position: absolute; right: 0; top: calc(100% + 8px); min-width: 200px; background: #fff; border: 1px solid var(--line); border-radius: 12px; box-shadow: 0 12px 32px rgba(60, 30, 25, .14); padding: 6px; z-index: 300; }
        .ad-dd.show { display: block; }
        .ad-dd a { display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 8px; text-decoration: none; font-size: 15px; }
        .ad-dd a:hover { background: #f6ece7; }
        .ad-dd svg { width: 20px; height: 20px; color: var(--rose); }

        .ad-main { flex: 1; padding: 36px clamp(18px, 3vw, 44px) 56px; }

        .ad-sapa-baris { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; }
        .ad-sapa h1 { margin: 0; font-size: clamp(28px, 3.2vw, 40px); font-weight: 700; letter-spacing: -.01em; }
        .ad-sapa p { margin: 10px 0 0; font-size: 19px; color: var(--muted); }

        /* filter */
        .ad-filter { display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap; }
        .ad-field { display: flex; flex-direction: column; gap: 6px; }
        .ad-field label { font-size: 13.5px; font-weight: 500; color: #4d4650; }
        .ad-field select {
            font-family: inherit; font-size: 15px; color: var(--ink); background: #fff; border: 1px solid #e3d8d2;
            border-radius: 10px; padding: 11px 14px; min-width: 140px;
        }
        .ad-field select:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }

        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 22px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; background: var(--rose); color: #fff; transition: background .15s;
        }
        .ad-btn:hover { background: var(--rose-dark); }

        /* kartu statistik */
        .ad-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px; margin-top: 30px; }
        .ad-stat { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 22px 24px 24px; }
        .ad-ic { width: 56px; height: 56px; border-radius: 50%; display: grid; place-items: center; }
        .ad-ic svg { width: 28px; height: 28px; }
        .ad-ic.rose { background: #fbe1de; color: #b4524a; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-ic.violet { background: #e8e2fa; color: #5f4ab0; }
        .ad-stat .judul { margin-top: 18px; font-size: 15.5px; color: #4d4650; }
        .ad-stat .nilai { margin-top: 8px; font-size: 28px; font-weight: 700; line-height: 1.1; }
        .ad-stat .info { margin-top: 8px; font-size: 14px; color: var(--muted); }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 24px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 6px; flex-wrap: wrap; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-sub { margin: 0 0 20px; font-size: 14.5px; color: var(--muted); }
        .ad-lencana { font-size: 13px; font-weight: 500; padding: 6px 12px; border-radius: 8px; background: #f7f2ef; color: #5d504c; white-space: nowrap; }

        /* grafik batang */
        .ad-grafik { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 12px; align-items: end; padding: 0 4px; }
        .ad-kol { display: flex; flex-direction: column; align-items: center; min-width: 0; }
        .ad-kol .nilai-bar { font-size: 13px; font-weight: 600; margin-bottom: 8px; white-space: nowrap; }
        .ad-area { width: 100%; height: 220px; display: flex; align-items: flex-end; justify-content: center; border-bottom: 1px solid #d9cdc8; }
        .ad-bar { width: 100%; max-width: 56px; background: var(--rose-soft); border-radius: 4px 4px 0 0; min-height: 4px; }
        .ad-bar:hover { background: var(--rose-dark); }
        .ad-kol.sekarang .ad-bar { background: var(--rose); }
        .ad-kol .bln { margin-top: 10px; font-size: 13.5px; color: var(--muted); }
        .ad-kol.sekarang .bln { color: var(--ink); font-weight: 600; }

        /* tabel */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 640px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel th.kanan, .ad-tabel td.kanan { text-align: right; }
        .ad-tabel td { padding: 15px 14px; border-bottom: 1px solid var(--line); vertical-align: middle; white-space: nowrap; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-tabel .tebal { font-weight: 600; }
        .ad-tabel tr.jumlah td { background: #fbf4f1; font-weight: 700; border-top: 1px solid var(--line); }
        .ad-tabel tr.jumlah td:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel tr.jumlah td:last-child { border-radius: 0 8px 8px 0; }

        /* per pegawai */
        .ad-org { display: flex; align-items: center; gap: 12px; }
        .ad-org .ad-ava { width: 40px; height: 40px; background: #f2dcd8; color: #8a4a44; font-size: 14px; }
        .ad-org b { display: block; font-weight: 600; }
        .ad-org small { display: block; margin-top: 2px; font-size: 13px; color: var(--muted); }
        .ad-ket { white-space: normal !important; min-width: 200px; font-size: 14px; color: #4d4650; }
        .ad-kontrib { display: flex; align-items: center; gap: 10px; min-width: 150px; }
        .ad-prog { flex: 1; height: 9px; background: #efe7e3; border-radius: 999px; overflow: hidden; min-width: 70px; }
        .ad-prog i { display: block; height: 100%; background: var(--rose-soft); border-radius: 999px; }
        .ad-kontrib span { font-size: 14px; width: 44px; text-align: right; }
        .ad-juara { display: inline-block; margin-left: 8px; padding: 2px 8px; border-radius: 6px; background: #fdf0d3; color: #8a5a00; font-size: 12px; font-weight: 500; vertical-align: middle; }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible, .ad-btn:focus-visible { outline: 2px solid #c4938d; outline-offset: 2px; }

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

        @media (max-width: 900px) {
            .ad-stats { grid-template-columns: 1fr; }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
            .ad-grafik { gap: 6px; }
            .ad-kol .nilai-bar { font-size: 11px; }
            .ad-area { height: 170px; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-filter, .ad-field, .ad-field select, .ad-filter .ad-btn { width: 100%; }
        }
    </style>
</head>
<body class="ad-body">

    <!-- ===== SIDEBAR ===== -->
    <aside class="ad-side" id="sidebar" aria-label="Menu admin">

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
                <div class="ad-ava"><?= e($admin['inisial']) ?></div>
                <div>
                    <b><?= e($admin['nama']) ?></b>
                    <small><?= e($admin['peran']) ?></small>
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

                    <span class="ad-ava"><?= e($admin['inisial']) ?></span>

                    <span class="ad-user-info">
                        <b><?= e($admin['nama']) ?></b>
                        <small><?= e($admin['peran']) ?></small>
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

            <div class="ad-sapa-baris">

                <section class="ad-sapa">
                    <h1>Laporan Salon</h1>
                    <p>Pantau penghasilan dan aktivitas salon.</p>
                </section>

                <!-- FILTER -->
                <div class="ad-filter">

                    <div class="ad-field">
                        <label for="bulan">Bulan</label>
                        <select id="bulan">
                            <?php foreach ($namaBulan as $b): ?>
                                <option value="<?= e($b) ?>"<?= $b === $bulanDipilih ? ' selected' : '' ?>><?= e($b) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="ad-field">
                        <label for="tahun">Tahun</label>
                        <select id="tahun">
                            <option<?= $tahunDipilih === '2026' ? ' selected' : '' ?>>2026</option>
                            <option<?= $tahunDipilih === '2025' ? ' selected' : '' ?>>2025</option>
                        </select>
                    </div>

                    <button type="button" class="ad-btn" id="btnTampil">Tampilkan</button>

                </div>

            </div>


            <!-- RINGKASAN -->

            <section class="ad-stats">

                <div class="ad-stat">
                    <div class="ad-ic rose"><?= ikon('koin') ?></div>
                    <div class="judul">Total Penghasilan</div>
                    <div class="nilai"><?= e(rupiah($totalPenghasilan)) ?></div>
                    <div class="info"><?= e($bulanDipilih . ' ' . $tahunDipilih) ?></div>
                </div>

                <div class="ad-stat">
                    <div class="ad-ic green"><?= ikon('kalender') ?></div>
                    <div class="judul">Total Booking</div>
                    <div class="nilai"><?= (int)$totalBooking ?></div>
                    <div class="info"><?= e($bulanDipilih . ' ' . $tahunDipilih) ?></div>
                </div>

                <div class="ad-stat">
                    <div class="ad-ic violet"><?= ikon('kilau') ?></div>
                    <div class="judul">Layanan Terlaris</div>
                    <div class="nilai"><?= e($terlaris['nama']) ?></div>
                    <div class="info"><?= (int)$terlaris['jumlah'] ?> booking</div>
                </div>

            </section>


            <!-- PENGHASILAN PER PEGAWAI -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Penghasilan per Pegawai</h2>
                    <span class="ad-lencana"><?= e($bulanDipilih . ' ' . $tahunDipilih) ?></span>
                </div>
                <p class="ad-sub">Berapa penghasilan yang dihasilkan setiap pegawai dalam satu bulan, dari layanan yang mereka kerjakan.</p>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pegawai</th>
                                <th>Layanan yang Dikerjakan</th>
                                <th class="kanan">Booking</th>
                                <th class="kanan">Total Penghasilan</th>
                                <th>Kontribusi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($perPegawai as $i => $p): ?>
                                <?php $persen = $totalPenghasilan > 0 ? round($p['total'] / $totalPenghasilan * 100) : 0; ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td>
                                        <div class="ad-org">
                                            <span class="ad-ava"><?= e(inisial($p['nama'])) ?></span>
                                            <span>
                                                <b><?= e($p['nama']) ?><?php if ($i === 0): ?><span class="ad-juara">Tertinggi</span><?php endif; ?></b>
                                                <small><?= e($p['keahlian']) ?></small>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="ad-ket"><?= e(implode(', ', $p['rincian'])) ?></td>
                                    <td class="kanan"><?= (int)$p['booking'] ?></td>
                                    <td class="kanan tebal"><?= e(rupiah($p['total'])) ?></td>
                                    <td>
                                        <div class="ad-kontrib">
                                            <div class="ad-prog" role="img" aria-label="<?= $persen ?> persen dari total penghasilan"><i style="width:<?= $persen ?>%"></i></div>
                                            <span><?= $persen ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="jumlah">
                                <td colspan="3">Total</td>
                                <td class="kanan"><?= (int)$totalBooking ?></td>
                                <td class="kanan"><?= e(rupiah($totalPenghasilan)) ?></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>


            <!-- PENGHASILAN BULANAN -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Penghasilan Bulanan</h2>
                </div>
                <p class="ad-sub">Perbandingan penghasilan salon setiap bulan.</p>

                <div class="ad-grafik">
                    <?php foreach ($bulanan as $i => $b): ?>
                        <div class="ad-kol<?= $i === count($bulanan) - 1 ? ' sekarang' : '' ?>">
                            <div class="nilai-bar"><?= e(jt($b[1])) ?></div>
                            <div class="ad-area">
                                <div class="ad-bar" style="height:<?= min(100, round(($b[1] / $skala) * 100)) ?>%" title="<?= e(jt($b[1])) ?>"></div>
                            </div>
                            <div class="bln"><?= e($b[0]) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </section>


            <!-- DETAIL PER LAYANAN -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Detail Penghasilan</h2>
                </div>
                <p class="ad-sub">Rincian penghasilan berdasarkan layanan.</p>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Layanan</th>
                                <th class="kanan">Jumlah Booking</th>
                                <th class="kanan">Harga</th>
                                <th class="kanan">Total Penghasilan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; foreach ($perLayanan as $l): $no++; ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td class="tebal"><?= e($l['nama']) ?></td>
                                    <td class="kanan"><?= (int)$l['jumlah'] ?></td>
                                    <td class="kanan"><?= e(rupiah($l['harga'])) ?></td>
                                    <td class="kanan tebal"><?= e(rupiah($l['total'])) ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <tr class="jumlah">
                                <td colspan="2">Total</td>
                                <td class="kanan"><?= (int)$totalBooking ?></td>
                                <td></td>
                                <td class="kanan"><?= e(rupiah($totalPenghasilan)) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


<script>

/* tombol Tampilkan (demo): nanti muat ulang laporan sesuai bulan & tahun */
document.getElementById("btnTampil").addEventListener("click", function () {
    alert(
        "Menampilkan laporan " +
        document.getElementById("bulan").value + " " +
        document.getElementById("tahun").value
    );
});


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
                localStorage.setItem("adminSidebar", buka ? "1" : "0");
            } catch (e) { /* abaikan */ }
        }

    }

    /* keadaan awal: desktop terbuka (kecuali pernah ditutup), HP tertutup */

    let awal = desktop();

    if (desktop()) {
        try {
            const s = localStorage.getItem("adminSidebar");
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