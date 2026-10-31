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
        'kembali'  => '<path d="M19 12H5M11 6l-6 6 6 6"/>',
        'cek'      => '<path d="M5 12.500l4.500 4.500L19 7.500"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'gambar'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.800"/><path d="M21 16l-5-5-8 8"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function rupiah($n) { return 'Rp ' . number_format((int)$n, 0, ',', '.'); }

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',      'Dashboard',      'home',    false],
    ['detail_reservasi.php',   'Detail Reservasi', 'daftar',  true],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', false],
    ['profil.php',         'Profil',         'user',    false],
];

$b = [
    'kode'      => 'RSV-001',
    'status'    => 'Menunggu Verifikasi',
    'pelanggan' => 'Rina',
    'telepon'   => '081234567890',
    'salon'     => 'Luna Salon',
    'layanan'   => 'Creambath',
    'tanggal'   => '17 Oktober 2026',
    'jam'       => '10:00',
    'pegawai'   => 'Siti Amelia',
    'metode'    => 'Transfer',
    'total'     => 100000,
    'dp'        => 50000,
    'bukti'     => '../uploads/bukti_transfer.jpg',
];
$b['sisa'] = $b['total'] - $b['dp'];

/* detail: [label, nilai] */
$detail = [
    ['Nama Pelanggan', $b['pelanggan']],
    ['No. Telepon',    $b['telepon']],
    ['Nama Salon',     $b['salon']],
    ['Layanan',        $b['layanan']],
    ['Tanggal Booking', $b['tanggal']],
    ['Jam Booking',    $b['jam']],
    ['Pegawai',        $b['pegawai']],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking</title>
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

        .ad-kembali { display: inline-flex; align-items: center; gap: 8px; font-size: 15px; color: #5d5560; text-decoration: none; margin-bottom: 18px; }
        .ad-kembali:hover { color: var(--rose-dark); }
        .ad-kembali svg { width: 18px; height: 18px; }

        .ad-sapa h1 { margin: 0; font-size: clamp(28px, 3.2vw, 40px); font-weight: 700; letter-spacing: -.01em; }
        .ad-sapa p { margin: 10px 0 0; font-size: 19px; color: var(--muted); }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 24px; }
        .ad-sapa + .ad-kartu { margin-top: 34px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-kode { font-size: 26px; font-weight: 700; letter-spacing: .02em; }
        .ad-garis { border: 0; border-top: 1px solid var(--line); margin: 0 0 22px; }

        .ad-pil { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 500; white-space: nowrap; }
        .ad-pil.tunggu { background: #fdf0d3; color: #8a5a00; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.tolak { background: #fdeceb; color: #b4423a; }

        /* grid info */
        .ad-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 20px; }
        .ad-item { padding: 14px 18px; border: 1px solid var(--line); border-radius: 12px; background: #fff; min-width: 0; }
        .ad-item small { display: block; font-size: 13px; color: var(--muted); }
        .ad-item b { display: block; margin-top: 5px; font-size: 16.5px; font-weight: 600; overflow-wrap: anywhere; }
        .ad-item .ad-pil { margin-top: 5px; }

        .ad-grid-4 { grid-template-columns: repeat(4, minmax(0, 1fr)); }

        /* bukti transfer */
        .ad-sub { margin: 28px 0 12px; font-size: 16px; font-weight: 600; }
        .ad-bukti { display: block; width: 100%; max-width: 280px; border: 1px solid var(--line); border-radius: 12px; background: #fbf8f6; cursor: zoom-in; }
        .ad-kosong {
            display: none; align-items: center; gap: 12px; width: 100%; max-width: 280px; padding: 22px 18px;
            border: 1px dashed #d9cdc8; border-radius: 12px; background: #fbf8f6; color: var(--muted); font-size: 14.5px;
        }
        .ad-kosong svg { width: 28px; height: 28px; color: var(--rose-soft); }
        .ad-catatan { margin: 10px 0 0; font-size: 13.5px; color: var(--muted); }

        /* rincian total */
        .ad-total { margin-top: 28px; }
        .ad-baris { display: flex; justify-content: space-between; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--line); font-size: 15.5px; }
        .ad-baris.akhir { border-bottom: 0; border-top: 1px solid #d9cdc8; margin-top: 6px; padding-top: 16px; font-size: 19px; font-weight: 700; }

        /* tombol */
        .ad-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 24px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s;
        }
        .ad-btn svg { width: 18px; height: 18px; }
        .ad-btn.terima { background: #2e9468; color: #fff; }
        .ad-btn.terima:hover { background: #247a55; }
        .ad-btn.tolak { background: #fff; color: #b4423a; border-color: #efc9c5; }
        .ad-btn.tolak:hover { background: #fdeceb; }
        .ad-btn[disabled] { opacity: .5; cursor: not-allowed; }

        /* modal bukti */
        .ad-modal { display: none; position: fixed; inset: 0; z-index: 400; background: rgba(30, 18, 16, .65); align-items: center; justify-content: center; padding: 18px; }
        .ad-modal.show { display: flex; }
        .ad-modal img { max-width: min(92vw, 760px); max-height: 86vh; border-radius: 12px; background: #fff; }
        .ad-x { position: absolute; top: 16px; right: 20px; width: 44px; height: 44px; border: 0; border-radius: 50%; background: rgba(255, 255, 255, .92); color: #4a4348; display: grid; place-items: center; cursor: pointer; padding: 0; }
        .ad-x:hover { background: #fff; }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible,
        .ad-btn:focus-visible, .ad-x:focus-visible, .ad-kembali:focus-visible { outline: 2px solid #c4938d; outline-offset: 2px; }

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
            .ad-grid-4 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
            .ad-grid, .ad-grid-4 { grid-template-columns: 1fr; }
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

            <a href="dashboard.php" class="ad-kembali"><?= ikon('kembali') ?> Kembali ke Dashboard</a>

            <section class="ad-sapa">
                <h1>Detail Booking</h1>
                <p>Periksa informasi pelanggan dan pembayaran.</p>
            </section>


            <!-- DATA BOOKING -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <div class="ad-kode"><?= e($b['kode']) ?></div>
                    <span class="ad-pil tunggu" id="pilBooking"><?= e($b['status']) ?></span>
                </div>

                <hr class="ad-garis">

                <div class="ad-grid">
                    <?php foreach ($detail as $d): ?>
                        <div class="ad-item">
                            <small><?= e($d[0]) ?></small>
                            <b><?= e($d[1]) ?></b>
                        </div>
                    <?php endforeach; ?>

                    <div class="ad-item">
                        <small>Status Pembayaran</small>
                        <span class="ad-pil tunggu" id="pilBayar1"><?= e($b['status']) ?></span>
                    </div>
                </div>

            </section>


            <!-- PEMBAYARAN -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Pembayaran</h2>
                </div>

                <div class="ad-grid ad-grid-4">

                    <div class="ad-item">
                        <small>Total Harga</small>
                        <b><?= e(rupiah($b['total'])) ?></b>
                    </div>

                    <div class="ad-item">
                        <small>DP Dibayarkan</small>
                        <b><?= e(rupiah($b['dp'])) ?></b>
                    </div>

                    <div class="ad-item">
                        <small>Metode Pembayaran</small>
                        <b><?= e($b['metode']) ?></b>
                    </div>

                    <div class="ad-item">
                        <small>Status</small>
                        <span class="ad-pil tunggu" id="pilBayar2"><?= e($b['status']) ?></span>
                    </div>

                </div>


                <!-- BUKTI TRANSFER -->

                <h3 class="ad-sub">Bukti Transfer</h3>

                <img
                    src="<?= e($b['bukti']) ?>"
                    class="ad-bukti"
                    id="gambarBukti"
                    alt="Bukti Transfer"
                    title="Klik untuk memperbesar">

                <div class="ad-kosong" id="buktiKosong">
                    <?= ikon('gambar') ?>
                    Bukti transfer tidak ditemukan.
                </div>

                <p class="ad-catatan" id="catatanBukti">Klik gambar untuk melihat bukti transfer lebih besar.</p>


                <!-- RINCIAN TOTAL -->

                <div class="ad-total">

                    <div class="ad-baris">
                        <span>Total Harga</span>
                        <span><?= e(rupiah($b['total'])) ?></span>
                    </div>

                    <div class="ad-baris">
                        <span>DP</span>
                        <span><?= e(rupiah($b['dp'])) ?></span>
                    </div>

                    <div class="ad-baris akhir">
                        <span>Sisa Pembayaran</span>
                        <span><?= e(rupiah($b['sisa'])) ?></span>
                    </div>

                </div>


                <!-- AKSI -->

                <div class="ad-aksi">
                    <button type="button" class="ad-btn terima" id="btnTerima"><?= ikon('cek') ?> Terima Pembayaran</button>
                    <button type="button" class="ad-btn tolak" id="btnTolak"><?= ikon('tutup') ?> Tolak Pembayaran</button>
                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


    <!-- ===== MODAL BUKTI TRANSFER ===== -->
    <div class="ad-modal" id="modalBukti" role="dialog" aria-modal="true" aria-label="Bukti transfer">
        <button type="button" class="ad-x" id="btnTutupBukti" aria-label="Tutup"><?= ikon('tutup') ?></button>
        <img src="<?= e($b['bukti']) ?>" alt="Bukti Transfer">
    </div>


<script>

/* ===== bukti transfer & verifikasi pembayaran ===== */

(function () {

    const modal = document.getElementById("modalBukti");
    const gambar = document.getElementById("gambarBukti");

    /* kalau file gambar tidak ada, tampilkan penanda */
    gambar.addEventListener("error", function () {
        gambar.style.display = "none";
        document.getElementById("buktiKosong").style.display = "flex";
        document.getElementById("catatanBukti").style.display = "none";
    });

    gambar.addEventListener("click", function () {
        modal.classList.add("show");
    });

    function tutupBukti() {
        modal.classList.remove("show");
    }

    document.getElementById("btnTutupBukti").addEventListener("click", tutupBukti);

    modal.addEventListener("click", function (e) {
        if (e.target === modal) tutupBukti();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("show")) tutupBukti();
    });

    /* ubah label status di halaman (demo; nanti simpan ke server) */
    function setStatus(teks, kelas) {
        ["pilBooking", "pilBayar1", "pilBayar2"].forEach(function (id) {
            const el = document.getElementById(id);
            el.textContent = teks;
            el.className = "ad-pil " + kelas;
        });
        document.getElementById("btnTerima").disabled = true;
        document.getElementById("btnTolak").disabled = true;
    }

    document.getElementById("btnTerima").addEventListener("click", function () {
        if (confirm("Apakah bukti transfer sudah benar dan pembayaran diterima?")) {
            alert("Pembayaran diterima. Booking berhasil dikonfirmasi.");
            setStatus("Dikonfirmasi", "ok");
        }
    });

    document.getElementById("btnTolak").addEventListener("click", function () {
        const alasan = prompt("Masukkan alasan penolakan bukti transfer:");
        if (alasan && alasan.trim() !== "") {
            alert("Bukti transfer ditolak.\nAlasan: " + alasan.trim());
            setStatus("Ditolak", "tolak");
        }
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