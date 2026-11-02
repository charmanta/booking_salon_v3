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
    ['detail_booking.php',   'Pesanan Masuk',    'daftar',  false],
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
    <title>Reservasi Baru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Terpadu Matching Admin & Customer -->
    <link rel="stylesheet" href="../admin/css/admin.css">
    <link rel="stylesheet" href="pegawai.css">
    <!-- Halaman ini berdiri sendiri: semua gaya ada di blok
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


</script>

    <!-- Script Interaktivitas Global Admin & Ripple Wave -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>