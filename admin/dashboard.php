<?php
/* =====================================================================
   RESERVIN — DASHBOARD ADMIN (admin/dashboard.php)
   Halaman beranda admin yang menyajikan ringkasan statistik harian,
   reservasi terbaru, grafik pendapatan mingguan, dan layanan terlaris.
   ===================================================================== */

$page_title   = 'Dashboard Salon';
$current_page = 'dashboard.php';

require_once __DIR__ . '/includes/init.php';

/* ===== DATA DASHBOARD (Nantinya diganti dari database) ===== */

$stat = [
    ['kalender', 'rose',   '12',          'Total Reservasi Hari Ini', '20% dari kemarin'],
    ['users',    'violet', '5',           'Total Pegawai',            '1 baru'],
    ['store',    'green',  '3',           'Total Salon',              '1 baru'],
    ['koin',     'blue',   'Rp2.450.000', 'Total Pendapatan Hari Ini', '15% dari kemarin'],
];

$hariIni = strtotime('today');

$reservasi = [
    ['Rina Putri',      'Facial',        '10:00', 'Dikonfirmasi'],
    ['Dewi Lestari',    'Hair Cut',      '11:30', 'Dikonfirmasi'],
    ['Sinta Ramadhani', 'Manicure',      '13:00', 'Menunggu'],
    ['Ayu Pratiwi',     'Massage',       '14:30', 'Dikonfirmasi'],
    ['Nadya Putri',     'Hair Coloring', '16:00', 'Menunggu'],
];

/* Pendapatan 7 hari terakhir, dalam juta rupiah (hari tertua -> hari ini) */
$pendapatan = [1.7, 2.1, 2.2, 2.1, 2.5, 2.9, 3.5];
$batasAtas  = 4; // skala sumbu y (juta)

$layananTerlaris = [
    ['Facial',    28, 'wajah'],
    ['Hair Cut',  22, 'gunting'],
    ['Creambath', 18, 'tetes'],
    ['Hair Spa',  15, 'kilau'],
];
$pesananMaks = max(array_column($layananTerlaris, 1));

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- SAMBUTAN -->
<section class="ad-sapa">
    <h1>Selamat datang, <?= e($admin['nama']) ?>!</h1>
    <p>Berikut ringkasan aktivitas salon Anda hari ini.</p>
</section>

<!-- KARTU STATISTIK -->
<section class="ad-stats">
    <?php foreach ($stat as $s): ?>
        <div class="ad-stat">
            <div class="ad-ic <?= e($s[1]) ?>"><?= ikon($s[0]) ?></div>
            <div class="nilai"><?= e($s[2]) ?></div>
            <div class="judul"><?= e($s[3]) ?></div>
            <div class="tren"><?= ikon('naik') ?> <?= e($s[4]) ?></div>
        </div>
    <?php endforeach; ?>
</section>

<!-- RESERVASI TERBARU + PENDAPATAN -->
<section class="ad-baris">

    <!-- Tabel Reservasi -->
    <div class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Reservasi Terbaru</h2>
            <a class="ad-semua" href="laporan.php">Lihat Semua <?= ikon('panah') ?></a>
        </div>

        <div class="ad-tabel-box">
            <table class="ad-tabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Layanan</th>
                        <th>Tanggal &amp; Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservasi as $i => $r): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= e($r[0]) ?></td>
                            <td><?= e($r[1]) ?></td>
                            <td><?= e(tglPendek($hariIni) . ' ' . date('Y', $hariIni) . ', ' . $r[2]) ?></td>
                            <td>
                                <span class="ad-pil <?= $r[3] === 'Dikonfirmasi' ? 'ok' : 'tunggu' ?>"><?= e($r[3]) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
                        
    <!-- Grafik Pendapatan 7 Hari -->
    <div class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Pendapatan 7 Hari Terakhir</h2>
        </div>

        <div class="ad-plot">
            <?php for ($t = $batasAtas; $t >= 0; $t--): ?>
                <div class="ad-garis" style="top:<?= (($batasAtas - $t) / $batasAtas) * 100 ?>%">
                    <span><?= $t === 0 ? '0' : $t . ' jt' ?></span>
                </div>
            <?php endfor; ?>

            <div class="ad-batang">
                <?php foreach ($pendapatan as $v): ?>
                    <div
                        class="ad-bar"
                        style="height:<?= min(100, ($v / $batasAtas) * 100) ?>%"
                        title="Rp<?= e(number_format($v, 1, ',', '.')) ?> jt">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="ad-sumbu-x">
            <?php for ($d = 6; $d >= 0; $d--): ?>
                <span><?= e(tglPendek(strtotime("-$d day", $hariIni))) ?></span>
            <?php endfor; ?>
        </div>
    </div>

</section>

<!-- LAYANAN TERLARIS -->
<section class="ad-kartu ad-terlaris">
    <div class="ad-kartu-head">
        <h2>Layanan Paling Banyak Dipesan</h2>
        <a class="ad-semua" href="layanan.php">Lihat Semua <?= ikon('panah') ?></a>
    </div>

    <div class="ad-terlaris-grid">
        <?php foreach ($layananTerlaris as $l): ?>
            <div class="ad-ter">
                <div class="ad-ic"><?= ikon($l[2]) ?></div>
                <div class="ad-ter-info">
                    <b><?= e($l[0]) ?></b>
                    <small><?= (int)$l[1] ?> pesanan</small>
                </div>
                <div class="ad-prog" role="img" aria-label="<?= (int)$l[1] ?> dari <?= (int)$pesananMaks ?> pesanan tertinggi">
                    <i style="width:<?= round(($l[1] / $pesananMaks) * 100) ?>%"></i>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<section class="ad-sapa">
    <h1>Data user</h1>
    <p>Login</p>
</section>

<form id="Formlogin" onsubmit="return simpan(event)">

    <!-- INFORMASI DASAR SALON -->
    <section class="ad-kartu">
        <div class="ad-kartu-head">
            <h2>Login</h2>
        </div>

        <div class="ad-form-grid">
            <div class="ad-field">
                <label for="nama">Username</label>
                <input type="text" id="nama" name="nama" value=" ">
            </div>

            <div class="ad-field">
                <label for="telepon">password</label>
                <input type="text" id="telepon" name="telepon" value=" ">
            </div>

            <div class="ad-field full">
                <label for="alamat">nik</label>
                <textarea id="alamat" name="alamat"></textarea>
            </div>

            <div class="ad-field full">
                <label for="deskripsi">Alamat & Sosmed</label>
                <textarea id="deskripsi" name="deskripsi"></textarea>
            </div>
        </div>
    </section>
        <div class="ad-aksi">
            <button type="submit" class="ad-btn utama">Simpan Perubahan</button>
            <button type="button" class="ad-btn kedua" onclick="kembali()">Kembali</button>
        </div>
    </section>

</form>
<?php 
// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php'; 
?>
