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
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
        'koin'     => '<circle cx="12" cy="12" r="9"/><path d="M14.500 9.200c-.5-.8-1.400-1.200-2.500-1.200-1.400 0-2.500.7-2.500 1.800s1 1.500 2.500 1.900 2.500.8 2.500 1.900S13.400 16 12 16c-1.100 0-2-.4-2.500-1.200"/><path d="M12 6v2M12 16v2"/>',
        'naik'     => '<path d="M12 19V5M6 11l6-6 6 6"/>',
        'panah'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'wajah'    => '<circle cx="12" cy="12" r="9"/><path d="M8.500 14.500c1 1.200 2 1.800 3.500 1.800s2.500-.6 3.500-1.800"/><path d="M9 10h.01M15 10h.01"/>',
        'tetes'    => '<path d="M12 3s6 6.200 6 10.500a6 6 0 0 1-12 0C6 9.200 12 3 12 3z"/>',
        'kilau'    => '<path d="M12 3l1.800 5.200L19 10l-5.200 1.800L12 17l-1.800-5.200L5 10l5.200-1.800z"/><path d="M19 17l.7 1.800 1.800.7-1.800.7L19 22l-.7-1.800-1.800-.7 1.800-.7z"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

$bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
function tglPendek($ts) {
    global $bulan;
    return date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)];
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',    true],
    ['salon.php',     'Data Salon', 'store',   false],
    ['layanan.php',   'Layanan',    'gunting', false],
    ['pegawai.php',   'Pegawai',    'users',   false],
    ['laporan.php',   'Laporan',    'laporan', false],
    ['profil.php',    'Profil',     'user',    false],
];

$stat = [
    ['kalender', 'rose',   '12',          'Total Reservasi Hari Ini', '20% dari kemarin'],
    ['users',    'violet', '5',           'Total Pegawai',            '1 baru'],
    ['store',    'green',  '3',           'Total Salon',              '1 baru'],
    ['koin',     'blue',   'Rp2.450.000', 'Total Pendapatan Hari Ini', '15% dari kemarin'],
];

$hariIni = strtotime('today');

$reservasi = [
    ['Rina Putri',       'Facial',       '10:00', 'Dikonfirmasi'],
    ['Dewi Lestari',     'Hair Cut',     '11:30', 'Dikonfirmasi'],
    ['Sinta Ramadhani',  'Manicure',     '13:00', 'Menunggu'],
    ['Ayu Pratiwi',      'Massage',      '14:30', 'Dikonfirmasi'],
    ['Nadya Putri',      'Hair Coloring', '16:00', 'Menunggu'],
];

/* pendapatan 7 hari terakhir, dalam juta rupiah (hari tertua -> hari ini) */
$pendapatan = [1.7, 2.1, 2.2, 2.1, 2.5, 2.9, 3.5];
$batasAtas = 4; // skala sumbu y (juta)

$layananTerlaris = [
    ['Facial',     28, 'wajah'],
    ['Hair Cut',   22, 'gunting'],
    ['Creambath',  18, 'tetes'],
    ['Hair Spa',   15, 'kilau'],
];
$pesananMaks = max(array_column($layananTerlaris, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Salon</title>
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
        .ad-user .ad-ava { background: #c4938d; color: #fff; width: 48px; height: 48px; }
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

        .ad-sapa h1 { margin: 0; font-size: clamp(28px, 3.2vw, 40px); font-weight: 700; letter-spacing: -.01em; }
        .ad-sapa p { margin: 10px 0 0; font-size: 19px; color: var(--muted); }

        /* kartu statistik */
        .ad-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px; margin-top: 34px; }
        .ad-stat { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 22px 24px 24px; }
        .ad-ic { width: 62px; height: 62px; border-radius: 50%; display: grid; place-items: center; }
        .ad-ic svg { width: 30px; height: 30px; }
        .ad-ic.rose { background: #fbe1de; color: #b4524a; }
        .ad-ic.violet { background: #e8e2fa; color: #5f4ab0; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-ic.blue { background: #dcebfb; color: #2a68b0; }
        .ad-stat .nilai { margin-top: 22px; font-size: 30px; font-weight: 700; line-height: 1; }
        .ad-stat .judul { margin-top: 10px; font-size: 16px; color: #4d4650; }
        .ad-stat .tren { margin-top: 16px; display: flex; align-items: center; gap: 6px; font-size: 15px; color: #1f7a4d; }
        .ad-stat .tren svg { width: 17px; height: 17px; }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-semua { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; color: #5d5560; text-decoration: none; white-space: nowrap; }
        .ad-semua:hover { color: var(--rose-dark); }
        .ad-semua svg { width: 17px; height: 17px; }

        .ad-baris { display: grid; grid-template-columns: minmax(0, 1.65fr) minmax(0, 1fr); gap: 24px; margin-top: 28px; }

        /* tabel */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 560px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 15px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-pil { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.tunggu { background: #fdf0d3; color: #8a5a00; }

        /* grafik */
        .ad-plot { position: relative; height: 250px; margin: 10px 0 0 46px; }
        .ad-garis { position: absolute; left: 0; right: 0; border-top: 1px solid #efe8e4; }
        .ad-garis span { position: absolute; left: -46px; top: -9px; width: 38px; text-align: right; font-size: 13px; color: #6b6470; }
        .ad-batang {
    position: absolute; inset: 0;
    display: grid; grid-template-columns: repeat(7, minmax(0, 1fr));
    align-items: end; justify-items: center;
}
.ad-bar { width: 100%; max-width: 34px; background: var(--rose-soft); border-radius: 3px 3px 0 0; min-height: 4px; }
.ad-bar:hover { background: var(--rose-dark); }

.ad-sumbu-x {
    display: grid; grid-template-columns: repeat(7, minmax(0, 1fr));
    margin: 10px 0 0 46px;
}
.ad-sumbu-x span { text-align: center; font-size: 12px; line-height: 1.3; color: #6b6470; }
        /* layanan terlaris */
        .ad-terlaris { margin-top: 28px; }
        .ad-terlaris-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px 0; }
        .ad-ter { display: flex; align-items: center; gap: 18px; padding: 4px 28px; min-width: 0; }
        .ad-ter:nth-child(odd) { padding-left: 0; border-right: 1px solid var(--line); }
        .ad-ter:nth-child(even) { padding-right: 0; }
        .ad-ter .ad-ic { width: 54px; height: 54px; background: #f8e3e0; color: #b4635c; }
        .ad-ter .ad-ic svg { width: 26px; height: 26px; }
        .ad-ter-info { width: 110px; flex: none; }
        .ad-ter-info b { display: block; font-size: 16px; font-weight: 500; }
        .ad-ter-info small { display: block; margin-top: 4px; font-size: 14px; color: var(--muted); }
        .ad-prog { flex: 1; height: 9px; background: #efe7e3; border-radius: 999px; overflow: hidden; min-width: 60px; }
        .ad-prog i { display: block; height: 100%; background: var(--rose-soft); border-radius: 999px; }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible { outline: 2px solid #c4938d; outline-offset: 2px; }

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

        @media (max-width: 1200px) {
            .ad-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .ad-baris { grid-template-columns: 1fr; }
        }

        @media (max-width: 760px) {
            .ad-terlaris-grid { grid-template-columns: 1fr; }
            .ad-ter:nth-child(odd), .ad-ter:nth-child(even) { padding: 4px 0; border-right: 0; }
            .ad-user-info { display: none; }
        }

        @media (max-width: 520px) {
            .ad-stats { grid-template-columns: 1fr; }
            .ad-kartu { padding: 20px 16px; }
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

            <!-- SAMBUTAN -->

            <section class="ad-sapa">
                <h1>Selamat datang, <?= e($admin['nama']) ?>!</h1>
                <p>Berikut ringkasan aktivitas salon Anda hari ini.</p>
            </section>


            <!-- STATISTIK -->

            <section class="ad-stats">
                <?php foreach ($stat as $s): ?>
                    <div class="ad-stat">
                        <div class="ad-ic <?= e($s[1]) ?>"><?= ikon($s[0]) ?></div>
                        <div class="nilai"><?= e($s[2]) ?></div>
                        <div class="judul"><?= e($s[3]) ?></div>
                        <div class="tren"><?= ikon('naik') ?> <?= e($s[4]) ?></div>
                    </div>
                <?php endforeach; ?>
            </section>


            <!-- RESERVASI + PENDAPATAN -->

            <section class="ad-baris">

                <div class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Reservasi Terbaru</h2>
                        <a class="ad-semua" href="laporan.php">Lihat Semua <?= ikon('panah') ?></a>
                    </div>

                    <div class="ad-tabel-box">
                        <table class="ad-tabel">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Layanan</th>
                                    <th>Tanggal &amp; Waktu</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reservasi as $i => $r): ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td><?= e($r[0]) ?></td>
                                        <td><?= e($r[1]) ?></td>
                                        <td><?= e(tglPendek($hariIni) . ' ' . date('Y', $hariIni) . ', ' . $r[2]) ?></td>
                                        <td>
                                            <span class="ad-pil <?= $r[3] === 'Dikonfirmasi' ? 'ok' : 'tunggu' ?>"><?= e($r[3]) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>


                <div class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Pendapatan 7 Hari Terakhir</h2>
                    </div>

                    <div class="ad-plot">

                        <?php for ($t = $batasAtas; $t >= 0; $t--): ?>
                            <div class="ad-garis" style="top:<?= (($batasAtas - $t) / $batasAtas) * 100 ?>%">
                                <span><?= $t === 0 ? '0' : $t . ' jt' ?></span>
                            </div>
                        <?php endfor; ?>

                        <div class="ad-batang">
                            <?php foreach ($pendapatan as $v): ?>
                                <div
                                    class="ad-bar"
                                    style="height:<?= min(100, ($v / $batasAtas) * 100) ?>%"
                                    title="Rp<?= e(number_format($v, 1, ',', '.')) ?> jt">
                                </div>
                            <?php endforeach; ?>
                        </div>

                    </div>

                    <div class="ad-sumbu-x">
                        <?php for ($d = 6; $d >= 0; $d--): ?>
                            <span><?= e(tglPendek(strtotime("-$d day", $hariIni))) ?></span>
                        <?php endfor; ?>
                    </div>

                </div>

            </section>


            <!-- LAYANAN TERLARIS -->

            <section class="ad-kartu ad-terlaris">

                <div class="ad-kartu-head">
                    <h2>Layanan Paling Banyak Dipesan</h2>
                    <a class="ad-semua" href="layanan.php">Lihat Semua <?= ikon('panah') ?></a>
                </div>

                <div class="ad-terlaris-grid">
                    <?php foreach ($layananTerlaris as $l): ?>
                        <div class="ad-ter">
                            <div class="ad-ic"><?= ikon($l[2]) ?></div>
                            <div class="ad-ter-info">
                                <b><?= e($l[0]) ?></b>
                                <small><?= (int)$l[1] ?> pesanan</small>
                            </div>
                            <div class="ad-prog" role="img" aria-label="<?= (int)$l[1] ?> dari <?= (int)$pesananMaks ?> pesanan tertinggi">
                                <i style="width:<?= round(($l[1] / $pesananMaks) * 100) ?>%"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


<script>

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