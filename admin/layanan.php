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
        'plus'     => '<path d="M12 5v14M5 12h14"/>',
        'edit'     => '<path d="M4 20h4L19 9a2.800 2.800 0 0 0-4-4L4 16z"/><path d="M13.500 6.500l4 4"/>',
        'hapus'    => '<path d="M4 7h16M10 11v6M14 11v6"/><path d="M6 7l1 13h10l1-13"/><path d="M9 7V4h6v3"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function rupiah($n) { return 'Rp' . number_format((int)$n, 0, ',', '.'); }

/* ===== Data contoh (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',    false],
    ['salon.php',     'Data Salon', 'store',   false],
    ['layanan.php',   'Layanan',    'gunting', true],
    ['pegawai.php',   'Pegawai',    'users',   false],
    ['laporan.php',   'Laporan',    'laporan', false],
    ['profil.php',    'Profil',     'user',    false],
];

/* [nama, harga, durasi (menit), keterangan] */
$layanan = [
    ['Creambath',     100000, 60,  'Perawatan rambut dan kulit kepala.'],
    ['Hair Spa',      150000, 90,  'Perawatan rambut intensif.'],
    ['Potong Rambut',  50000, 45,  'Potong rambut sesuai model pilihan.'],
    ['Hair Coloring', 250000, 120, 'Pewarnaan rambut sesuai pilihan pelanggan.'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Salon</title>
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
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-jumlah { font-size: 14px; color: var(--muted); }

        /* tombol */
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
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 720px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 14px; padding: 14px 14px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel td { padding: 15px 14px; border-bottom: 1px solid var(--line); vertical-align: middle; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-tabel .nama { font-weight: 600; white-space: nowrap; }
        .ad-tabel .harga, .ad-tabel .durasi { white-space: nowrap; }
        .ad-tabel .harga { font-weight: 500; }
        .ad-tabel .ket { color: #4d4650; min-width: 220px; }

        .ad-aksi-sel { display: flex; gap: 8px; }
        .ad-mini {
            display: inline-flex; align-items: center; gap: 6px; font-family: inherit; font-size: 13.5px; font-weight: 500;
            padding: 7px 12px; border-radius: 8px; cursor: pointer; background: #fff; border: 1px solid #e3d8d2; color: #4d4650;
        }
        .ad-mini svg { width: 16px; height: 16px; }
        .ad-mini:hover { background: #f6ece7; }
        .ad-mini.bahaya { color: #b4423a; border-color: #efc9c5; }
        .ad-mini.bahaya:hover { background: #fdeceb; }

        /* modal */
        .ad-modal { display: none; position: fixed; inset: 0; z-index: 400; background: rgba(30, 18, 16, .5); align-items: center; justify-content: center; padding: 18px; }
        .ad-modal.show { display: flex; }
        .ad-modal-box { background: #fff; border-radius: 16px; width: 100%; max-width: 480px; max-height: calc(100vh - 36px); overflow-y: auto; padding: 26px 28px; box-shadow: 0 20px 50px rgba(40, 20, 16, .25); }
        .ad-modal-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .ad-modal-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-x { width: 36px; height: 36px; border: 0; background: transparent; border-radius: 8px; display: grid; place-items: center; cursor: pointer; color: #4a4348; padding: 0; }
        .ad-x:hover { background: rgba(0, 0, 0, .06); }

        .ad-field { display: flex; flex-direction: column; gap: 8px; margin-bottom: 16px; }
        .ad-field label { font-size: 14px; font-weight: 500; color: #4d4650; }
        .ad-field input, .ad-field textarea {
            width: 100%; font-family: inherit; font-size: 15.5px; color: var(--ink);
            background: #fff; border: 1px solid #e3d8d2; border-radius: 10px; padding: 12px 14px;
            transition: border-color .15s, box-shadow .15s;
        }
        .ad-field textarea { min-height: 96px; resize: vertical; line-height: 1.5; }
        .ad-field input:focus, .ad-field textarea:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }
        .ad-field-2 { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .ad-modal-aksi { display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px; }

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
                    <h1>Layanan Salon</h1>
                    <p>Kelola layanan yang tersedia di salon Anda.</p>
                </section>

                <button type="button" class="ad-btn utama" id="btnTambah">
                    <?= ikon('plus') ?> Tambah Layanan
                </button>

            </div>


            <!-- DAFTAR LAYANAN -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Daftar Layanan</h2>
                    <span class="ad-jumlah"><?= count($layanan) ?> layanan</span>
                </div>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($layanan as $i => $l): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td class="nama"><?= e($l[0]) ?></td>
                                    <td class="harga"><?= e(rupiah($l[1])) ?></td>
                                    <td class="durasi"><?= (int)$l[2] ?> menit</td>
                                    <td class="ket"><?= e($l[3]) ?></td>
                                    <td>
                                        <div class="ad-aksi-sel">
                                            <button type="button" class="ad-mini btn-edit"
                                                data-nama="<?= e($l[0]) ?>"
                                                data-harga="<?= (int)$l[1] ?>"
                                                data-durasi="<?= (int)$l[2] ?>"
                                                data-ket="<?= e($l[3]) ?>">
                                                <?= ikon('edit') ?> Edit
                                            </button>
                                            <button type="button" class="ad-mini bahaya btn-hapus" data-nama="<?= e($l[0]) ?>">
                                                <?= ikon('hapus') ?> Hapus
                                            </button>
                                        </div>
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


    <!-- ===== MODAL TAMBAH / EDIT ===== -->
    <div class="ad-modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

        <div class="ad-modal-box">

            <div class="ad-modal-head">
                <h2 id="modalTitle">Tambah Layanan</h2>
                <button type="button" class="ad-x" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>
            </div>

            <div class="ad-field">
                <label for="nama">Nama Layanan</label>
                <input type="text" id="nama" placeholder="Contoh: Creambath">
            </div>

            <div class="ad-field-2">
                <div class="ad-field">
                    <label for="harga">Harga (Rp)</label>
                    <input type="number" id="harga" min="0" placeholder="Contoh: 100000">
                </div>

                <div class="ad-field">
                    <label for="durasi">Durasi (menit)</label>
                    <input type="number" id="durasi" min="0" placeholder="Contoh: 60">
                </div>
            </div>

            <div class="ad-field">
                <label for="keterangan">Keterangan</label>
                <textarea id="keterangan" placeholder="Masukkan keterangan layanan"></textarea>
            </div>

            <div class="ad-modal-aksi">
                <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
                <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
            </div>

        </div>

    </div>


<script>

/* ===== layanan: tambah, edit, hapus ===== */

(function () {

    const modal = document.getElementById("modal");

    function buka(judul, nama, harga, durasi, ket) {
        document.getElementById("modalTitle").textContent = judul;
        document.getElementById("nama").value = nama;
        document.getElementById("harga").value = harga;
        document.getElementById("durasi").value = durasi;
        document.getElementById("keterangan").value = ket;
        modal.classList.add("show");
        document.getElementById("nama").focus();
    }

    function tutup() {
        modal.classList.remove("show");
    }

    document.getElementById("btnTambah").addEventListener("click", function () {
        buka("Tambah Layanan", "", "", "", "");
    });

    document.querySelectorAll(".btn-edit").forEach(function (b) {
        b.addEventListener("click", function () {
            buka("Edit Layanan", b.dataset.nama, b.dataset.harga, b.dataset.durasi, b.dataset.ket);
        });
    });

    document.querySelectorAll(".btn-hapus").forEach(function (b) {
        b.addEventListener("click", function () {
            if (confirm("Hapus layanan " + b.dataset.nama + "?")) {
                alert("Layanan " + b.dataset.nama + " berhasil dihapus.");
            }
        });
    });

    document.getElementById("btnSimpan").addEventListener("click", function () {
        if (document.getElementById("nama").value.trim() === "") {
            alert("Nama layanan belum diisi.");
            return;
        }
        alert("Data layanan berhasil disimpan.");
        tutup();
    });

    document.getElementById("btnBatal").addEventListener("click", tutup);
    document.getElementById("btnX").addEventListener("click", tutup);

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