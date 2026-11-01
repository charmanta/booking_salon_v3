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
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
        'laporan'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 17v-3M12 17v-5M15 17v-2"/>',
        'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'turun'    => '<path d="M6 9l6 6 6-6"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
        'edit'     => '<path d="M4 20h4L19 9a2.800 2.800 0 0 0-4-4L4 16z"/><path d="M13.500 6.500l4 4"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',     false],
    ['salon.php',     'Data Salon', 'store',    false],
    ['layanan.php',   'Layanan',    'gunting',  false],
    ['pegawai.php',   'Pegawai',    'users',    false],
    ['jadwal.php',    'Jadwal',     'kalender', true],
    ['laporan.php',   'Laporan',    'laporan',  false],
    ['profil.php',    'Profil',     'user',     false],
];

/* nomor hari: 1 = Senin ... 7 = Minggu */
$namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
$bulan    = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$hariIni  = (int)date('N');

/*
 * [nama, keahlian, hari kerja, jam masuk, jam pulang, status kehadiran hari ini, waktu dicatat]
 *
 * Nanti dari database (tabel pegawai + kehadiran hari ini), contoh:
 *   SELECT p.id, p.nama, p.keahlian, p.hari_kerja, p.jam_masuk, p.jam_pulang, k.status, k.waktu_dicatat
 *   FROM pegawai p
 *   LEFT JOIN kehadiran k ON k.id_pegawai = p.id AND k.tanggal = CURDATE()
 *   WHERE p.akun_aktif = 1
 * Pegawai yang sudah resign (akun_aktif = 0) tidak ditampilkan di jadwal.
 */
$pegawai = [
    ['Dewi Lestari',   'Hair Stylist',    [1, 2, 3, 4, 5, 6], '09:00', '17:00', 'masuk',       '08:42'],
    ['Andi Pratama',   'Barber',          [1, 2, 3, 4, 5, 6], '10:00', '18:00', 'masuk',       '09:51'],
    ['Maya Putri',     'Facial & Beauty', [2, 3, 4, 5, 6, 7], '09:00', '17:00', 'masuk',       '08:55'],
    ['Rani Salsabila', 'Hair Coloring',   [1, 3, 5, 6],       '11:00', '20:00', 'tidak_masuk', '07:30'],
];

/* tanggal tiap hari pada pekan ini */
$senin = strtotime('monday this week');
$tgl   = [];
foreach ($namaHari as $no => $h) {
    $t = strtotime('+' . ($no - 1) . ' day', $senin);
    $tgl[$no] = date('j', $t) . ' ' . $bulan[(int)date('n', $t)];
}
$minggu    = strtotime('+6 day', $senin);
$rentang   = date('j', $senin) . ' ' . $bulan[(int)date('n', $senin)] . ' – ' . date('j', $minggu) . ' ' . $bulan[(int)date('n', $minggu)] . ' ' . date('Y', $minggu);

/* jumlah pegawai bertugas per hari */
$jumlah = array_fill(1, 7, 0);
foreach ($pegawai as $p) {
    foreach ($p[2] as $h) { $jumlah[$h]++; }
}

/* total jam kerja per pekan */
function totalJam($p) {
    $menit = (strtotime($p[4]) - strtotime($p[3])) / 60;
    $jam   = count($p[2]) * $menit / 60;
    return rtrim(rtrim(number_format($jam, 1, ',', ''), '0'), ',');
}

/* data jadwal untuk pop-up (dibaca JavaScript) */
$dataJs = [];
foreach ($pegawai as $p) {
    $dataJs[] = [
        'nama'     => $p[0],
        'keahlian' => $p[1],
        'hari'     => array_map('strval', $p[2]),
        'masuk'    => $p[3],
        'pulang'   => $p[4],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pegawai</title>
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

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 30px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 6px; flex-wrap: wrap; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-jumlah { font-size: 14px; color: var(--muted); }
        .ad-tip { margin: 0 0 18px; font-size: 14.5px; color: var(--muted); }

        /* tombol */
        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 22px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s; text-decoration: none;
        }
        .ad-btn svg { width: 18px; height: 18px; }
        .ad-btn.utama { background: var(--rose); color: #fff; }
        .ad-btn.utama:hover { background: var(--rose-dark); }
        .ad-btn.kedua { background: #fff; color: #4d4650; border-color: #e3d8d2; }
        .ad-btn.kedua:hover { background: #f6ece7; }

        .ad-mini {
            display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-size: 13.5px; font-weight: 500;
            padding: 7px 12px; border-radius: 8px; cursor: pointer; background: #fff; border: 1px solid #e3d8d2; color: #4d4650; text-decoration: none;
        }
        .ad-mini svg { width: 16px; height: 16px; }
        .ad-mini:hover { background: #f6ece7; }

        /* tabel jadwal */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: separate; border-spacing: 0; font-size: 15px; min-width: 980px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 12px 12px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 14px 12px; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .ad-tabel tbody tr:last-child td { border-bottom: 0; }

        .ad-tabel th.hr { text-align: center; }
        .ad-tabel th.hr small { display: block; margin-top: 2px; font-size: 12.5px; font-weight: 400; color: var(--muted); }
        .ad-tabel th.ini { background: #ecd9d3; }
        .ad-tabel td.ini { background: #fcf5f2; }
        .ad-tabel td.sel { text-align: center; }

        .ad-orang b { display: block; font-weight: 600; white-space: nowrap; }
        .ad-orang small { display: block; margin-top: 2px; font-size: 13.5px; color: var(--muted); white-space: nowrap; }
        .ad-total { white-space: nowrap; }
        .ad-total small { display: block; margin-top: 2px; font-size: 13px; color: var(--muted); }

        .ad-slot { display: inline-block; padding: 6px 10px; border-radius: 8px; background: #f3e4e0; color: #7a4a45; font-size: 13.5px; font-weight: 500; white-space: nowrap; }
        .ad-libur { display: inline-block; padding: 6px 10px; font-size: 13.5px; color: #a89c97; }
        .ad-st { display: block; margin-top: 5px; font-size: 12.5px; white-space: nowrap; }
        .ad-st.ok { color: #1c6f47; }
        .ad-st.off { color: #7a6c68; }

        .ad-tabel tfoot td { padding: 14px 12px; background: #fbf8f6; border-top: 1px solid var(--line); font-size: 14px; text-align: center; }
        .ad-tabel tfoot td:first-child { text-align: left; font-weight: 600; border-radius: 8px 0 0 8px; }
        .ad-tabel tfoot td:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel tfoot td.ini { background: #fcf5f2; }
        .ad-jml { display: inline-block; min-width: 28px; padding: 4px 8px; border-radius: 8px; background: #dff3e8; color: #1c6f47; font-weight: 600; }
        .ad-jml.kosong { background: #fdf0d3; color: #8a5a00; }

        .ad-legenda { display: flex; flex-wrap: wrap; gap: 8px 20px; margin: 18px 0 0; font-size: 13.5px; color: var(--muted); }
        .ad-legenda span { display: inline-flex; align-items: center; gap: 8px; }
        .ad-legenda i { width: 14px; height: 14px; border-radius: 4px; background: #f3e4e0; display: inline-block; }
        .ad-legenda i.t { background: #fcf5f2; border: 1px solid #ecd9d3; }
        .ad-legenda i.k { background: #fdf0d3; }

        /* modal jadwal */
        .ad-modal { display: none; position: fixed; inset: 0; z-index: 400; background: rgba(30, 18, 16, .5); align-items: center; justify-content: center; padding: 18px; }
        .ad-modal.show { display: flex; }
        .ad-modal-box { background: #fff; border-radius: 16px; width: 100%; max-width: 520px; max-height: calc(100vh - 36px); overflow-y: auto; padding: 26px 28px; box-shadow: 0 20px 50px rgba(40, 20, 16, .25); }
        .ad-modal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .ad-modal-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-x { width: 36px; height: 36px; border: 0; background: transparent; border-radius: 8px; display: grid; place-items: center; cursor: pointer; color: #4a4348; padding: 0; }
        .ad-x:hover { background: rgba(0, 0, 0, .06); }

        .ad-field { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
        .ad-field label, .ad-field .lbl { font-size: 14px; font-weight: 500; color: #4d4650; }
        .ad-field input[type="time"], .ad-field select {
            width: 100%; font-family: inherit; font-size: 15.5px; color: var(--ink);
            background: #fff; border: 1px solid #e3d8d2; border-radius: 10px; padding: 12px 14px;
            transition: border-color .15s, box-shadow .15s;
        }
        .ad-field select:disabled { background: #f7f2ef; color: var(--ink); opacity: 1; cursor: not-allowed; }
        .ad-field input:focus, .ad-field select:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }
        .ad-field small.bantu { font-size: 12.5px; color: var(--muted); }
        .ad-field-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }

        /* pilihan hari */
        .ad-hari { display: flex; flex-wrap: wrap; gap: 8px; }
        .ad-hari label { position: relative; cursor: pointer; }
        .ad-hari input { position: absolute; opacity: 0; pointer-events: none; }
        .ad-hari span {
            display: block; min-width: 48px; text-align: center; padding: 9px 12px; border-radius: 10px;
            border: 1px solid #e3d8d2; font-size: 14px; background: #fff; color: #4d4650; transition: background .15s;
        }
        .ad-hari label:hover span { background: #fbf4f1; }
        .ad-hari input:checked + span { background: var(--rose); border-color: var(--rose); color: #fff; font-weight: 500; }
        .ad-hari input:focus-visible + span { outline: 2px solid #c4938d; outline-offset: 2px; }

        .ad-modal-aksi { display: flex; justify-content: flex-end; gap: 12px; margin-top: 22px; }

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
            .ad-modal-box { padding: 22px 18px; }
            .ad-field-2 { grid-template-columns: 1fr; gap: 0; }
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
                    <h1>Jadwal Pegawai</h1>
                    <p>Lihat dan atur jadwal kerja mingguan seluruh pegawai.</p>
                </section>

                <button type="button" class="ad-btn utama" id="btnAtur">
                    <?= ikon('kalender') ?> Atur Jadwal
                </button>

            </div>


            <!-- JADWAL MINGGUAN -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Jadwal Mingguan</h2>
                    <span class="ad-jumlah">Pekan ini: <?= e($rentang) ?></span>
                </div>

                <p class="ad-tip">Jadwal ini berulang setiap pekan. Klik Ubah untuk mengatur hari dan jam kerja pegawai. Pada kolom hari ini tampil juga status presensi yang dikirim pegawai.</p>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>Pegawai</th>
                                <?php foreach ($namaHari as $no => $h): ?>
                                    <th class="hr<?= $no === $hariIni ? ' ini' : '' ?>">
                                        <?= e($h) ?>
                                        <small><?= e($tgl[$no]) ?></small>
                                    </th>
                                <?php endforeach; ?>
                                <th>Total / Pekan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($pegawai as $i => $p): ?>
                                <tr>
                                    <td class="ad-orang">
                                        <b><?= e($p[0]) ?></b>
                                        <small><?= e($p[1]) ?></small>
                                    </td>

                                    <?php foreach ($namaHari as $no => $h): ?>
                                        <?php $kerja = in_array($no, $p[2], true); ?>
                                        <td class="sel<?= $no === $hariIni ? ' ini' : '' ?>">
                                            <?php if ($kerja): ?>
                                                <span class="ad-slot"><?= e($p[3]) ?> – <?= e($p[4]) ?></span>
                                                <?php if ($no === $hariIni): ?>
                                                    <?php if ($p[5] === 'masuk'): ?>
                                                        <span class="ad-st ok">Masuk · <?= e($p[6]) ?></span>
                                                    <?php else: ?>
                                                        <span class="ad-st off">Tidak masuk</span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="ad-libur">Libur</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endforeach; ?>

                                    <td class="ad-total">
                                        <?= e(totalJam($p)) ?> jam
                                        <small><?= count($p[2]) ?> hari kerja</small>
                                    </td>

                                    <td>
                                        <button type="button" class="ad-mini btn-ubah" data-i="<?= $i ?>"><?= ikon('edit') ?> Ubah</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Pegawai bertugas</td>
                                <?php foreach ($namaHari as $no => $h): ?>
                                    <td class="<?= $no === $hariIni ? 'ini' : '' ?>">
                                        <?php if ($jumlah[$no] === 0): ?>
                                            <span class="ad-jml kosong">Kosong</span>
                                        <?php else: ?>
                                            <span class="ad-jml"><?= $jumlah[$no] ?></span>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="ad-legenda">
                    <span><i></i> Jam kerja</span>
                    <span><i class="t"></i> Kolom hari ini</span>
                    <span><i class="k"></i> Kosong: tidak ada pegawai yang bertugas</span>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


    <!-- ===== POP-UP ATUR / UBAH JADWAL ===== -->
    <div class="ad-modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="ad-modal-box">

            <div class="ad-modal-head">
                <h2 id="modalTitle">Atur Jadwal</h2>
                <button type="button" class="ad-x" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>
            </div>

            <div class="ad-field">
                <label for="j_pegawai">Pegawai</label>
                <select id="j_pegawai">
                    <option value="">Pilih pegawai</option>
                    <?php foreach ($pegawai as $i => $p): ?>
                        <option value="<?= $i ?>"><?= e($p[0]) ?> · <?= e($p[1]) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="ad-field">
                <span class="lbl" id="lblHari">Hari kerja</span>
                <div class="ad-hari" role="group" aria-labelledby="lblHari">
                    <?php foreach ($namaHari as $no => $h): ?>
                        <label>
                            <input type="checkbox" name="hari" value="<?= $no ?>">
                            <span><?= e($h) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="ad-field-2">
                <div class="ad-field">
                    <label for="jamMasuk">Jam masuk</label>
                    <input type="time" id="jamMasuk" value="09:00">
                </div>

                <div class="ad-field">
                    <label for="jamPulang">Jam pulang</label>
                    <input type="time" id="jamPulang" value="17:00">
                </div>
            </div>

            <small class="bantu" style="color:var(--muted);font-size:12.5px">Jadwal berlaku setiap pekan sampai diubah lagi.</small>

            <div class="ad-modal-aksi">
                <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
                <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
            </div>

        </div>

    </div>


<script>

const $ = function (id) { return document.getElementById(id); };

/* data jadwal tiap pegawai (dari PHP) */
const DATA = <?= json_encode($dataJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;


/* ===== ATUR / UBAH JADWAL =====
   Catatan untuk database nanti: simpan hari kerja, jam masuk, jam pulang
   ke tabel pegawai (atau tabel jadwal), lalu halaman ini membacanya lagi. */

(function () {

    const modal = $("modal");

    function setHari(daftar) {
        document.querySelectorAll('input[name="hari"]').forEach(function (c) {
            c.checked = daftar.indexOf(c.value) !== -1;
        });
    }

    /* isi form dengan jadwal pegawai terpilih (atau nilai awal jika belum memilih) */
    function isiForm(idx) {
        if (idx === "" || !DATA[idx]) {
            setHari(["1", "2", "3", "4", "5", "6"]);
            $("jamMasuk").value = "09:00";
            $("jamPulang").value = "17:00";
            return;
        }
        setHari(DATA[idx].hari);
        $("jamMasuk").value = DATA[idx].masuk;
        $("jamPulang").value = DATA[idx].pulang;
    }

    /* idx kosong = tombol "Atur Jadwal" (pilih pegawai dulu); idx terisi = tombol "Ubah" (pegawai terkunci) */
    function buka(idx) {
        const dariUbah = idx !== null;

        $("modalTitle").textContent = dariUbah ? "Ubah Jadwal" : "Atur Jadwal";
        $("j_pegawai").value = dariUbah ? String(idx) : "";
        $("j_pegawai").disabled = dariUbah;

        isiForm(dariUbah ? String(idx) : "");

        modal.classList.add("show");
        if (dariUbah) { $("jamMasuk").focus(); } else { $("j_pegawai").focus(); }
    }

    function tutup() {
        modal.classList.remove("show");
    }

    $("btnAtur").addEventListener("click", function () { buka(null); });

    document.querySelectorAll(".btn-ubah").forEach(function (b) {
        b.addEventListener("click", function () { buka(b.dataset.i); });
    });

    /* pilih pegawai di mode "Atur Jadwal" -> tampilkan jadwalnya saat ini */
    $("j_pegawai").addEventListener("change", function () {
        isiForm(this.value);
    });

    $("btnSimpan").addEventListener("click", function () {

        const idx = $("j_pegawai").value;

        if (idx === "") { alert("Pilih pegawai terlebih dahulu."); $("j_pegawai").focus(); return; }

        if (document.querySelectorAll('input[name="hari"]:checked').length === 0) {
            alert("Pilih minimal satu hari kerja.");
            return;
        }

        if ($("jamMasuk").value === "" || $("jamPulang").value === "") {
            alert("Jam masuk dan jam pulang belum diisi.");
            return;
        }

        if ($("jamPulang").value <= $("jamMasuk").value) {
            alert("Jam pulang harus setelah jam masuk.");
            return;
        }

        /* demo: nanti kirim ke server (POST), lalu muat ulang halaman */
        alert("Jadwal " + DATA[idx].nama + " berhasil disimpan.");
        tutup();

    });

    $("btnBatal").addEventListener("click", tutup);
    $("btnX").addEventListener("click", tutup);

    modal.addEventListener("click", function (e) {
        if (e.target === modal) tutup();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("show")) tutup();
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