<?php
/* =====================================================================
   RESERVIN — JADWAL PEGAWAI ADMIN (admin/jadwal.php)
   Halaman tampilan matriks jadwal kerja mingguan pegawai (Senin–Minggu)
   dan modal untuk mengatur hari dan jam kerja tiap staf.
   ===================================================================== */

$page_title   = 'Jadwal Pegawai';
$current_page = 'jadwal.php';

require_once __DIR__ . '/includes/init.php';

/* nomor hari: 1 = Senin ... 7 = Minggu */
$namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
$bulan    = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
$hariIni  = (int)date('N');

/*
 * [nama, keahlian, hari kerja, jam masuk, jam pulang, status kehadiran hari ini, waktu dicatat]
 */
$pegawai = [
    ['Dewi Lestari',   'Hair Stylist',    [1, 2, 3, 4, 5, 6], '09:00', '17:00', 'masuk',       '08:42'],
    ['Andi Pratama',   'Barber',          [1, 2, 3, 4, 5, 6], '10:00', '18:00', 'masuk',       '09:51'],
    ['Maya Putri',     'Facial & Beauty', [2, 3, 4, 5, 6, 7], '09:00', '17:00', 'masuk',       '08:55'],
    ['Rani Salsabila', 'Hair Coloring',   [1, 3, 5, 6],       '11:00', '20:00', 'tidak_masuk', '07:30'],
];

/* Tanggal tiap hari pada pekan ini */
$senin = strtotime('monday this week');
$tgl   = [];
foreach ($namaHari as $no => $h) {
    $t = strtotime('+' . ($no - 1) . ' day', $senin);
    $tgl[$no] = date('j', $t) . ' ' . $bulan[(int)date('n', $t)];
}
$minggu  = strtotime('+6 day', $senin);
$rentang = date('j', $senin) . ' ' . $bulan[(int)date('n', $senin)] . ' – ' . date('j', $minggu) . ' ' . $bulan[(int)date('n', $minggu)] . ' ' . date('Y', $minggu);

/* Jumlah pegawai bertugas per hari */
$jumlah = array_fill(1, 7, 0);
foreach ($pegawai as $p) {
    foreach ($p[2] as $h) { 
        $jumlah[$h]++; 
    }
}

/* Total jam kerja per pekan */
function totalJam($p) {
    $menit = (strtotime($p[4]) - strtotime($p[3])) / 60;
    $jam   = count($p[2]) * $menit / 60;
    return rtrim(rtrim(number_format($jam, 1, ',', ''), '0'), ',');
}

/* Data jadwal untuk pop-up modal (dibaca JavaScript) */
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

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- KEPALA HALAMAN & TOMBOL ATUR JADWAL -->
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

<!-- MODAL ATUR / UBAH JADWAL -->
<?php require __DIR__ . '/modals/modal_jadwal.php'; ?>

<?php
// Script khusus halaman jadwal
$extra_js = '
<script>
const $ = function (id) { return document.getElementById(id); };

/* data jadwal tiap pegawai (dari PHP) */
const DATA = ' . json_encode($dataJs, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) . ';

(function () {
    const modal = $("modal");

    function setHari(daftar) {
        document.querySelectorAll(\'input[name="hari"]\').forEach(function (c) {
            c.checked = daftar.indexOf(c.value) !== -1;
        });
    }

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

    $("j_pegawai").addEventListener("change", function () {
        isiForm(this.value);
    });

    $("btnSimpan").addEventListener("click", function () {
        const idx = $("j_pegawai").value;

        if (idx === "") { alert("Pilih pegawai terlebih dahulu."); $("j_pegawai").focus(); return; }

        if (document.querySelectorAll(\'input[name="hari"]:checked\').length === 0) {
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
</script>
';

// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php';
?>
