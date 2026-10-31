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
    ['detail_booking.php',   'Detail Reservasi', 'daftar',   false],
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
    <!-- Halaman ini berdiri sendiri: semua gaya ada di blok <style> di bawah -->
    <style>
        :root {
            --side: 232px;
            --tan: #c4938d;
            --tan-dark: #a9726c;
            --tan-deep: #96605a;
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

        /* ringkasan */
        .ad-stats { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; margin-top: 34px; }
        .ad-stat { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 18px 22px; display: flex; align-items: center; gap: 16px; }
        .ad-ic { width: 50px; height: 50px; border-radius: 50%; display: grid; place-items: center; flex: none; }
        .ad-ic svg { width: 24px; height: 24px; }
        .ad-ic.tan { background: #fbe1de; color: #b4524a; }
        .ad-ic.amber { background: #fdf0d3; color: #8a5a00; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-stat .nilai { font-size: 22px; font-weight: 700; line-height: 1.1; }
        .ad-stat .judul { margin-top: 4px; font-size: 14.5px; color: #4d4650; }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 28px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 6px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-jumlah { font-size: 14px; color: var(--muted); }
        .ad-tip { margin: 0 0 20px; font-size: 14.5px; color: var(--muted); }

        .ad-pil { display: inline-block; padding: 5px 10px; border-radius: 8px; font-size: 12.5px; font-weight: 500; white-space: nowrap; }
        .ad-pil.ok { background: #dff3e8; color: #1c6f47; }
        .ad-pil.off { background: #f1ebe8; color: #7a6c68; }

        /* kisi hari */
        .ad-pekan { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 12px; }
        .ad-hr { display: flex; flex-direction: column; gap: 4px; min-height: 150px; padding: 16px 14px; border: 1px solid var(--line); border-radius: 14px; background: #fff; }
        .ad-hr .nm { font-size: 15px; font-weight: 600; }
        .ad-hr .tg { font-size: 13px; color: var(--muted); }
        .ad-hr .jam { margin-top: 10px; font-size: 16px; font-weight: 600; color: #7a4a45; line-height: 1.3; }
        .ad-hr .dur { font-size: 13px; color: var(--muted); }
        .ad-hr.libur { background: #faf7f5; }
        .ad-hr.libur .jam { color: #a89c97; font-weight: 500; }
        .ad-hr.ini { border: 2px solid var(--tan); background: #fcf5f2; padding: 15px 13px; }
        .ad-hr .tag { align-self: flex-start; margin-bottom: 4px; padding: 3px 8px; border-radius: 6px; background: var(--tan-dark); color: #fff; font-size: 11.5px; font-weight: 500; }
        .ad-hr .pres { margin-top: auto; padding-top: 10px; display: flex; flex-direction: column; gap: 6px; align-items: flex-start; }
        .ad-hr .pres a { font-size: 13px; color: var(--tan-deep); text-decoration: underline; }

        .ad-catatan { margin: 18px 0 0; font-size: 13.5px; color: var(--muted); }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible, .ad-hr a:focus-visible { outline: 2px solid var(--tan); outline-offset: 2px; }

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

        @media (max-width: 1250px) {
            .ad-pekan { grid-template-columns: repeat(4, minmax(0, 1fr)); }
        }

        @media (max-width: 860px) {
            .ad-stats { grid-template-columns: 1fr; }
            .ad-pekan { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-pekan { grid-template-columns: 1fr; }
            .ad-hr { min-height: 0; }
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


<script>

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
