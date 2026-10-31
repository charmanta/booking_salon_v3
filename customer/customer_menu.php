<?php
/*
 * Sidebar customer (pengganti menu bawah).
 * Cara pakai: taruh tepat setelah tag <body> di setiap halaman customer:
 *     <?php include __DIR__ . '/customer_menu.php'; ?>
 * Menu aktif otomatis mengikuti nama file halaman.
 */

if (!function_exists('e')) {
    function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

function cm_ikon($nama) {
    $p = [
        'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
        'riwayat'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>',
        'chat'     => '<path d="M21 12a8 8 0 0 1-11.500 7.200L4 21l1.800-5A8 8 0 1 1 21 12z"/>',
        'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
        'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

/* Data pengguna (nanti ambil dari sesi login) */
$cmUser = ['nama' => 'Rina', 'peran' => 'Reservin Member', 'inisial' => 'R'];

/* [file, label, ikon, buka di tab baru?, halaman yang membuat menu ini aktif] */
$cmMenu = [
    ['dashboard.php',   'Beranda',   'home',     false, ['dashboard.php']],
    ['pilih_salon.php', 'Reservasi', 'kalender', false, ['pilih_salon.php', 'booking.php']],
    ['riwayat.php',     'Riwayat',   'riwayat',  false, ['riwayat.php']],
    ['https://gemini.google.com/', 'Tanya AI', 'chat', true, []],
];

$cmHalaman = basename(parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH));
?>
<style>
    :root {
        --cm-side: 250px;
        /* ganti dua warna ini kalau ingin sama persis dengan sidebar admin (rose): #b07f79 dan #a36d67 */
        --cm-a: #3b2a22;
        --cm-b: #2b1e19;
        --cm-aksen: #c4a074;
    }

    /* menu bawah & menu atas lama diganti sidebar */
    .bottom, .site-nav { display: none !important; }
    /* ruang kosong di bawah halaman yang dulu dipakai menu bawah */
    .page-customer { padding-bottom: 0 !important; }

    /* ===== HEADER: logo di tengah, tombol Booking Sekarang di kanan ===== */
    @media (min-width: 901px) {
        .site-header--customer .brand {
            grid-column: 2;
            grid-row: 1;
            justify-self: center;
        }
        .site-header--customer .header-right {
            grid-column: 3;
            grid-row: 1;
            justify-self: end;
        }
    }
    /* mobile: header menumpuk di tengah, beri ruang atas supaya tidak tertimpa tombol burger */
    @media (max-width: 900px) {
        .site-header--customer { padding-top: 72px; }
    }

    .cm-burger {
        position: fixed; top: 14px; left: 14px; z-index: 150;
        width: 46px; height: 46px; padding: 0; display: grid; place-items: center;
        background: #faf6f0; border: 1px solid #e6dccf; border-radius: 10px; color: #2b1e19; cursor: pointer;
    }
    .cm-burger:hover { background: #f1e8dc; }
    .cm-burger svg { width: 26px; height: 26px; }

    .cm-side {
        position: fixed; top: 0; left: 0; bottom: 0; width: var(--cm-side); z-index: 1200;
        background: linear-gradient(180deg, var(--cm-a) 0%, var(--cm-b) 100%);
        color: #fff; display: flex; flex-direction: column; padding: 22px 16px 18px;
        transform: translateX(-100%); overflow-y: auto; box-shadow: 8px 0 30px rgba(0, 0, 0, .3);
        font-family: 'Jost', sans-serif; visibility: hidden;
    }
    body.cm-open .cm-side { transform: none; visibility: visible; }
    body.cm-ready .cm-side { transition: transform .3s ease, visibility .3s; }

    .cm-overlay { display: none; position: fixed; inset: 0; z-index: 1100; background: rgba(30, 18, 16, .5); }
    body.cm-open .cm-overlay { display: block; }

    .cm-logo { display: flex; align-items: center; justify-content: space-between; gap: 8px; text-decoration: none; color: #fff; padding: 0 4px 4px; }
    .cm-logo b { display: block; font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 500; letter-spacing: .24em; line-height: 1; }
    .cm-logo small { display: block; margin-top: 6px; font-size: 12px; letter-spacing: .18em; text-transform: uppercase; opacity: .85; }
    .cm-logo svg { width: 26px; height: 26px; color: var(--cm-aksen); }

    .cm-nav { margin-top: 28px; display: flex; flex-direction: column; gap: 4px; }
    .cm-link {
        display: flex; align-items: center; gap: 12px; padding: 12px 14px; border-radius: 10px;
        color: #fff; text-decoration: none; font-size: 15px; opacity: .92;
    }
    .cm-link:hover { background: rgba(255, 255, 255, .1); }
    .cm-link.active { background: rgba(196, 160, 116, .28); font-weight: 600; opacity: 1; box-shadow: inset 3px 0 0 var(--cm-aksen); }
    .cm-link svg { width: 20px; height: 20px; flex: none; }

    .cm-bawah { margin-top: auto; padding-top: 14px; border-top: 1px solid rgba(255, 255, 255, .22); }
    .cm-profil { display: flex; align-items: center; gap: 10px; padding: 4px 4px 12px; }
    .cm-ava { width: 40px; height: 40px; border-radius: 50%; background: var(--cm-aksen); color: #2b1e19; display: grid; place-items: center; font-weight: 700; font-size: 15px; flex: none; }
    .cm-profil b { display: block; font-size: 15px; font-weight: 500; }
    .cm-profil small { display: block; font-size: 12.5px; opacity: .8; margin-top: 2px; }

    .cm-tutup { position: absolute; top: 14px; right: 12px; width: 36px; height: 36px; padding: 0; display: grid; place-items: center; background: transparent; border: 0; border-radius: 8px; color: #fff; cursor: pointer; opacity: .8; }
    .cm-tutup:hover { background: rgba(255, 255, 255, .12); opacity: 1; }
    .cm-tutup svg { width: 20px; height: 20px; }

    .cm-burger:focus-visible, .cm-link:focus-visible, .cm-tutup:focus-visible { outline: 2px solid var(--cm-aksen); outline-offset: 2px; }

    @media print { .cm-burger, .cm-side, .cm-overlay { display: none !important; } }
</style>

<button type="button" class="cm-burger" id="cmBurger" aria-label="Buka menu" aria-expanded="false" aria-controls="cmSide">
    <?= cm_ikon('menu') ?>
</button>

<aside class="cm-side" id="cmSide" aria-label="Menu customer">

    <button type="button" class="cm-tutup" id="cmTutup" aria-label="Tutup menu"><?= cm_ikon('tutup') ?></button>

    <a class="cm-logo" href="dashboard.php" aria-label="Reservin Salon Booking">
        <span>
            <b>RESERVIN</b>
            <small>Salon Booking</small>
        </span>
        <?= cm_ikon('gunting') ?>
    </a>

    <nav class="cm-nav">
        <?php foreach ($cmMenu as $m): ?>
            <?php $aktif = in_array($cmHalaman, $m[4], true); ?>
            <a href="<?= e($m[0]) ?>"
               class="cm-link<?= $aktif ? ' active' : '' ?>"
               <?= $aktif ? 'aria-current="page"' : '' ?>
               <?= $m[3] ? 'target="_blank" rel="noopener"' : '' ?>>
                <?= cm_ikon($m[2]) ?>
                <?= e($m[1]) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="cm-bawah">

        <div class="cm-profil">
            <div class="cm-ava"><?= e($cmUser['inisial']) ?></div>
            <div>
                <b><?= e($cmUser['nama']) ?></b>
                <small><?= e($cmUser['peran']) ?></small>
            </div>
        </div>

        <a href="../login.php" class="cm-link">
            <?= cm_ikon('logout') ?>
            Keluar
        </a>

    </div>

</aside>

<div class="cm-overlay" id="cmOverlay"></div>

<script>
(function () {

    const body = document.body;
    const burger = document.getElementById("cmBurger");
    const overlay = document.getElementById("cmOverlay");
    const tutup = document.getElementById("cmTutup");

    function atur(buka) {
        body.classList.toggle("cm-open", buka);
        burger.setAttribute("aria-expanded", buka ? "true" : "false");
        burger.setAttribute("aria-label", buka ? "Tutup menu" : "Buka menu");
    }

    burger.addEventListener("click", function () {
        atur(!body.classList.contains("cm-open"));
    });

    overlay.addEventListener("click", function () { atur(false); });
    tutup.addEventListener("click", function () { atur(false); });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") atur(false);
    });

    /* animasi baru aktif setelah halaman siap */
    requestAnimationFrame(function () {
        requestAnimationFrame(function () { body.classList.add("cm-ready"); });
    });

})();
</script>
