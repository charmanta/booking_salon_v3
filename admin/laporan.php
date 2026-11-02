<?php
/* =====================================================================
   RESERVIN — LAPORAN & TRANSAKSI ADMIN (admin/laporan.php)
   Halaman laporan aktivitas salon:
   - Filter periode bulan dan tahun
   - Ringkasan omset & statistik booking
   - Grafik tren penghasilan 6 bulan terakhir
   - Rincian transaksi berdasarkan hari, layanan, pegawai, dan semua
   - Modal invoice & cetak dokumen
   ===================================================================== */

$page_title   = 'Laporan Salon';
$current_page = 'laporan.php';

require_once __DIR__ . '/includes/init.php';

$sekarang = time();
$salon    = ['nama' => 'Luna Salon', 'kota' => 'Bandung'];

$namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

/* Layanan: kode => [nama, harga] */
$layanan = [
    'creambath' => ['Creambath',     100000],
    'hairspa'   => ['Hair Spa',      150000],
    'potong'    => ['Potong Rambut',  50000],
    'coloring'  => ['Hair Coloring', 250000],
];

/* Pegawai: id => nama, keahlian, layanan yang bisa dikerjakan */
$pegawai = [
    'p1' => ['nama' => 'Dewi Lestari',   'keahlian' => 'Hair Stylist',    'bisa' => ['creambath', 'hairspa', 'potong']],
    'p2' => ['nama' => 'Andi Pratama',   'keahlian' => 'Barber',          'bisa' => ['potong']],
    'p3' => ['nama' => 'Maya Putri',     'keahlian' => 'Facial & Beauty', 'bisa' => ['creambath', 'hairspa']],
    'p4' => ['nama' => 'Rani Salsabila', 'keahlian' => 'Hair Coloring',   'bisa' => ['coloring']],
];

/* Generator data contoh transaksi (dapat diganti query database nanti) */
$seed = 20261031;
function acak($maks) {
    global $seed;
    $seed = ($seed * 48271) % 2147483647;
    return ($seed >> 4) % $maks;
}

$poolNama    = ['Rina Anggraini', 'Budi Santoso', 'Sari Wulandari', 'Tika Maharani', 'Nadia Putri', 'Agus Setiawan', 'Lina Marlina', 'Fitri Handayani', 'Yoga Permana', 'Citra Dewanti'];
$layananKode = array_keys($layanan);

$bookings = [];
$no = 1;
foreach ([[2026, 6], [2026, 7], [2026, 8], [2026, 9], [2026, 10], [2026, 11]] as $bt) {
    $th   = $bt[0];
    $bl   = $bt[1];
    $jml  = 9 + acak(6);
    $hariList = [];
    for ($i = 0; $i < $jml; $i++) { 
        $hariList[] = 1 + acak(28); 
    }
    sort($hariList);

    foreach ($hariList as $d) {
        $pemesan = $poolNama[acak(count($poolNama))];
        $banyak  = acak(3) === 0 ? 2 : 1;
        $jam     = 9 + acak(10);
        $orang   = [];

        for ($k = 0; $k < $banyak; $k++) {
            $lk   = $layananKode[acak(count($layananKode))];
            $pool = [];
            foreach ($pegawai as $pid => $pg) { 
                if (in_array($lk, $pg['bisa'], true)) $pool[] = $pid; 
            }
            $pid  = $pool[acak(count($pool))];
            $nama = $k === 0 ? $pemesan : $poolNama[acak(count($poolNama))] . ' (Teman)';
            $orang[] = [
                'nama'    => $nama,
                'layanan' => $lk,
                'pegawai' => $pid,
                'ts'      => mktime($jam + $k, 0, 0, $bl, $d, $th),
                'harga'   => $layanan[$lk][1],
            ];
        }

        $awal   = $orang[0]['ts'];
        $dibuat = $awal - (1 + acak(5)) * 86400 - acak(8) * 3600;
        $batal  = acak(12) === 0;

        if ($awal < $sekarang) {
            $bayar = acak(15) === 0 ? 'menunggu' : 'lunas';
        } else {
            $bayar = acak(3) === 0 ? 'menunggu' : 'lunas';
        }

        $bookings[] = [
            'kode'    => 'RSV-' . str_pad($no++, 3, '0', STR_PAD_LEFT),
            'pemesan' => $pemesan,
            'dibuat'  => $dibuat,
            'bayar'   => $bayar,
            'batal'   => $batal,
            'orang'   => $orang,
        ];
    }
}

/* ===== Filter Bulan & Tahun ===== */
$bulanDipilih = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('n');
$tahunDipilih = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
if ($bulanDipilih < 1 || $bulanDipilih > 12) $bulanDipilih = (int)date('n');
if (!in_array($tahunDipilih, [2025, 2026, 2027], true)) $tahunDipilih = (int)date('Y');

$labelPeriode = $namaBulan[$bulanDipilih - 1] . ' ' . $tahunDipilih;
$namaStatus   = ['akan' => 'Akan datang', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];

$items           = []; // satu baris = satu orang / satu layanan
$dataInvoice     = [];
$bookingBulanIni = 0;

foreach ($bookings as $b) {
    $awal  = $b['orang'][0]['ts'];
    $akhir = $b['orang'][count($b['orang']) - 1]['ts'];

    if ((int)date('n', $awal) !== $bulanDipilih || (int)date('Y', $awal) !== $tahunDipilih) continue;

    if ($b['batal'])            $status = 'dibatalkan';
    elseif ($akhir < $sekarang) $status = 'selesai';
    else                        $status = 'akan';

    if (!$b['batal']) $bookingBulanIni++;

    $total   = 0;
    $rincian = [];

    foreach ($b['orang'] as $o) {
        $namaPegawai = $pegawai[$o['pegawai']]['nama'];
        $total += $o['harga'];

        $items[] = [
            'kode'    => $b['kode'],
            'pemesan' => $b['pemesan'],
            'ts'      => $o['ts'],
            'nama'    => $o['nama'],
            'lk'      => $o['layanan'],
            'layanan' => $layanan[$o['layanan']][0],
            'pid'     => $o['pegawai'],
            'pegawai' => $namaPegawai,
            'harga'   => $o['harga'],
            'bayar'   => $b['bayar'],
            'batal'   => $b['batal'],
            'status'  => $status,
        ];

        $rincian[] = [
            'nama'    => $o['nama'],
            'layanan' => $layanan[$o['layanan']][0],
            'pegawai' => $namaPegawai,
            'waktu'   => tgl($o['ts']),
            'harga'   => rupiah($o['harga']),
        ];
    }

    $dataInvoice[$b['kode']] = [
        'kode'    => $b['kode'],
        'pemesan' => $b['pemesan'],
        'salon'   => $salon['nama'],
        'kota'    => $salon['kota'],
        'dibuat'  => tgl($b['dibuat']),
        'status'  => $namaStatus[$status],
        'bayar'   => $b['batal'] ? 'batal' : $b['bayar'],
        'items'   => $rincian,
        'jumlah'  => count($b['orang']),
        'total'   => rupiah($total),
    ];
}

usort($items, function ($a, $b) { return $a['ts'] <=> $b['ts']; });

/* ===== Hitung Ringkasan Statistik ===== */
function hitungGrup($its) {
    $jml = 0; $total = 0; $kodeSet = [];
    foreach ($its as $i) {
        if ($i['batal']) continue;
        $jml++;
        $kodeSet[$i['kode']] = true;
        if ($i['bayar'] === 'lunas') $total += $i['harga'];
    }
    return ['jumlah' => $jml, 'booking' => count($kodeSet), 'total' => $total];
}

$totalPenghasilan = 0;
$totalMenunggu    = 0;
$perLayananJumlah = array_fill_keys($layananKode, 0);

foreach ($items as $i) {
    if ($i['batal']) continue;
    if ($i['bayar'] === 'lunas') $totalPenghasilan += $i['harga'];
    else                         $totalMenunggu    += $i['harga'];
    $perLayananJumlah[$i['lk']]++;
}

$lkTerlaris = $layananKode[0];
foreach ($perLayananJumlah as $k => $n) { 
    if ($n > $perLayananJumlah[$lkTerlaris]) $lkTerlaris = $k; 
}
$adaData = count($items) > 0;

/* Grafik 6 bulan terakhir */
$grafik = [];
$bulanSingkat = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
for ($m = 5; $m >= 0; $m--) {
    $t   = mktime(0, 0, 0, $bulanDipilih - $m, 1, $tahunDipilih);
    $bn  = (int)date('n', $t);
    $th  = (int)date('Y', $t);
    $sum = 0;
    foreach ($bookings as $b) {
        if ($b['batal'] || $b['bayar'] !== 'lunas') continue;
        $aw = $b['orang'][0]['ts'];
        if ((int)date('n', $aw) !== $bn || (int)date('Y', $aw) !== $th) continue;
        foreach ($b['orang'] as $o) { $sum += $o['harga']; }
    }
    $grafik[] = [$bulanSingkat[$bn], $sum / 1000000];
}
$skala = 0.5;
foreach ($grafik as $g) { if ($g[1] > $skala) $skala = $g[1]; }

/* Pengelompokan Data */
$grupHarian = [];
foreach ($items as $i) { $grupHarian[date('Y-m-d', $i['ts'])][] = $i; }
ksort($grupHarian);

$grupLayanan = [];
foreach ($layanan as $k => $l) { $grupLayanan[$k] = []; }
foreach ($items as $i) { $grupLayanan[$i['lk']][] = $i; }

$grupPegawai = [];
foreach ($pegawai as $pid => $p) { $grupPegawai[$pid] = []; }
foreach ($items as $i) { $grupPegawai[$i['pid']][] = $i; }
uksort($grupPegawai, function ($a, $b) use ($grupPegawai) {
    return hitungGrup($grupPegawai[$b])['total'] <=> hitungGrup($grupPegawai[$a])['total'];
});

/* Helper HTML Builder */
function badgeBayar($it) {
    if ($it['batal']) return '<span class="bd batal">Dibatalkan</span>';
    return $it['bayar'] === 'lunas'
        ? '<span class="bd lunas">Lunas</span>'
        : '<span class="bd tunggu">Menunggu</span>';
}

function tabelItem(array $its) {
    if (!$its) return '<div class="ad-kosong-grup">Belum ada transaksi.</div>';

    $h  = '<div class="ad-tabel-box"><table class="ad-tabel"><thead><tr>';
    $h .= '<th>Waktu</th><th>Kode</th><th>Pelanggan</th><th>Layanan</th><th>Pegawai</th><th class="kanan">Harga</th><th>Pembayaran</th><th></th>';
    $h .= '</tr></thead><tbody>';

    foreach ($its as $i) {
        $h .= '<tr class="ad-row' . ($i['batal'] ? ' dibatal' : '') . '">';
        $h .= '<td>' . e(tgl($i['ts'])) . '</td>';
        $h .= '<td class="tebal">' . e($i['kode']) . '</td>';
        $h .= '<td>' . e($i['nama']) . '</td>';
        $h .= '<td>' . e($i['layanan']) . '</td>';
        $h .= '<td>' . e($i['pegawai']) . '</td>';
        $h .= '<td class="kanan tebal">' . e(rupiah($i['harga'])) . '</td>';
        $h .= '<td>' . badgeBayar($i) . '</td>';
        $h .= '<td class="kanan"><button type="button" class="ad-mini" data-invoice="' . e($i['kode']) . '">Invoice</button></td>';
        $h .= '</tr>';
    }

    return $h . '</tbody></table></div>';
}

function grupHtml($judulHtml, $metaTeks, array $its, $tambahan = '') {
    $s  = hitungGrup($its);
    $h  = '<details class="ad-grup">';
    $h .= '<summary>';
    $h .= '<span class="g-nama">' . $judulHtml . '</span>';
    $h .= '<span class="g-meta">' . e($metaTeks !== '' ? $metaTeks : $s['jumlah'] . ' layanan · ' . $s['booking'] . ' booking') . '</span>';
    $h .= '<span class="g-total">' . e(rupiah($s['total'])) . '</span>';
    $h .= '<span class="g-chev">' . ikon('turun') . '</span>';
    $h .= '</summary>';
    $h .= $tambahan;
    $h .= tabelItem($its);
    $h .= '</details>';
    return $h;
}

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- KEPALA HALAMAN & FILTER BULAN/TAHUN -->
<div class="ad-sapa-baris">
    <section class="ad-sapa">
        <h1>Laporan Salon</h1>
        <p>Pantau penghasilan, transaksi, dan aktivitas salon.</p>
    </section>

    <!-- FORM FILTER -->
    <form class="ad-filter" method="get">
        <div class="ad-field">
            <label for="bulan">Bulan</label>
            <select id="bulan" name="bulan">
                <?php foreach ($namaBulan as $i => $b): ?>
                    <option value="<?= $i + 1 ?>"<?= ($i + 1) === $bulanDipilih ? ' selected' : '' ?>><?= e($b) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="ad-field">
            <label for="tahun">Tahun</label>
            <select id="tahun" name="tahun">
                <?php foreach ([2027, 2026, 2025] as $th): ?>
                    <option value="<?= $th ?>"<?= $th === $tahunDipilih ? ' selected' : '' ?>><?= $th ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="ad-btn">Tampilkan</button>
    </form>
</div>

<!-- KARTU STATISTIK RINGKASAN -->
<section class="ad-stats">
    <div class="ad-stat">
        <div class="ad-ic rose"><?= ikon('koin') ?></div>
        <div class="judul">Total Penghasilan</div>
        <div class="nilai"><?= e(rupiah($totalPenghasilan)) ?></div>
        <div class="info"><?= e($labelPeriode) ?> · sudah lunas</div>
    </div>

    <div class="ad-stat">
        <div class="ad-ic amber"><?= ikon('jam') ?></div>
        <div class="judul">Menunggu Verifikasi</div>
        <div class="nilai"><?= e(rupiah($totalMenunggu)) ?></div>
        <div class="info">Belum dihitung sebagai penghasilan</div>
    </div>

    <div class="ad-stat">
        <div class="ad-ic green"><?= ikon('kalender') ?></div>
        <div class="judul">Total Booking</div>
        <div class="nilai"><?= (int)$bookingBulanIni ?></div>
        <div class="info"><?= e($labelPeriode) ?> · tanpa yang dibatalkan</div>
    </div>

    <div class="ad-stat">
        <div class="ad-ic violet"><?= ikon('kilau') ?></div>
        <div class="judul">Layanan Terlaris</div>
        <div class="nilai"><?= $adaData ? e($layanan[$lkTerlaris][0]) : '-' ?></div>
        <div class="info"><?= (int)$perLayananJumlah[$lkTerlaris] ?> layanan dikerjakan</div>
    </div>
</section>

<!-- GRAFIK PENGHASILAN BULANAN -->
<section class="ad-kartu">
    <div class="ad-kartu-head">
        <h2>Penghasilan Bulanan</h2>
        <span class="ad-lencana">6 bulan terakhir</span>
    </div>
    <p class="ad-sub">Perbandingan penghasilan salon (yang sudah lunas) setiap bulan.</p>

    <div class="ad-grafik">
        <?php foreach ($grafik as $i => $g): ?>
            <div class="ad-kol<?= $i === count($grafik) - 1 ? ' sekarang' : '' ?>">
                <div class="nilai-bar"><?= e(jt($g[1])) ?></div>
                <div class="ad-area">
                    <div class="ad-bar" style="height:<?= max(2, min(100, round(($g[1] / $skala) * 100))) ?>%" title="<?= e(jt($g[1])) ?>"></div>
                </div>
                <div class="bln"><?= e($g[0]) ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- DETAIL TRANSAKSI & TABEL -->
<section class="ad-kartu">
    <div class="ad-kartu-head">
        <h2>Detail Transaksi</h2>
        <span class="ad-lencana"><?= e($labelPeriode) ?></span>
    </div>
    <p class="ad-sub">Lihat transaksi berdasarkan hari, layanan, atau pegawai. Klik tombol Invoice untuk membuka detail transaksi.</p>

    <?php if (!$adaData): ?>
        <div class="ad-kosong">Belum ada transaksi pada <?= e($labelPeriode) ?>.</div>
    <?php else: ?>

        <div class="ad-tabs" id="tabs" role="tablist">
            <button type="button" class="ad-tab active" data-panel="harian" role="tab">Harian</button>
            <button type="button" class="ad-tab" data-panel="layanan" role="tab">Per Layanan</button>
            <button type="button" class="ad-tab" data-panel="pegawai" role="tab">Per Pegawai</button>
            <button type="button" class="ad-tab" data-panel="semua" role="tab">Semua Transaksi</button>
        </div>

        <div class="ad-alat">
            <input type="search" class="ad-cari" id="cari" placeholder="Cari kode, pelanggan, layanan, atau pegawai…" aria-label="Cari transaksi">
            <button type="button" class="ad-btn garis" id="bukaSemua">Buka semua</button>
            <button type="button" class="ad-btn garis" id="tutupSemua">Tutup semua</button>
        </div>

        <!-- PANEL HARIAN -->
        <div class="ad-panel active" id="panel-harian">
            <?php foreach ($grupHarian as $tanggal => $its): ?>
                <?php
                $tsHari = strtotime($tanggal);
                $judul = e(tglHari($tsHari));
                if (date('Y-m-d', $sekarang) === $tanggal) $judul .= '<span class="ad-juara">Hari ini</span>';
                echo grupHtml($judul, '', $its);
                ?>
            <?php endforeach; ?>
        </div>

        <!-- PANEL PER LAYANAN -->
        <div class="ad-panel" id="panel-layanan">
            <?php foreach ($grupLayanan as $lk => $its): ?>
                <?php
                $judul = e($layanan[$lk][0]) . ' <span style="font-weight:400;color:#6b6470">· ' . e(rupiah($layanan[$lk][1])) . '</span>';
                $perPeg = [];
                foreach ($its as $i) { 
                    if (!$i['batal']) $perPeg[$i['pegawai']] = ($perPeg[$i['pegawai']] ?? 0) + 1; 
                }
                arsort($perPeg);
                $ringkas = '';
                if ($perPeg) {
                    $ringkas = '<div class="ad-ringkas"><i>Dikerjakan oleh:</i>';
                    foreach ($perPeg as $nm => $n) { 
                        $ringkas .= '<span>' . e($nm) . ' ×' . (int)$n . '</span>'; 
                    }
                    $ringkas .= '</div>';
                }
                echo grupHtml($judul, '', $its, $ringkas);
                ?>
            <?php endforeach; ?>

            <?php $tl = hitungGrup($items); ?>
            <div class="ad-jumlah"><span>Total (<?= (int)$tl['jumlah'] ?> layanan)</span><span><?= e(rupiah($tl['total'])) ?></span></div>
        </div>

        <!-- PANEL PER PEGAWAI -->
        <div class="ad-panel" id="panel-pegawai">
            <?php $urut = 0; foreach ($grupPegawai as $pid => $its): ?>
                <?php
                $p = $pegawai[$pid];
                $s = hitungGrup($its);

                $judul  = '<span class="ad-org"><span class="ad-ava">' . e(inisial($p['nama'])) . '</span><span><b>' . e($p['nama']) . '</b>';
                if ($urut === 0 && $s['total'] > 0) $judul .= '<span class="ad-juara">Tertinggi</span>';
                $judul .= '<small>' . e($p['keahlian']) . '</small></span></span>';

                $perLay = [];
                foreach ($its as $i) { 
                    if (!$i['batal']) $perLay[$i['layanan']] = ($perLay[$i['layanan']] ?? 0) + 1; 
                }
                $ringkas = '';
                if ($perLay) {
                    $ringkas = '<div class="ad-ringkas"><i>Layanan:</i>';
                    foreach ($perLay as $nm => $n) { 
                        $ringkas .= '<span>' . e($nm) . ' ×' . (int)$n . '</span>'; 
                    }
                    $persen = $totalPenghasilan > 0 ? round($s['total'] / $totalPenghasilan * 100) : 0;
                    $ringkas .= '<span><i>Kontribusi:</i> ' . (int)$persen . '%</span></div>';
                }

                echo grupHtml($judul, '', $its, $ringkas);
                $urut++;
                ?>
            <?php endforeach; ?>

            <div class="ad-jumlah"><span>Total (<?= (int)$tl['jumlah'] ?> layanan)</span><span><?= e(rupiah($tl['total'])) ?></span></div>
        </div>

        <!-- PANEL SEMUA TRANSAKSI -->
        <div class="ad-panel" id="panel-semua">
            <div class="ad-grup" style="padding:4px 8px 8px">
                <?= tabelItem($items) ?>
            </div>
            <div class="ad-jumlah"><span>Total (<?= (int)$tl['jumlah'] ?> layanan)</span><span><?= e(rupiah($tl['total'])) ?></span></div>
        </div>

        <div class="ad-kosong" id="kosongCari" style="display:none;margin-top:12px">Tidak ada transaksi yang cocok dengan pencarian.</div>

        <p class="ad-catatan">Total penghasilan hanya menghitung transaksi berstatus lunas. Transaksi yang dibatalkan tetap ditampilkan (dicoret) tetapi tidak dihitung.</p>

    <?php endif; ?>
</section>

<!-- MODAL INVOICE -->
<?php require __DIR__ . '/modals/modal_invoice.php'; ?>

<?php
// Script khusus halaman laporan (tabs, invoice modal, live search filter)
$extra_js = '
<script>
/* Data invoice untuk pop-up */
const INVOICE = ' . json_encode($dataInvoice, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';

function buatEl(tag, kelas, teks) {
    const x = document.createElement(tag);
    if (kelas) x.className = kelas;
    if (teks !== undefined) x.textContent = teks;
    return x;
}

function bukaInvoice(kode) {
    const d = INVOICE[kode];
    if (!d) return;

    const box = document.getElementById("invoiceIsi");
    box.innerHTML = "";

    const head = buatEl("div", "iv-head");
    head.appendChild(buatEl("div", "iv-brand", "RESERVIN"));

    const judul = buatEl("div", "iv-judul");
    judul.appendChild(buatEl("b", "", "INVOICE"));
    judul.appendChild(buatEl("span", "", "INV-" + d.kode));
    head.appendChild(judul);
    box.appendChild(head);

    const meta = buatEl("div", "iv-meta");
    function baris(label, nilai, badge) {
        const w = buatEl("div");
        w.appendChild(buatEl("small", "", label));
        if (badge) {
            w.appendChild(buatEl("span", "bd " + badge, nilai));
        } else {
            w.appendChild(document.createTextNode(nilai));
        }
        meta.appendChild(w);
    }

    baris("Kode booking", d.kode);
    baris("Tanggal booking", d.dibuat);
    baris("Pemesan", d.pemesan);
    baris("Salon", d.salon + " · " + d.kota);
    baris("Status booking", d.status);

    if (d.bayar === "lunas")       baris("Status pembayaran", "Lunas", "lunas");
    else if (d.bayar === "batal")  baris("Status pembayaran", "Dibatalkan", "batal");
    else                           baris("Status pembayaran", "Menunggu verifikasi", "tunggu");

    baris("Metode pembayaran", "Transfer bank (bayar penuh)");
    box.appendChild(meta);

    box.appendChild(buatEl("div", "iv-judul-bagian", "Rincian layanan"));

    d.items.forEach(function (it) {
        const row = buatEl("div", "iv-item");
        const kiri = buatEl("div");
        kiri.appendChild(buatEl("div", "nm", it.nama));
        kiri.appendChild(buatEl("div", "sub", it.layanan + " · dilayani " + it.pegawai));
        kiri.appendChild(buatEl("div", "sub", it.waktu));
        row.appendChild(kiri);
        row.appendChild(buatEl("div", "hg", it.harga));
        box.appendChild(row);
    });

    const tot = buatEl("div", "iv-total");
    tot.appendChild(buatEl("span", "", "Total" + (d.jumlah > 1 ? " (" + d.jumlah + " orang)" : "")));
    tot.appendChild(buatEl("b", "", d.total));
    box.appendChild(tot);

    box.appendChild(buatEl("div", "iv-catatan", "Invoice ini dibuat otomatis oleh sistem Reservin."));

    const aksi = buatEl("div", "iv-aksi");
    const cetak = buatEl("button", "iv-btn", "Cetak / simpan PDF");
    cetak.type = "button";
    cetak.onclick = function () { window.print(); };
    aksi.appendChild(cetak);

    const tutup = buatEl("button", "iv-btn utama", "Tutup");
    tutup.type = "button";
    tutup.onclick = tutupInvoice;
    aksi.appendChild(tutup);

    box.appendChild(aksi);
    document.getElementById("invoiceModal").classList.add("show");
}

function tutupInvoice() {
    document.getElementById("invoiceModal").classList.remove("show");
}

document.getElementById("invoiceModal").addEventListener("click", function (e) {
    if (e.target === this) tutupInvoice();
});

document.addEventListener("click", function (e) {
    const tombol = e.target.closest("[data-invoice]");
    if (tombol) bukaInvoice(tombol.dataset.invoice);
});

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") tutupInvoice();
});

/* Tab & Live Filter */
(function () {
    const tabs = document.querySelectorAll(".ad-tab");
    if (!tabs.length) return;

    function panelAktif() {
        return document.querySelector(".ad-panel.active");
    }

    function pilihTab(nama) {
        tabs.forEach(function (t) { t.classList.toggle("active", t.dataset.panel === nama); });
        document.querySelectorAll(".ad-panel").forEach(function (p) {
            p.classList.toggle("active", p.id === "panel-" + nama);
        });
        try { history.replaceState(null, "", "#" + nama); } catch (e) {}
        saring();
    }

    tabs.forEach(function (t) {
        t.addEventListener("click", function () { pilihTab(t.dataset.panel); });
    });

    const btnBuka = document.getElementById("bukaSemua");
    const btnTutup = document.getElementById("tutupSemua");
    if (btnBuka) {
        btnBuka.addEventListener("click", function () {
            panelAktif().querySelectorAll("details").forEach(function (d) { d.open = true; });
        });
    }
    if (btnTutup) {
        btnTutup.addEventListener("click", function () {
            panelAktif().querySelectorAll("details").forEach(function (d) { d.open = false; });
        });
    }

    const cari = document.getElementById("cari");
    function saring() {
        if (!cari) return;
        const q = cari.value.trim().toLowerCase();
        const panel = panelAktif();
        let tampil = 0;

        panel.querySelectorAll(".ad-row").forEach(function (tr) {
            const cocok = q === "" || tr.textContent.toLowerCase().indexOf(q) !== -1;
            tr.style.display = cocok ? "" : "none";
            if (cocok) tampil++;
        });

        panel.querySelectorAll("details.ad-grup").forEach(function (d) {
            const ada = d.querySelectorAll(".ad-row").length > 0;
            const cocokBaris = Array.prototype.some.call(
                d.querySelectorAll(".ad-row"),
                function (tr) { return tr.style.display !== "none"; }
            );

            if (q === "") {
                d.style.display = "";
            } else if (ada) {
                d.style.display = cocokBaris ? "" : "none";
                if (cocokBaris) d.open = true;
            } else {
                d.style.display = "none";
            }
        });

        const elKosong = document.getElementById("kosongCari");
        if (elKosong) {
            elKosong.style.display = (q !== "" && tampil === 0) ? "block" : "none";
        }
    }

    if (cari) {
        cari.addEventListener("input", saring);
    }

    const awal = (location.hash || "").replace("#", "");
    if (["harian", "layanan", "pegawai", "semua"].indexOf(awal) !== -1) pilihTab(awal);
})();
</script>
';

// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php';
?>
