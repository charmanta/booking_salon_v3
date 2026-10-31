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
        'pin'      => '<path d="M12 21s7-6.200 7-11.500a7 7 0 0 0-14 0C5 14.800 12 21 12 21z"/><circle cx="12" cy="9.500" r="2.500"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'cek'      => '<circle cx="12" cy="12" r="9"/><path d="M8 12.500l3 3 5-6"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',    false],
    ['salon.php',     'Data Salon', 'store',   false],
    ['layanan.php',   'Layanan',    'gunting', false],
    ['pegawai.php',   'Pegawai',    'users',   false],
    ['laporan.php',   'Laporan',    'laporan', false],
    ['profil.php',    'Profil',     'user',    true],
];

$akun = [
    'nama'    => 'Siti Amelia',
    'telepon' => '081234567890',
    'email'   => 'sitiamelia@gmail.com',
    'peran'   => 'Pemilik / Admin Salon',
];

$salon = [
    'nama'    => 'Luna Salon',
    'telepon' => '081234567890',
    'alamat'  => 'Jl. Merdeka No. 10, Bandung',
    'lokasi'  => 'Bandung',
    'buka'    => '09:00',
    'tutup'   => '20:00',
    'status'  => 'Aktif',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Salon</title>
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
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-sub { margin: 6px 0 22px; font-size: 14.5px; color: var(--muted); }

        /* kepala profil */
        .ad-kepala { display: flex; align-items: center; gap: 18px; padding: 18px; margin-bottom: 24px; background: #fbf4f1; border: 1px solid var(--line); border-radius: 14px; }
        .ad-kepala .ad-ava { width: 72px; height: 72px; font-size: 26px; background: var(--rose-soft); color: #fff; }
        .ad-kepala b { display: block; font-size: 22px; font-weight: 600; }
        .ad-kepala small { display: block; margin-top: 4px; font-size: 15px; color: var(--muted); }

        /* form */
        .ad-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px 24px; }
        .ad-field { display: flex; flex-direction: column; gap: 8px; min-width: 0; }
        .ad-field.full { grid-column: 1 / -1; }
        .ad-field label { font-size: 14px; font-weight: 500; color: #4d4650; }
        .ad-field input, .ad-field textarea {
            width: 100%; font-family: inherit; font-size: 15.5px; color: var(--ink);
            background: #fff; border: 1px solid #e3d8d2; border-radius: 10px; padding: 12px 14px;
            transition: border-color .15s, box-shadow .15s;
        }
        .ad-field textarea { min-height: 96px; resize: vertical; line-height: 1.5; }
        .ad-field input:focus, .ad-field textarea:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }

        /* tombol */
        .ad-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
        .ad-btn {
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 24px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; transition: background .15s;
        }
        .ad-btn.utama { background: var(--rose); color: #fff; }
        .ad-btn.utama:hover { background: var(--rose-dark); }
        .ad-btn.kedua { background: #fff; color: #4d4650; border-color: #e3d8d2; }
        .ad-btn.kedua:hover { background: #f6ece7; }

        /* ringkasan salon */
        .ad-info-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; }
        .ad-info { display: flex; align-items: center; gap: 14px; padding: 16px 18px; border: 1px solid var(--line); border-radius: 14px; min-width: 0; }
        .ad-ic { width: 46px; height: 46px; border-radius: 50%; display: grid; place-items: center; flex: none; }
        .ad-ic svg { width: 22px; height: 22px; }
        .ad-ic.rose { background: #fbe1de; color: #b4524a; }
        .ad-ic.violet { background: #e8e2fa; color: #5f4ab0; }
        .ad-ic.blue { background: #dcebfb; color: #2a68b0; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-info small { display: block; font-size: 13px; color: var(--muted); }
        .ad-info b { display: block; margin-top: 3px; font-size: 16.5px; font-weight: 600; overflow-wrap: anywhere; }

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

        @media (max-width: 1200px) {
            .ad-info-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
            .ad-form-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-info-grid { grid-template-columns: 1fr; }
            .ad-aksi .ad-btn { flex: 1; }
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

            <section class="ad-sapa">
                <h1>Profil</h1>
                <p>Kelola informasi akun dan salon Anda.</p>
            </section>


            <form id="formProfil" onsubmit="return simpanProfil(event)">

                <!-- INFORMASI AKUN -->

                <section class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Informasi Akun</h2>
                    </div>
                    <p class="ad-sub">Informasi pemilik akun yang digunakan untuk mengelola salon.</p>

                    <div class="ad-kepala">
                        <div class="ad-ava"><?= e($admin['inisial']) ?></div>
                        <div>
                            <b><?= e($akun['nama']) ?></b>
                            <small><?= e($akun['peran']) ?></small>
                        </div>
                    </div>

                    <div class="ad-form-grid">

                        <div class="ad-field">
                            <label for="namaPemilik">Nama Pemilik</label>
                            <input type="text" id="namaPemilik" value="<?= e($akun['nama']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="text" id="telepon" value="<?= e($akun['telepon']) ?>">
                        </div>

                        <div class="ad-field full">
                            <label for="email">Email</label>
                            <input type="email" id="email" value="<?= e($akun['email']) ?>">
                        </div>

                    </div>

                </section>


                <!-- INFORMASI SALON -->

                <section class="ad-kartu">

                    <div class="ad-kartu-head">
                        <h2>Informasi Salon</h2>
                    </div>
                    <p class="ad-sub">Informasi salon yang ditampilkan kepada pelanggan.</p>

                    <div class="ad-form-grid">

                        <div class="ad-field">
                            <label for="namaSalon">Nama Salon</label>
                            <input type="text" id="namaSalon" value="<?= e($salon['nama']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="teleponSalon">Nomor Telepon Salon</label>
                            <input type="text" id="teleponSalon" value="<?= e($salon['telepon']) ?>">
                        </div>

                        <div class="ad-field full">
                            <label for="alamatSalon">Alamat Salon</label>
                            <textarea id="alamatSalon"><?= e($salon['alamat']) ?></textarea>
                        </div>

                        <div class="ad-field">
                            <label for="jamBuka">Jam Buka</label>
                            <input type="time" id="jamBuka" value="<?= e($salon['buka']) ?>">
                        </div>

                        <div class="ad-field">
                            <label for="jamTutup">Jam Tutup</label>
                            <input type="time" id="jamTutup" value="<?= e($salon['tutup']) ?>">
                        </div>

                    </div>

                    <div class="ad-aksi">
                        <button type="button" class="ad-btn kedua" onclick="batal()">Batal</button>
                        <button type="submit" class="ad-btn utama">Simpan Perubahan</button>
                    </div>

                </section>

            </form>


            <!-- RINGKASAN SALON -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Ringkasan Salon</h2>
                </div>
                <p class="ad-sub">Informasi utama salon Anda.</p>

                <div class="ad-info-grid">

                    <div class="ad-info">
                        <div class="ad-ic rose"><?= ikon('store') ?></div>
                        <div>
                            <small>Nama Salon</small>
                            <b><?= e($salon['nama']) ?></b>
                        </div>
                    </div>

                    <div class="ad-info">
                        <div class="ad-ic violet"><?= ikon('pin') ?></div>
                        <div>
                            <small>Lokasi</small>
                            <b><?= e($salon['lokasi']) ?></b>
                        </div>
                    </div>

                    <div class="ad-info">
                        <div class="ad-ic blue"><?= ikon('jam') ?></div>
                        <div>
                            <small>Jam Operasional</small>
                            <b><?= e(str_replace(':', '.', $salon['buka'])) ?> – <?= e(str_replace(':', '.', $salon['tutup'])) ?></b>
                        </div>
                    </div>

                    <div class="ad-info">
                        <div class="ad-ic green"><?= ikon('cek') ?></div>
                        <div>
                            <small>Status Salon</small>
                            <b><?= e($salon['status']) ?></b>
                        </div>
                    </div>

                </div>

            </section>

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


<script>

function simpanProfil(e) {

    if (e) e.preventDefault();

    const nama = document.getElementById("namaPemilik").value.trim();
    const salon = document.getElementById("namaSalon").value.trim();

    if (nama === "" || salon === "") {
        alert("Nama pemilik dan nama salon wajib diisi.");
        return false;
    }

    alert("Perubahan profil berhasil disimpan.");
    return false;

}

function batal() {
    location.reload();
}


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