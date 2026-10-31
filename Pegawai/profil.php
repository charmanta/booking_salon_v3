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
        'kamera'   => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.500" r="3.500"/>',
        'cek'      => '<circle cx="12" cy="12" r="9"/><path d="M8 12.500l3 3 5-6"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'kirim'    => '<path d="M4 12l16-8-6 17-3-7z"/><path d="M11 14l9-10"/>',
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

$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA', 'salon' => 'Luna Salon'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    false],
    ['detail_booking.php',   'Detail Reservasi', 'daftar',  false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['profil.php',           'Profil',           'user',    true],
];

$akun = [
    'nama'    => 'Siti Amelia',
    'telepon' => '081234567890',
    'email'   => 'siti@gmail.com',
    'alamat'  => 'Jl. Mawar No. 10',
    'jabatan' => 'Pegawai',
];

/* jadwal masuk hari ini (diatur admin di halaman Pegawai) */
$jadwalHariIni = '09:00 – 17:00';

/* presensi hari ini: null = belum, atau ['jam' => 'H:i'] bila sudah terkirim */
$presensiHariIni = null;

/* riwayat presensi sebelumnya: [timestamp, jam kirim atau null] */
$riwayat = [];
foreach ([1 => '08:51', 2 => '08:47', 3 => null, 4 => '09:02'] as $mundur => $jam) {
    $riwayat[] = [strtotime("-$mundur day"), $jam];
}
$hariIni = strtotime('today');
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
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 24px; }
        .ad-sapa + .ad-kartu { margin-top: 34px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-sub { margin: 6px 0 22px; font-size: 14.5px; color: var(--muted); }

        .ad-pil { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.off { background: #f1ebe8; color: #7a6c68; }

        /* kepala profil */
        .ad-kepala { display: flex; align-items: center; gap: 18px; padding: 18px; background: #fbf4f1; border: 1px solid var(--line); border-radius: 14px; }
        .ad-kepala .ad-ava { width: 72px; height: 72px; font-size: 26px; background: var(--rose-soft); color: #fff; }
        .ad-kepala b { display: block; font-size: 22px; font-weight: 600; }
        .ad-kepala small { display: block; margin-top: 4px; font-size: 15px; color: var(--muted); }

        /* ===== PRESENSI ===== */
        .ad-presensi { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 24px; }
        .ad-ringkas { display: grid; gap: 12px; align-content: start; }
        .ad-ringkas .baris { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 14px 18px; border: 1px solid var(--line); border-radius: 12px; }
        .ad-ringkas small { font-size: 13.5px; color: var(--muted); }
        .ad-ringkas b { font-weight: 600; font-size: 16px; }

        .ad-drop {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; text-align: center;
            min-height: 220px; padding: 20px; border: 2px dashed #d9cdc8; border-radius: 14px; background: #fbf8f6; cursor: pointer;
            transition: background .15s, border-color .15s;
        }
        .ad-drop:hover, .ad-drop.seret { background: #fbf1ee; border-color: var(--rose-soft); }
        .ad-drop svg { width: 38px; height: 38px; color: var(--rose-soft); }
        .ad-drop b { font-size: 16px; font-weight: 600; }
        .ad-drop span { font-size: 13.5px; color: var(--muted); }
        .ad-drop input { position: absolute; width: 1px; height: 1px; opacity: 0; pointer-events: none; }
        .ad-drop:focus-within { outline: 2px solid #c4938d; outline-offset: 2px; }

        .ad-preview { display: none; }
        .ad-preview img { display: block; width: 100%; max-height: 300px; object-fit: cover; border-radius: 14px; border: 1px solid var(--line); }
        .ad-preview .ket { margin: 8px 0 0; font-size: 13.5px; color: var(--muted); word-break: break-all; }

        .ad-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 18px; }
        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 24px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s;
        }
        .ad-btn svg { width: 18px; height: 18px; }
        .ad-btn.utama { background: var(--rose); color: #fff; }
        .ad-btn.utama:hover { background: var(--rose-dark); }
        .ad-btn.kedua { background: #fff; color: #4d4650; border-color: #e3d8d2; }
        .ad-btn.kedua:hover { background: #f6ece7; }
        .ad-btn[disabled] { opacity: .5; cursor: not-allowed; }

        .ad-pesan { margin: 14px 0 0; padding: 12px 14px; border-radius: 10px; font-size: 14.5px; display: none; }
        .ad-pesan.salah { display: block; background: #fdeceb; color: #b4423a; }
        .ad-pesan.benar { display: block; background: #dff3e8; color: #1c6f47; }
        .ad-aturan { margin: 16px 0 0; font-size: 13.5px; color: var(--muted); line-height: 1.55; }

        /* riwayat */
        .ad-tabel-box { overflow-x: auto; margin-top: 26px; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 420px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 14px 14px; border-bottom: 1px solid var(--line); white-space: nowrap; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-sub-judul { margin: 26px 0 0; font-size: 16px; font-weight: 600; }

        /* form */
        .ad-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px 24px; }
        .ad-field { display: flex; flex-direction: column; gap: 8px; min-width: 0; }
        .ad-field.full { grid-column: 1 / -1; }
        .ad-field label, .ad-field .lbl { font-size: 14px; font-weight: 500; color: #4d4650; }
        .ad-field input, .ad-field textarea {
            width: 100%; font-family: inherit; font-size: 15.5px; color: var(--ink);
            background: #fff; border: 1px solid #e3d8d2; border-radius: 10px; padding: 12px 14px;
            transition: border-color .15s, box-shadow .15s;
        }
        .ad-field textarea { min-height: 96px; resize: vertical; line-height: 1.5; }
        .ad-field input:focus, .ad-field textarea:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }
        .ad-field input[readonly] { background: #f7f2ef; color: #5d504c; }
        .ad-sandi { display: flex; gap: 10px; }
        .ad-sandi input { flex: 1; min-width: 0; }
        .ad-bantu { margin: 0; font-size: 13.5px; color: var(--muted); }

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

        @media (max-width: 860px) {
            .ad-presensi { grid-template-columns: 1fr; }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
            .ad-form-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-aksi .ad-btn { flex: 1; }
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
                <h1>Profil</h1>
                <p>Kelola data diri dan catat kehadiran kerja Anda.</p>
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


            <!-- PRESENSI KERJA -->

            <section class="ad-kartu" id="presensi">

                <div class="ad-kartu-head">
                    <h2>Presensi Kerja</h2>
                    <span class="ad-pil <?= $presensiHariIni ? 'ok' : 'off' ?>" id="pilPresensi"><?= $presensiHariIni ? 'Aktif' : 'Belum presensi' ?></span>
                </div>
                <p class="ad-sub">Kirim foto Anda di salon untuk menandai bahwa Anda masuk kerja. Setelah terkirim, status Anda menjadi Aktif.</p>

                <div class="ad-presensi">

                    <!-- kiri: ringkasan -->
                    <div class="ad-ringkas">
                        <div class="baris">
                            <small>Hari ini</small>
                            <b><?= e(tglHari($hariIni)) ?></b>
                        </div>
                        <div class="baris">
                            <small>Jadwal masuk</small>
                            <b><?= e($jadwalHariIni) ?></b>
                        </div>
                        <div class="baris">
                            <small>Status kehadiran</small>
                            <b id="teksStatus"><?= $presensiHariIni ? 'Aktif · terkirim ' . e($presensiHariIni['jam']) : 'Belum presensi' ?></b>
                        </div>
                        <p class="ad-aturan">
                            Foto harus diambil di dalam salon (selfie atau suasana tempat kerja) dan terlihat jelas.
                            Format JPG, PNG, atau WEBP, maksimal 5 MB. Presensi hanya bisa dikirim satu kali per hari.
                        </p>
                    </div>

                    <!-- kanan: unggah foto -->
                    <div>

                        <label class="ad-drop" id="drop" for="fotoPresensi">
                            <?= ikon('kamera') ?>
                            <b>Ambil atau pilih foto</b>
                            <span>Klik di sini, atau seret foto ke kotak ini</span>
                            <input type="file" id="fotoPresensi" accept="image/jpeg,image/png,image/webp" capture="user">
                        </label>

                        <div class="ad-preview" id="preview">
                            <img id="gambarPreview" alt="Foto presensi">
                            <p class="ket" id="namaFile"></p>
                        </div>

                        <div class="ad-pesan" id="pesan" role="status"></div>

                        <div class="ad-aksi">
                            <button type="button" class="ad-btn utama" id="btnKirim"><?= ikon('kirim') ?> Kirim Presensi</button>
                            <button type="button" class="ad-btn kedua" id="btnGanti" style="display:none">Ganti Foto</button>
                        </div>

                    </div>

                </div>


                <!-- RIWAYAT -->

                <h3 class="ad-sub-judul">Riwayat Presensi</h3>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dikirim Pukul</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="riwayat">
                            <tr id="barisHariIni">
                                <td><?= e(tglHari($hariIni)) ?> <small>(hari ini)</small></td>
                                <td id="jamHariIni"><?= $presensiHariIni ? e($presensiHariIni['jam']) : '–' ?></td>
                                <td><span class="ad-pil <?= $presensiHariIni ? 'ok' : 'off' ?>" id="pilRiwayat"><?= $presensiHariIni ? 'Aktif' : 'Belum presensi' ?></span></td>
                            </tr>
                            <?php foreach ($riwayat as $r): ?>
                                <tr>
                                    <td><?= e(tglHari($r[0])) ?></td>
                                    <td><?= $r[1] ? e($r[1]) : '–' ?></td>
                                    <td><span class="ad-pil <?= $r[1] ? 'ok' : 'off' ?>"><?= $r[1] ? 'Aktif' : 'Tidak masuk' ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
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
                            <div><span class="ad-pil <?= $presensiHariIni ? 'ok' : 'off' ?>" id="pilStatusKerja"><?= $presensiHariIni ? 'Aktif' : 'Nonaktif' ?></span></div>
                            <p class="ad-bantu">Berubah menjadi Aktif setelah Anda mengirim presensi.</p>
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

/* ===== presensi kerja ===== */

(function () {

    const MAKS = 5 * 1024 * 1024;
    const JENIS = ["image/jpeg", "image/png", "image/webp"];

    const input = document.getElementById("fotoPresensi");
    const drop = document.getElementById("drop");
    const preview = document.getElementById("preview");
    const gambar = document.getElementById("gambarPreview");
    const namaFile = document.getElementById("namaFile");
    const pesan = document.getElementById("pesan");
    const btnKirim = document.getElementById("btnKirim");
    const btnGanti = document.getElementById("btnGanti");

    let berkas = null;
    let urlSementara = null;

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
        namaFile.textContent = file.name;

        drop.style.display = "none";
        preview.style.display = "block";
        btnGanti.style.display = "inline-flex";

    }

    input.addEventListener("change", function () {
        pilih(input.files[0]);
    });

    /* seret & lepas */
    ["dragenter", "dragover"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); drop.classList.add("seret"); });
    });
    ["dragleave", "drop"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); drop.classList.remove("seret"); });
    });
    drop.addEventListener("drop", function (e) {
        if (e.dataTransfer.files.length) pilih(e.dataTransfer.files[0]);
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

        /* demo: nanti kirim berkas ke server (FormData + fetch) dan simpan ke ../uploads/presensi/ */
        const sekarang = new Date();
        const jam = dua(sekarang.getHours()) + ":" + dua(sekarang.getMinutes());

        document.getElementById("pilPresensi").textContent = "Aktif";
        document.getElementById("pilPresensi").className = "ad-pil ok";
        document.getElementById("teksStatus").textContent = "Aktif · terkirim " + jam;
        document.getElementById("jamHariIni").textContent = jam;
        document.getElementById("pilRiwayat").textContent = "Aktif";
        document.getElementById("pilRiwayat").className = "ad-pil ok";
        document.getElementById("pilStatusKerja").textContent = "Aktif";
        document.getElementById("pilStatusKerja").className = "ad-pil ok";

        btnKirim.disabled = true;
        btnGanti.style.display = "none";
        tampilPesan("Presensi terkirim pukul " + jam + ". Status Anda sekarang Aktif.", "benar");

    });

})();


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