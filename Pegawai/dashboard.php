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
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'cek'      => '<circle cx="12" cy="12" r="9"/><path d="M8 12.500l3 3 5-6"/>',
        'bintang'  => '<path d="M12 3.500l2.600 5.300 5.800.8-4.200 4.100 1 5.800-5.200-2.700-5.200 2.700 1-5.800L3.600 9.600l5.800-.8z"/>',
        'panah'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
        'kamera'   => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.500" r="3.500"/>',
        'kirim'    => '<path d="M4 12l16-8-6 17-3-7z"/><path d="M11 14l9-10"/>',
        'lonceng'  => '<path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4z"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'kalender' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
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

$pegawai = ['nama' => 'Siti Amelia', 'panggilan' => 'Siti', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    true],
    ['detail_booking.php',   'Pesanan Masuk',    'lonceng', false],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['jadwal_saya.php',      'Jadwal Saya',      'kalender', false],
    ['profil.php',           'Profil',           'user',    false],
];

/* [ikon, warna, nilai, judul] */
$stat = [
    ['daftar',  'tan',   '12',  'Total Booking'],
    ['jam',     'amber', '4',   'Menunggu'],
    ['cek',     'green', '8',   'Dikonfirmasi'],
    ['bintang', 'gold',  '4.8', 'Rating'],
];

/* [kode, pelanggan, layanan, jam, status] */
$booking = [
    ['RSV-001', 'Rina', 'Creambath',     '10:00', 'Menunggu'],
    ['RSV-002', 'Dewi', 'Potong Rambut', '13:00', 'Dikonfirmasi'],
    ['RSV-003', 'Maya', 'Hair Spa',      '15:00', 'Dikonfirmasi'],
];

/* ===== Presensi =====
 * Jadwal diatur admin di halaman Pegawai (hari kerja, jam masuk, jam pulang).
 * Pengingat muncul MENIT_PENGINGAT menit sebelum jam masuk, dan tetap tampil
 * (berubah jadi peringatan terlambat) sampai pegawai mengirim presensi
 * atau jam pulang tiba.
 */
$MENIT_PENGINGAT = 30;

$jadwal       = ['masuk' => '09:00', 'pulang' => '17:00'];
$hariKerja    = [1, 2, 3, 4, 5, 6];                       /* 1 = Senin ... 7 = Minggu */
$kerjaHariIni = in_array((int)date('N'), $hariKerja, true);
$masukTs      = strtotime(date('Y-m-d') . ' ' . $jadwal['masuk']);
$pulangTs     = strtotime(date('Y-m-d') . ' ' . $jadwal['pulang']);

/* presensi hari ini: null = belum, atau ['jam' => 'H:i'] bila sudah terkirim */
$presensiHariIni = null;

/* riwayat beberapa hari terakhir: [timestamp, jam kirim atau null] */
$riwayat = [];
foreach ([1 => '08:51', 2 => '08:47', 3 => null, 4 => '09:02'] as $mundur => $jam) {
    $riwayat[] = [strtotime("-$mundur day"), $jam];
}

$statusTeks = $presensiHariIni
    ? 'Aktif · terkirim ' . $presensiHariIni['jam']
    : ($kerjaHariIni ? 'Belum presensi' : 'Libur');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Terpadu Matching Admin & Customer -->
    <link rel="stylesheet" href="../admin/css/admin.css">
    <link rel="stylesheet" href="pegawai.css">
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

            <!-- SAMBUTAN -->

            <section class="ad-sapa">
                <h1>Halo, <?= e($pegawai['panggilan']) ?>!</h1>
                <p>Berikut informasi booking salon hari ini.</p>
            </section>


            <!-- STATISTIK -->

            <section class="ad-stats">
                <?php foreach ($stat as $s): ?>
                    <div class="ad-stat">
                        <div class="ad-ic <?= e($s[1]) ?>"><?= ikon($s[0]) ?></div>
                        <div class="nilai"><?= e($s[2]) ?></div>
                        <div class="judul"><?= e($s[3]) ?></div>
                    </div>
                <?php endforeach; ?>
            </section>


            <!-- PRESENSI KERJA (ringkas) -->

            <section class="ad-kartu ad-pres" id="presensi" aria-labelledby="judulPresensi">

                <!-- pengingat: diatur oleh script di bawah -->
                <div class="ad-ingat" id="pengingat" role="alert" hidden>
                    <?= ikon('lonceng') ?>
                    <span id="teksPengingat"></span>
                    <button type="button" class="ad-mini" id="btnPengingat">Kirim presensi</button>
                </div>

                <div class="ad-pres-isi">

                    <div>
                        <div class="ad-pres-judul">
                            <h2 id="judulPresensi">Presensi Kerja</h2>
                            <span class="ad-pil <?= $presensiHariIni ? 'ok' : 'off' ?>" id="pilPresensi"><?= $presensiHariIni ? 'Aktif' : ($kerjaHariIni ? 'Belum presensi' : 'Libur') ?></span>
                        </div>

                        <p class="ad-pres-data">
                            <span><?= e(tglHari(time())) ?></span>
                            <span>Jadwal <b><?= $kerjaHariIni ? e($jadwal['masuk']) . ' – ' . e($jadwal['pulang']) : 'libur' ?></b></span>
                            <span>Status <b id="teksStatus"><?= e($statusTeks) ?></b></span>
                        </p>

                        <p class="ad-aturan">Foto diambil di dalam salon · JPG, PNG, atau WEBP · maks. 5 MB · sekali sehari.</p>

                        <div class="ad-pesan" id="pesan" role="status"></div>
                    </div>

                    <div class="ad-pres-aksi">

                        <label class="ad-drop<?= $kerjaHariIni ? '' : ' mati' ?>" id="drop" for="fotoPresensi"<?= $presensiHariIni ? ' hidden' : '' ?>>
                            <?= ikon('kamera') ?>
                            <b>Ambil foto</b>
                            <input type="file" id="fotoPresensi" accept="image/jpeg,image/png,image/webp" capture="user"<?= ($kerjaHariIni && !$presensiHariIni) ? '' : ' disabled' ?>>
                        </label>

                        <div class="ad-thumb" id="preview" hidden>
                            <img id="gambarPreview" alt="Foto presensi">
                            <button type="button" id="btnGanti">Ganti</button>
                        </div>

                        <div class="ad-pres-tombol">
                            <button type="button" class="ad-btn utama" id="btnKirim"<?= ($kerjaHariIni && !$presensiHariIni) ? '' : ' disabled' ?>>
                                <?= ikon('kirim') ?> Kirim Presensi
                            </button>
                        </div>

                    </div>

                </div>

                <?php if ($riwayat): ?>
                    <div class="ad-pres-riwayat">
                        <span>Terakhir:</span>
                        <?php foreach ($riwayat as $r): ?>
                            <span class="ad-chip <?= $r[1] ? 'ok' : 'off' ?>">
                                <?= e($hariPendek[(int)date('N', $r[0])] . ' ' . date('j', $r[0])) ?> · <?= $r[1] ? e($r[1]) : 'tidak masuk' ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </section>


            <!-- BOOKING HARI INI -->

            <section class="ad-kartu">

                <div class="ad-kartu-head">
                    <h2>Booking Hari Ini</h2>
                    <a class="ad-semua" href="daftar_reservasi.php">Lihat Semua <?= ikon('panah') ?></a>
                </div>

                <div class="ad-tabel-box">
                    <table class="ad-tabel">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Layanan</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($booking as $b): ?>
                                <tr>
                                    <td class="kode"><?= e($b[0]) ?></td>
                                    <td><?= e($b[1]) ?></td>
                                    <td><?= e($b[2]) ?></td>
                                    <td><?= e($b[3]) ?></td>
                                    <td>
                                        <span class="ad-pil <?= $b[4] === 'Dikonfirmasi' ? 'ok' : 'tunggu' ?>"><?= e($b[4]) ?></span>
                                    </td>
                                    <td>
                                        <a href="detail_booking.php" class="ad-mini">Detail</a>
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


<script>

/* ===== presensi kerja + pengingat ===== */

(function () {

    /* waktu dalam milidetik (epoch) dari server, jadi tidak terpengaruh zona waktu perangkat */
    const JADWAL = {
        kerja: <?= $kerjaHariIni ? 'true' : 'false' ?>,
        masuk: <?= (int)$masukTs ?> * 1000,
        pulang: <?= (int)$pulangTs ?> * 1000,
        jamMasuk: "<?= e($jadwal['masuk']) ?>",
        menitAwal: <?= (int)$MENIT_PENGINGAT ?>
    };

    const MAKS = 5 * 1024 * 1024;
    const JENIS = ["image/jpeg", "image/png", "image/webp"];

    const $ = function (id) { return document.getElementById(id); };
    const input = $("fotoPresensi");
    const drop = $("drop");
    const preview = $("preview");
    const gambar = $("gambarPreview");
    const pesan = $("pesan");
    const btnKirim = $("btnKirim");
    const btnGanti = $("btnGanti");
    const pengingat = $("pengingat");

    let berkas = null;
    let urlSementara = null;
    let sudahPresensi = <?= $presensiHariIni ? 'true' : 'false' ?>;

    /* ---------- pengingat ---------- */

    function durasi(menit) {
        if (menit < 60) return menit + " menit";
        const j = Math.floor(menit / 60), m = menit % 60;
        return j + " jam" + (m ? " " + m + " menit" : "");
    }

    function perbaruiPengingat() {

        const sekarang = Date.now();
        const selisih = JADWAL.masuk - sekarang;
        const menitLagi = Math.ceil(selisih / 60000);

        if (sudahPresensi || !JADWAL.kerja || sekarang > JADWAL.pulang || menitLagi > JADWAL.menitAwal) {
            pengingat.hidden = true;
            return;
        }

        if (selisih > 0) {
            pengingat.className = "ad-ingat hampir";
            $("teksPengingat").textContent =
                "Jam masuk (" + JADWAL.jamMasuk + ") tinggal " + durasi(menitLagi) + " lagi. Jangan lupa kirim presensi.";
        } else {
            const lewat = Math.floor(-selisih / 60000);
            pengingat.className = "ad-ingat telat";
            $("teksPengingat").textContent = lewat === 0
                ? "Sudah waktunya masuk kerja (" + JADWAL.jamMasuk + "). Kirim presensi sekarang."
                : "Anda belum presensi, sudah lewat " + durasi(lewat) + " dari jam masuk (" + JADWAL.jamMasuk + ").";
        }

        pengingat.hidden = false;

    }

    perbaruiPengingat();
    setInterval(perbaruiPengingat, 30000);

    $("btnPengingat").addEventListener("click", function () {
        if (!input.disabled) {
            if (berkas) { btnKirim.focus(); } else { input.click(); }
        }
    });

    /* ---------- foto ---------- */

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

        drop.hidden = true;
        preview.hidden = false;

    }

    input.addEventListener("change", function () {
        pilih(input.files[0]);
    });

    /* seret & lepas */
    ["dragenter", "dragover"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); if (!input.disabled) drop.classList.add("seret"); });
    });
    ["dragleave", "drop"].forEach(function (n) {
        drop.addEventListener(n, function (e) { e.preventDefault(); drop.classList.remove("seret"); });
    });
    drop.addEventListener("drop", function (e) {
        if (!input.disabled && e.dataTransfer.files.length) pilih(e.dataTransfer.files[0]);
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

        /* demo: nanti kirim berkas ke server (FormData + fetch) dan simpan ke ../uploads/presensi/
           server mencatat status 'masuk' + waktu_dicatat di tabel kehadiran */
        const sekarang = new Date();
        const jam = dua(sekarang.getHours()) + ":" + dua(sekarang.getMinutes());

        sudahPresensi = true;
        perbaruiPengingat();

        $("pilPresensi").textContent = "Aktif";
        $("pilPresensi").className = "ad-pil ok";
        $("teksStatus").textContent = "Aktif · terkirim " + jam;

        btnKirim.disabled = true;
        btnGanti.hidden = true;
        tampilPesan("Presensi terkirim pukul " + jam + ". Status Anda sekarang Aktif.", "benar");

    });

})();


</script>

    <!-- Script Interaktivitas Global Admin & Ripple Wave -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>
