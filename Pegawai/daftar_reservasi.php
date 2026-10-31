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
        'cari'     => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/>',
        'cetak'    => '<path d="M7 9V3h10v6"/><rect x="4" y="9" width="16" height="8" rx="2"/><path d="M7 14h10v7H7z"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function rupiah($n) { return 'Rp' . number_format((int)$n, 0, ',', '.'); }

$hariPendek  = [1 => 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
$bulanPendek = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

/* "Kam, 29 Okt 2026" */
function tglLengkap($dt) {
    global $hariPendek, $bulanPendek;
    $t = strtotime($dt);
    return $hariPendek[(int)date('N', $t)] . ', ' . date('j', $t) . ' ' . $bulanPendek[(int)date('n', $t)] . ' ' . date('Y', $t);
}
/* "29 Okt 2026" */
function tglSingkat($dt) {
    global $bulanPendek;
    $t = strtotime($dt);
    return date('j', $t) . ' ' . $bulanPendek[(int)date('n', $t)] . ' ' . date('Y', $t);
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    false],
    ['detail_booking.php',   'Detail Reservasi', 'daftar',  false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', true],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', false],
    ['profil.php',           'Profil',           'user',    false],
];

$salon = 'Luna Salon · Bandung';

/*
 * Hanya reservasi yang sudah DIKONFIRMASI pegawai.
 * item: [nama tamu, layanan, dilayani oleh, jadwal (Y-m-d H:i), harga]
 * bayar: 'Lunas' (bayar penuh) atau 'DP' (sebagian, nilai di 'dp')
 */
$reservasi = [
    [
        'kode' => 'RSV-002', 'pelanggan' => 'Dewi', 'telepon' => '081298765432',
        'dibuat' => '2026-10-15 09:40', 'metode' => 'Transfer bank (bayar penuh)', 'bayar' => 'Lunas', 'dp' => 0,
        'item' => [
            ['Dewi (Saya)', 'Potong Rambut', 'Andi', '2026-10-17 13:00', 50000],
        ],
    ],
    [
        'kode' => 'RSV-003', 'pelanggan' => 'Maya', 'telepon' => '081377788899',
        'dibuat' => '2026-10-16 11:05', 'metode' => 'Transfer bank (bayar penuh)', 'bayar' => 'Lunas', 'dp' => 0,
        'item' => [
            ['Maya (Saya)', 'Hair Spa', 'Dewi', '2026-10-18 15:00', 150000],
        ],
    ],
    [
        'kode' => 'RSV-004', 'pelanggan' => 'Rina', 'telepon' => '081234567890',
        'dibuat' => '2026-10-29 14:20', 'metode' => 'Transfer bank (bayar penuh)', 'bayar' => 'Lunas', 'dp' => 0,
        'item' => [
            ['Rina (Saya)',   'Creambath', 'Rani', '2026-11-01 18:00', 100000],
            ['Dewi (Teman)',  'Facial',    'Maya', '2026-11-01 19:00', 120000],
        ],
    ],
    [
        'kode' => 'RSV-005', 'pelanggan' => 'Sinta', 'telepon' => '081355566677',
        'dibuat' => '2026-10-30 10:15', 'metode' => 'Transfer bank (DP 50%)', 'bayar' => 'DP', 'dp' => 125000,
        'item' => [
            ['Sinta (Saya)', 'Hair Coloring', 'Rani', '2026-11-02 11:00', 250000],
        ],
    ],
];

/* hitung total & urutkan menurut jadwal terdekat */
foreach ($reservasi as $i => $r) {
    $total = 0;
    foreach ($r['item'] as $it) { $total += $it[4]; }
    $reservasi[$i]['total']   = $total;
    $reservasi[$i]['dibayar'] = $r['bayar'] === 'Lunas' ? $total : $r['dp'];
    $reservasi[$i]['sisa']    = $total - $reservasi[$i]['dibayar'];
    $reservasi[$i]['jadwal']  = $r['item'][0][3];
}
usort($reservasi, function ($a, $b) { return strcmp($a['jadwal'], $b['jadwal']); });
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi</title>
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

        .ad-sapa h1 { margin: 0; font-size: clamp(28px, 3.2vw, 40px); font-weight: 700; letter-spacing: -.01em; }
        .ad-sapa p { margin: 10px 0 0; font-size: 19px; color: var(--muted); }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 28px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 18px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-jumlah { font-size: 14px; color: var(--muted); }

        /* filter */
        .ad-filter { display: flex; flex-wrap: wrap; align-items: flex-end; gap: 14px; margin-bottom: 20px; }
        .ad-field { display: flex; flex-direction: column; gap: 6px; flex: 1 1 200px; min-width: 0; }
        .ad-field label { font-size: 13.5px; font-weight: 500; color: #4d4650; }
        .ad-field input, .ad-field select {
            width: 100%; font-family: inherit; font-size: 15px; color: var(--ink); background: #fff;
            border: 1px solid #e3d8d2; border-radius: 10px; padding: 11px 14px;
        }
        .ad-field input:focus, .ad-field select:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }

        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 22px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s;
        }
        .ad-btn svg { width: 18px; height: 18px; }
        .ad-btn.utama { background: var(--rose); color: #fff; }
        .ad-btn.utama:hover { background: var(--rose-dark); }
        .ad-btn.kedua { background: #fff; color: #4d4650; border-color: #e3d8d2; }
        .ad-btn.kedua:hover { background: #f6ece7; }

        /* tabel */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 760px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 15px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; vertical-align: middle; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-tabel .kode { font-weight: 600; }
        .ad-tabel small { color: var(--muted); }

        .ad-pil { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.dp { background: #fdf0d3; color: #8a5a00; }

        .ad-mini {
            display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-size: 13.5px; font-weight: 500;
            padding: 7px 14px; border-radius: 8px; cursor: pointer; background: #fff; border: 1px solid #e3d8d2; color: #4d4650;
        }
        .ad-mini:hover { background: #f6ece7; }

        .ad-kosong { display: none; text-align: center; padding: 36px 0 10px; color: var(--muted); }

        /* ================= INVOICE (MODAL) ================= */
        .ad-modal { display: none; position: fixed; inset: 0; z-index: 400; background: rgba(30, 18, 16, .55); align-items: flex-start; justify-content: center; padding: 24px 16px; overflow-y: auto; }
        .ad-modal.show { display: flex; }
        .ad-modal-box { position: relative; background: #fff; border-radius: 16px; width: 100%; max-width: 640px; padding: 32px 34px 28px; box-shadow: 0 20px 50px rgba(40, 20, 16, .28); margin: auto 0; }
        .ad-x { position: absolute; top: 14px; right: 14px; width: 38px; height: 38px; border: 0; border-radius: 10px; background: transparent; color: #4a4348; display: grid; place-items: center; cursor: pointer; padding: 0; }
        .ad-x:hover { background: rgba(0, 0, 0, .06); }

        .inv-kop { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; padding-bottom: 18px; border-bottom: 2px solid var(--ink); }
        .inv-merk b { display: block; font-size: 22px; font-weight: 600; letter-spacing: .14em; line-height: 1; }
        .inv-merk small { display: block; margin-top: 6px; font-size: 13px; color: var(--muted); }
        .inv-judul { text-align: right; margin-right: 40px; }
        .inv-judul span { display: block; font-size: 12px; letter-spacing: .18em; color: var(--muted); }
        .inv-judul b { display: block; margin-top: 4px; font-size: 24px; font-weight: 700; }

        .inv-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px 28px; padding: 22px 0; border-bottom: 1px solid var(--line); }
        .inv-grid small { display: block; font-size: 12px; font-weight: 500; letter-spacing: .12em; text-transform: uppercase; color: var(--muted); }
        .inv-grid b { display: block; margin-top: 5px; font-size: 15.5px; font-weight: 500; overflow-wrap: anywhere; }
        .inv-grid .ad-pil { margin-top: 5px; }

        .inv-sub { margin: 22px 0 6px; font-size: 12px; font-weight: 600; letter-spacing: .16em; text-transform: uppercase; color: #5d504c; }

        .inv-item { display: flex; justify-content: space-between; gap: 16px; padding: 16px 0; border-bottom: 1px solid var(--line); }
        .inv-item h4 { margin: 0; font-size: 17px; font-weight: 600; }
        .inv-item p { margin: 4px 0 0; font-size: 14.5px; color: #4d4650; }
        .inv-item p.waktu { color: var(--muted); }
        .inv-item .harga { font-weight: 700; white-space: nowrap; }

        .inv-baris { display: flex; justify-content: space-between; gap: 16px; padding: 10px 0; font-size: 15px; }
        .inv-baris.total { margin-top: 6px; padding-top: 16px; border-top: 2px solid var(--ink); font-size: 18px; font-weight: 700; align-items: baseline; }
        .inv-baris.total span:last-child { font-size: 26px; }
        .inv-baris.sisa { color: #8a5a00; font-weight: 600; }

        .inv-catatan { margin: 18px 0 0; font-size: 13.5px; color: var(--muted); }

        .inv-aksi { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 22px; }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible,
        .ad-btn:focus-visible, .ad-mini:focus-visible, .ad-x:focus-visible { outline: 2px solid #c4938d; outline-offset: 2px; }

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

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-modal-box { padding: 24px 18px 20px; }
            .inv-grid { grid-template-columns: 1fr; }
            .inv-kop { flex-direction: column; }
            .inv-judul { text-align: left; margin-right: 0; }
            .inv-aksi { grid-template-columns: 1fr; }
        }

        /* ================= CETAK: hanya invoice yang tercetak ================= */
        @media print {
            @page { margin: 16mm; }
            body.ad-body { background: #fff; }
            .ad-side, .ad-overlay, .ad-wrap { display: none !important; }
            .ad-modal { position: static; display: block !important; background: none; padding: 0; overflow: visible; }
            .ad-modal-box { box-shadow: none; border-radius: 0; max-width: none; padding: 0; margin: 0; }
            .ad-noprint { display: none !important; }
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

            <section class="ad-sapa">
                <h1>Daftar Reservasi</h1>
                <p>Reservasi yang sudah dikonfirmasi. Klik Detail untuk melihat dan mencetak invoice.</p>
            </section>


            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Reservasi Dikonfirmasi</h2>
                    <span class="ad-jumlah" id="jumlah"><?= count($reservasi) ?> reservasi</span>
                </div>

                <!-- FILTER -->

                <div class="ad-filter">

                    <div class="ad-field" style="flex-basis:260px">
                        <label for="cariNama">Cari pelanggan atau kode</label>
                        <input type="text" id="cariNama" placeholder="Contoh: Rina atau RSV-004">
                    </div>

                    <div class="ad-field">
                        <label for="filterTanggal">Tanggal</label>
                        <input type="date" id="filterTanggal">
                    </div>

                    <div class="ad-field">
                        <label for="filterBayar">Pembayaran</label>
                        <select id="filterBayar">
                            <option value="">Semua</option>
                            <option value="Lunas">Lunas</option>
                            <option value="DP">DP</option>
                        </select>
                    </div>

                    <button type="button" class="ad-btn kedua" id="btnReset">Reset</button>

                </div>


                <!-- TABEL -->

                <div class="ad-tabel-box">
                    <table class="ad-tabel" id="tabel">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservasi as $r): ?>
                                <?php
                                    $layananList = array_map(function ($it) { return $it[1]; }, $r['item']);
                                    $orang = count($r['item']);
                                ?>
                                <tr class="baris"
                                    data-cari="<?= e(mb_strtolower($r['pelanggan'] . ' ' . $r['kode'])) ?>"
                                    data-tanggal="<?= e(date('Y-m-d', strtotime($r['jadwal']))) ?>"
                                    data-bayar="<?= e($r['bayar']) ?>">
                                    <td class="kode"><?= e($r['kode']) ?></td>
                                    <td>
                                        <?= e($r['pelanggan']) ?>
                                        <?php if ($orang > 1): ?><small>· <?= $orang ?> orang</small><?php endif; ?>
                                    </td>
                                    <td><?= e(implode(' + ', $layananList)) ?></td>
                                    <td><?= e(tglSingkat($r['jadwal'])) ?></td>
                                    <td><?= e(date('H:i', strtotime($r['jadwal']))) ?></td>
                                    <td>
                                        <span class="ad-pil <?= $r['bayar'] === 'Lunas' ? 'ok' : 'dp' ?>"><?= $r['bayar'] === 'Lunas' ? 'Lunas' : 'DP' ?></span>
                                    </td>
                                    <td>
                                        <button type="button" class="ad-mini btn-detail" data-invoice="inv-<?= e($r['kode']) ?>">Detail</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="ad-kosong" id="dataKosong">Reservasi tidak ditemukan.</div>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


    <!-- ===== MODAL INVOICE ===== -->
    <div class="ad-modal" id="modalInvoice" role="dialog" aria-modal="true" aria-label="Invoice reservasi">

        <div class="ad-modal-box">

            <button type="button" class="ad-x ad-noprint" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>

            <?php foreach ($reservasi as $r): ?>
                <div class="ad-inv" id="inv-<?= e($r['kode']) ?>" hidden>

                    <div class="inv-kop">
                        <div class="inv-merk">
                            <b>RESERVIN</b>
                            <small>Salon Booking</small>
                        </div>
                        <div class="inv-judul">
                            <span>INVOICE</span>
                            <b><?= e($r['kode']) ?></b>
                        </div>
                    </div>

                    <div class="inv-grid">
                        <div>
                            <small>Kode Booking</small>
                            <b><?= e($r['kode']) ?></b>
                        </div>
                        <div>
                            <small>Tanggal Booking</small>
                            <b><?= e(tglLengkap($r['dibuat'])) ?> · <?= e(date('H.i', strtotime($r['dibuat']))) ?></b>
                        </div>
                        <div>
                            <small>Pelanggan</small>
                            <b><?= e($r['pelanggan']) ?></b>
                        </div>
                        <div>
                            <small>No. Telepon</small>
                            <b><?= e($r['telepon']) ?></b>
                        </div>
                        <div>
                            <small>Salon</small>
                            <b><?= e($salon) ?></b>
                        </div>
                        <div>
                            <small>Status Booking</small>
                            <b>Dikonfirmasi</b>
                        </div>
                        <div>
                            <small>Status Pembayaran</small>
                            <span class="ad-pil <?= $r['bayar'] === 'Lunas' ? 'ok' : 'dp' ?>"><?= $r['bayar'] === 'Lunas' ? 'Lunas' : 'DP dibayar' ?></span>
                        </div>
                        <div>
                            <small>Metode Pembayaran</small>
                            <b><?= e($r['metode']) ?></b>
                        </div>
                    </div>

                    <h3 class="inv-sub">Rincian Layanan</h3>

                    <?php foreach ($r['item'] as $it): ?>
                        <div class="inv-item">
                            <div>
                                <h4><?= e($it[0]) ?></h4>
                                <p><?= e($it[1]) ?> · dilayani <?= e($it[2]) ?></p>
                                <p class="waktu"><?= e(tglLengkap($it[3])) ?> · <?= e(date('H.i', strtotime($it[3]))) ?></p>
                            </div>
                            <div class="harga"><?= e(rupiah($it[4])) ?></div>
                        </div>
                    <?php endforeach; ?>

                    <div class="inv-baris total">
                        <span>TOTAL (<?= count($r['item']) ?> ORANG)</span>
                        <span><?= e(rupiah($r['total'])) ?></span>
                    </div>

                    <?php if ($r['bayar'] !== 'Lunas'): ?>
                        <div class="inv-baris">
                            <span>DP dibayarkan</span>
                            <span><?= e(rupiah($r['dibayar'])) ?></span>
                        </div>
                        <div class="inv-baris sisa">
                            <span>Sisa pembayaran (dibayar di salon)</span>
                            <span><?= e(rupiah($r['sisa'])) ?></span>
                        </div>
                    <?php endif; ?>

                    <p class="inv-catatan">Invoice ini dibuat otomatis oleh sistem Reservin.</p>

                </div>
            <?php endforeach; ?>

            <div class="inv-aksi ad-noprint">
                <button type="button" class="ad-btn kedua" id="btnCetak"><?= ikon('cetak') ?> Cetak / Simpan PDF</button>
                <button type="button" class="ad-btn utama" id="btnTutup">Tutup</button>
            </div>

        </div>

    </div>


<script>

/* ===== filter, invoice, cetak ===== */

(function () {

    const baris = document.querySelectorAll("tr.baris");
    const cari = document.getElementById("cariNama");
    const tgl = document.getElementById("filterTanggal");
    const bayar = document.getElementById("filterBayar");

    function filter() {

        const kata = cari.value.toLowerCase().trim();
        let tampil = 0;

        baris.forEach(function (tr) {

            const cocok =
                (kata === "" || tr.dataset.cari.indexOf(kata) !== -1) &&
                (tgl.value === "" || tr.dataset.tanggal === tgl.value) &&
                (bayar.value === "" || tr.dataset.bayar === bayar.value);

            tr.style.display = cocok ? "" : "none";
            if (cocok) tampil++;

        });

        document.getElementById("dataKosong").style.display = tampil === 0 ? "block" : "none";
        document.getElementById("jumlah").textContent = tampil + " reservasi";

    }

    cari.addEventListener("input", filter);
    tgl.addEventListener("change", filter);
    bayar.addEventListener("change", filter);

    document.getElementById("btnReset").addEventListener("click", function () {
        cari.value = "";
        tgl.value = "";
        bayar.value = "";
        filter();
    });


    /* invoice */

    const modal = document.getElementById("modalInvoice");

    function bukaInvoice(id) {
        document.querySelectorAll(".ad-inv").forEach(function (d) {
            d.hidden = d.id !== id;
        });
        modal.classList.add("show");
        modal.scrollTop = 0;
    }

    function tutupInvoice() {
        modal.classList.remove("show");
    }

    document.querySelectorAll(".btn-detail").forEach(function (b) {
        b.addEventListener("click", function () {
            bukaInvoice(b.dataset.invoice);
        });
    });

    document.getElementById("btnCetak").addEventListener("click", function () {
        window.print();
    });

    document.getElementById("btnTutup").addEventListener("click", tutupInvoice);
    document.getElementById("btnX").addEventListener("click", tutupInvoice);

    modal.addEventListener("click", function (e) {
        if (e.target === modal) tutupInvoice();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("show")) tutupInvoice();
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