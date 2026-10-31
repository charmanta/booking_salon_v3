<?php
date_default_timezone_set('Asia/Jakarta');

$sekarang = time();
$hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
$bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rupiah($n) { return 'Rp' . number_format((int)$n, 0, ',', '.'); }
function jt($v) { return 'Rp' . str_replace('.', ',', rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.')) . ' jt'; }
function tgl($ts) {
    global $hari, $bulan;
    return $hari[(int)date('w', $ts)] . ', ' . date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts) . ' · ' . date('H.i', $ts);
}
function tglHari($ts) {
    global $hari, $bulan;
    return $hari[(int)date('w', $ts)] . ', ' . date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

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
        'koin'     => '<circle cx="12" cy="12" r="9"/><path d="M14.500 9.200c-.5-.8-1.400-1.200-2.500-1.200-1.400 0-2.500.7-2.500 1.800s1 1.500 2.500 1.900 2.500.8 2.500 1.900S13.400 16 12 16c-1.100 0-2-.4-2.500-1.200"/><path d="M12 6v2M12 16v2"/>',
        'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
        'kilau'    => '<path d="M12 3l1.800 5.200L19 10l-5.200 1.800L12 17l-1.800-5.200L5 10l5.200-1.800z"/><path d="M19 17l.7 1.800 1.800.7-1.800.7L19 22l-.7-1.800-1.800-.7 1.800-.7z"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function inisial($nama) {
    $k = preg_split('/\s+/', trim($nama));
    $i = mb_strtoupper(mb_substr($k[0], 0, 1));
    if (count($k) > 1) $i .= mb_strtoupper(mb_substr($k[count($k) - 1], 0, 1));
    return $i;
}

/* ===== Data master (nanti ganti dengan data dari database) ===== */

$admin = ['nama' => 'Siti Amelia', 'peran' => 'Pemilik Salon', 'inisial' => 'SA'];
$salon = ['nama' => 'Luna Salon', 'kota' => 'Bandung'];

$menu = [
    ['dashboard.php', 'Dashboard',  'home',    false],
    ['salon.php',     'Data Salon', 'store',   false],
    ['layanan.php',   'Layanan',    'gunting', false],
    ['pegawai.php',   'Pegawai',    'users',   false],
    ['laporan_baru.php',   'Laporan',    'laporan', true],
    ['profil.php',    'Profil',     'user',    false],
];

$namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

/* layanan: kode => [nama, harga] */
$layanan = [
    'creambath' => ['Creambath',     100000],
    'hairspa'   => ['Hair Spa',      150000],
    'potong'    => ['Potong Rambut',  50000],
    'coloring'  => ['Hair Coloring', 250000],
];

/* pegawai: id => nama, keahlian, layanan yang bisa dikerjakan */
$pegawai = [
    'p1' => ['nama' => 'Dewi Lestari',   'keahlian' => 'Hair Stylist',    'bisa' => ['creambath', 'hairspa', 'potong']],
    'p2' => ['nama' => 'Andi Pratama',   'keahlian' => 'Barber',          'bisa' => ['potong']],
    'p3' => ['nama' => 'Maya Putri',     'keahlian' => 'Facial & Beauty', 'bisa' => ['creambath', 'hairspa']],
    'p4' => ['nama' => 'Rani Salsabila', 'keahlian' => 'Hair Coloring',   'bisa' => ['coloring']],
];

/*
 * Data booking contoh (dibuat otomatis, nanti ganti dengan query database).
 * Setiap booking: kode, pemesan, dibuat (timestamp), bayar ('menunggu'|'lunas'),
 * batal (bool), orang[] = [nama, layanan(kode), pegawai(id), ts, harga]
 */
$seed = 20261031;
function acak($maks) {
    global $seed;
    $seed = ($seed * 48271) % 2147483647;
    return ($seed >> 4) % $maks;
}

$poolNama = ['Rina Anggraini', 'Budi Santoso', 'Sari Wulandari', 'Tika Maharani', 'Nadia Putri', 'Agus Setiawan', 'Lina Marlina', 'Fitri Handayani', 'Yoga Permana', 'Citra Dewanti'];
$layananKode = array_keys($layanan);

$bookings = [];
$no = 1;
foreach ([[2026, 6], [2026, 7], [2026, 8], [2026, 9], [2026, 10], [2026, 11]] as $bt) {
    $th = $bt[0];
    $bl = $bt[1];
    $jml = 9 + acak(6);
    $hariList = [];
    for ($i = 0; $i < $jml; $i++) { $hariList[] = 1 + acak(28); }
    sort($hariList);

    foreach ($hariList as $d) {
        $pemesan = $poolNama[acak(count($poolNama))];
        $banyak  = acak(3) === 0 ? 2 : 1;
        $jam     = 9 + acak(10);
        $orang   = [];

        for ($k = 0; $k < $banyak; $k++) {
            $lk   = $layananKode[acak(count($layananKode))];
            $pool = [];
            foreach ($pegawai as $pid => $pg) { if (in_array($lk, $pg['bisa'], true)) $pool[] = $pid; }
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

/* ===== Filter bulan & tahun ===== */

$bulanDipilih = isset($_GET['bulan']) ? (int)$_GET['bulan'] : (int)date('n');
$tahunDipilih = isset($_GET['tahun']) ? (int)$_GET['tahun'] : (int)date('Y');
if ($bulanDipilih < 1 || $bulanDipilih > 12) $bulanDipilih = (int)date('n');
if (!in_array($tahunDipilih, [2025, 2026, 2027], true)) $tahunDipilih = (int)date('Y');

$labelPeriode = $namaBulan[$bulanDipilih - 1] . ' ' . $tahunDipilih;
$namaStatus = ['akan' => 'Akan datang', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];

$items = [];        /* satu baris = satu orang / satu layanan */
$dataInvoice = [];
$bookingBulanIni = 0;

foreach ($bookings as $b) {
    $awal  = $b['orang'][0]['ts'];
    $akhir = $b['orang'][count($b['orang']) - 1]['ts'];

    if ((int)date('n', $awal) !== $bulanDipilih || (int)date('Y', $awal) !== $tahunDipilih) continue;

    if ($b['batal'])            $status = 'dibatalkan';
    elseif ($akhir < $sekarang) $status = 'selesai';
    else                        $status = 'akan';

    if (!$b['batal']) $bookingBulanIni++;

    $total = 0;
    $rincian = [];

    foreach ($b['orang'] as $o) {
        $namaPegawai = $pegawai[$o['pegawai']]['nama'];   /* diambil dari data pegawai */
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

/* ===== Hitung ringkasan ===== */

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
foreach ($perLayananJumlah as $k => $n) { if ($n > $perLayananJumlah[$lkTerlaris]) $lkTerlaris = $k; }
$adaData = count($items) > 0;

/* grafik 6 bulan terakhir (sampai bulan terpilih) */
$grafik = [];
for ($m = 5; $m >= 0; $m--) {
    $t  = mktime(0, 0, 0, $bulanDipilih - $m, 1, $tahunDipilih);
    $bn = (int)date('n', $t);
    $th = (int)date('Y', $t);
    $sum = 0;
    foreach ($bookings as $b) {
        if ($b['batal'] || $b['bayar'] !== 'lunas') continue;
        $aw = $b['orang'][0]['ts'];
        if ((int)date('n', $aw) !== $bn || (int)date('Y', $aw) !== $th) continue;
        foreach ($b['orang'] as $o) { $sum += $o['harga']; }
    }
    $grafik[] = [$bulan[$bn], $sum / 1000000];
}
$skala = 0.5;
foreach ($grafik as $g) { if ($g[1] > $skala) $skala = $g[1]; }

/* ===== Pengelompokan ===== */

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

/* ===== Penyaji HTML ===== */

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
        $h .= '<tr class="ad-baris' . ($i['batal'] ? ' dibatal' : '') . '">';
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
    $s = hitungGrup($its);
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Salon</title>
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

        /* filter */
        .ad-filter { display: flex; align-items: flex-end; gap: 12px; flex-wrap: wrap; margin: 0; }
        .ad-field { display: flex; flex-direction: column; gap: 6px; }
        .ad-field label { font-size: 13.5px; font-weight: 500; color: #4d4650; }
        .ad-field select, .ad-cari {
            font-family: inherit; font-size: 15px; color: var(--ink); background: #fff; border: 1px solid #e3d8d2;
            border-radius: 10px; padding: 11px 14px; min-width: 140px;
        }
        .ad-field select:focus, .ad-cari:focus { outline: 0; border-color: var(--rose-soft); box-shadow: 0 0 0 3px rgba(196, 147, 141, .25); }

        .ad-btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            font-family: inherit; font-size: 15px; font-weight: 500; padding: 12px 22px; border-radius: 10px;
            cursor: pointer; border: 1px solid transparent; background: var(--rose); color: #fff; transition: background .15s;
        }
        .ad-btn:hover { background: var(--rose-dark); }
        .ad-btn.garis { background: #fff; color: var(--ink); border-color: #e3d8d2; padding: 11px 16px; font-size: 14px; }
        .ad-btn.garis:hover { background: #f6ece7; }

        /* kartu statistik */
        .ad-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 24px; margin-top: 30px; }
        .ad-stat { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 22px 24px 24px; }
        .ad-ic { width: 56px; height: 56px; border-radius: 50%; display: grid; place-items: center; }
        .ad-ic svg { width: 28px; height: 28px; }
        .ad-ic.rose { background: #fbe1de; color: #b4524a; }
        .ad-ic.green { background: #d8f0e3; color: #23805a; }
        .ad-ic.violet { background: #e8e2fa; color: #5f4ab0; }
        .ad-ic.amber { background: #fdf0d3; color: #8a5a00; }
        .ad-stat .judul { margin-top: 18px; font-size: 15.5px; color: #4d4650; }
        .ad-stat .nilai { margin-top: 8px; font-size: 28px; font-weight: 700; line-height: 1.1; }
        .ad-stat .info { margin-top: 8px; font-size: 14px; color: var(--muted); }

        /* kartu umum */
        .ad-kartu { background: #fff; border: 1px solid var(--line); border-radius: 16px; padding: 26px 28px; min-width: 0; margin-top: 24px; }
        .ad-kartu-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 6px; flex-wrap: wrap; }
        .ad-kartu-head h2 { margin: 0; font-size: 21px; font-weight: 600; }
        .ad-sub { margin: 0 0 20px; font-size: 14.5px; color: var(--muted); }
        .ad-lencana { font-size: 13px; font-weight: 500; padding: 6px 12px; border-radius: 8px; background: #f7f2ef; color: #5d504c; white-space: nowrap; }

        /* grafik batang */
        .ad-grafik { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 12px; align-items: end; padding: 0 4px; }
        .ad-kol { display: flex; flex-direction: column; align-items: center; min-width: 0; }
        .ad-kol .nilai-bar { font-size: 13px; font-weight: 600; margin-bottom: 8px; white-space: nowrap; }
        .ad-area { width: 100%; height: 200px; display: flex; align-items: flex-end; justify-content: center; border-bottom: 1px solid #d9cdc8; }
        .ad-bar { width: 100%; max-width: 56px; background: var(--rose-soft); border-radius: 4px 4px 0 0; min-height: 4px; }
        .ad-bar:hover { background: var(--rose-dark); }
        .ad-kol.sekarang .ad-bar { background: var(--rose); }
        .ad-kol .bln { margin-top: 10px; font-size: 13.5px; color: var(--muted); }
        .ad-kol.sekarang .bln { color: var(--ink); font-weight: 600; }

        /* tab tampilan */
        .ad-tabs { display: flex; flex-wrap: wrap; gap: 4px; border-bottom: 1px solid var(--line); margin: 6px 0 20px; }
        .ad-tab { background: none; border: 0; border-bottom: 3px solid transparent; margin-bottom: -1px; padding: 12px 18px; font-family: inherit; font-size: 15px; color: var(--muted); cursor: pointer; }
        .ad-tab:hover { color: var(--ink); }
        .ad-tab.active { color: var(--ink); font-weight: 600; border-bottom-color: var(--rose); }

        .ad-alat { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-bottom: 18px; }
        .ad-alat .ad-cari { flex: 1 1 240px; min-width: 0; }

        .ad-panel { display: none; }
        .ad-panel.active { display: block; }

        /* grup (accordion) */
        .ad-grup { border: 1px solid var(--line); border-radius: 12px; margin-bottom: 12px; background: #fff; overflow: hidden; }
        .ad-grup[open] { border-color: #e0cfc9; }
        .ad-grup summary {
            list-style: none; cursor: pointer; display: grid; align-items: center; gap: 16px;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1.4fr) auto 24px; padding: 16px 20px;
        }
        .ad-grup summary::-webkit-details-marker { display: none; }
        .ad-grup summary:hover { background: #fcf8f6; }
        .g-nama { font-weight: 600; font-size: 16px; min-width: 0; }
        .g-meta { font-size: 14px; color: var(--muted); }
        .g-total { font-weight: 700; font-size: 16px; text-align: right; white-space: nowrap; }
        .g-chev svg { width: 20px; height: 20px; color: #4a4348; transition: transform .2s; }
        .ad-grup[open] .g-chev svg { transform: rotate(180deg); }
        .ad-grup .ad-tabel-box { border-top: 1px solid var(--line); padding: 4px 8px 8px; }
        .ad-kosong-grup { border-top: 1px solid var(--line); padding: 18px 20px; font-size: 14px; color: var(--muted); }
        .ad-ringkas { border-top: 1px solid var(--line); padding: 14px 20px 4px; display: flex; flex-wrap: wrap; gap: 8px 20px; font-size: 14px; color: #4d4650; }
        .ad-ringkas i { font-style: normal; color: var(--muted); }

        .ad-juara { display: inline-block; margin-left: 8px; padding: 2px 8px; border-radius: 6px; background: #fdf0d3; color: #8a5a00; font-size: 12px; font-weight: 500; vertical-align: middle; }
        .ad-org { display: flex; align-items: center; gap: 12px; }
        .ad-org .ad-ava { width: 38px; height: 38px; background: #f2dcd8; color: #8a4a44; font-size: 13px; }
        .ad-org small { display: block; margin-top: 2px; font-size: 13px; color: var(--muted); font-weight: 400; }

        .ad-jumlah { display: flex; justify-content: space-between; gap: 12px; padding: 16px 20px; margin-top: 4px; background: #fbf4f1; border-radius: 12px; font-weight: 700; }

        /* tabel */
        .ad-tabel-box { overflow-x: auto; }
        .ad-tabel { width: 100%; border-collapse: collapse; font-size: 14.5px; min-width: 820px; }
        .ad-tabel th { text-align: left; font-weight: 600; font-size: 13.5px; padding: 12px 12px; background: #f7f2ef; white-space: nowrap; }
        .ad-tabel th:first-child { border-radius: 8px 0 0 8px; }
        .ad-tabel th:last-child { border-radius: 0 8px 8px 0; }
        .ad-tabel th.kanan, .ad-tabel td.kanan { text-align: right; }
        .ad-tabel td { padding: 13px 12px; border-bottom: 1px solid var(--line); vertical-align: middle; white-space: nowrap; }
        .ad-tabel tr:last-child td { border-bottom: 0; }
        .ad-tabel .tebal { font-weight: 600; }
        .ad-tabel tr.dibatal td { color: #9a9096; }
        .ad-tabel tr.dibatal td.tebal { text-decoration: line-through; }

        .bd { display: inline-block; padding: 4px 10px; border-radius: 999px; font-size: 11px; font-weight: 600; letter-spacing: .08em; text-transform: uppercase; white-space: nowrap; }
        .bd.lunas { background: #e3ebdc; color: #2f4a23; }
        .bd.tunggu { background: #f3e2cf; color: #6b3f12; }
        .bd.batal { background: #f4dedb; color: #8a3326; }

        .ad-mini { font-family: inherit; font-size: 12px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; padding: 8px 14px; border-radius: 8px; border: 1px solid var(--rose); background: transparent; color: var(--rose-dark); cursor: pointer; }
        .ad-mini:hover { background: var(--rose); color: #fff; }

        .ad-kosong { text-align: center; padding: 40px 20px; color: var(--muted); border: 1px dashed #e0d6d0; border-radius: 12px; }
        .ad-catatan { margin: 18px 0 0; font-size: 13px; color: var(--muted); }

        .ad-foot { text-align: center; padding: 22px; font-size: 12px; letter-spacing: .14em; color: #8a8088; border-top: 1px solid var(--line); }

        .ad-burger:focus-visible, .ad-user:focus-visible, .ad-link:focus-visible, .ad-btn:focus-visible, .ad-tab:focus-visible, .ad-mini:focus-visible { outline: 2px solid #c4938d; outline-offset: 2px; }

        /* ================= INVOICE ================= */
        .iv-overlay { display: none; position: fixed; inset: 0; z-index: 400; background: rgba(48, 30, 24, .55); align-items: flex-start; justify-content: center; padding: 24px 16px; overflow-y: auto; }
        .iv-overlay.show { display: flex; }
        .iv-box { background: #fff; width: 100%; max-width: 720px; padding: 44px 44px 36px; margin: auto 0; color: #2b1e19; }
        .iv-head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 16px; padding-bottom: 24px; border-bottom: 1px solid #2b1e19; }
        .iv-brand { font-family: 'Cormorant Garamond', serif; font-size: 30px; letter-spacing: .26em; font-weight: 500; }
        .iv-judul { text-align: right; }
        .iv-judul b { display: block; font-family: 'Cormorant Garamond', serif; font-size: 34px; font-weight: 500; letter-spacing: .08em; }
        .iv-judul span { font-size: 14px; color: #6b5f57; }
        .iv-meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px 28px; padding: 24px 0; border-bottom: 1px solid #e6dccf; }
        .iv-meta small { display: block; font-size: 11px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: #6b5f57; margin-bottom: 4px; }
        .iv-meta div { font-size: 15px; }
        .iv-item { display: flex; justify-content: space-between; gap: 16px; padding: 18px 0; border-bottom: 1px solid #e6dccf; }
        .iv-item .nm { font-family: 'Cormorant Garamond', serif; font-size: 24px; font-weight: 500; }
        .iv-item .sub { font-size: 14px; color: #6b5f57; margin-top: 2px; }
        .iv-item .hg { font-weight: 600; white-space: nowrap; }
        .iv-judul-bagian { margin: 24px 0 0; font-size: 12px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: #6b5f57; }
        .iv-total { display: flex; justify-content: space-between; align-items: baseline; padding: 20px 0 6px; }
        .iv-total span { font-size: 13px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; }
        .iv-total b { font-family: 'Cormorant Garamond', serif; font-size: 34px; font-weight: 600; }
        .iv-catatan { font-size: 13px; color: #6b5f57; margin-top: 12px; }
        .iv-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; }
        .iv-btn { flex: 1 1 140px; font-family: inherit; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 14px 20px; border: 1px solid #2b1e19; background: transparent; color: #2b1e19; cursor: pointer; }
        .iv-btn:hover { background: #2b1e19; color: #faf6f0; }
        .iv-btn.utama { background: #c4a074; border-color: #c4a074; }
        .iv-btn.utama:hover { background: #c4a074; color: #2b1e19; filter: brightness(.95); }

        @media (max-width: 560px) {
            .iv-box { padding: 28px 20px 24px; }
            .iv-meta { grid-template-columns: 1fr; }
            .iv-judul { text-align: left; }
        }

        @media print {
            body > *:not(#invoiceModal) { display: none !important; }
            #invoiceModal { position: static; display: block !important; background: none; padding: 0; }
            .iv-box { max-width: none; padding: 0; }
            .iv-aksi { display: none !important; }
        }

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
            .ad-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .ad-user-info { display: none; }
            .ad-grafik { gap: 6px; }
            .ad-kol .nilai-bar { font-size: 11px; }
            .ad-area { height: 150px; }
            .ad-grup summary { grid-template-columns: minmax(0, 1fr) auto 24px; }
            .g-meta { grid-column: 1 / 2; grid-row: 2; }
        }

        @media (max-width: 560px) {
            .ad-stats { grid-template-columns: 1fr; }
        }

        @media (max-width: 520px) {
            .ad-kartu { padding: 20px 16px; }
            .ad-filter, .ad-field, .ad-field select, .ad-filter .ad-btn { width: 100%; }
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
                    <h1>Laporan Salon</h1>
                    <p>Pantau penghasilan, transaksi, dan aktivitas salon.</p>
                </section>

                <!-- FILTER -->
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


            <!-- RINGKASAN -->

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


            <!-- PENGHASILAN BULANAN -->

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


            <!-- DETAIL TRANSAKSI -->

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


                <!-- HARIAN -->
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


                <!-- PER LAYANAN -->
                <div class="ad-panel" id="panel-layanan">
                    <?php foreach ($grupLayanan as $lk => $its): ?>
                        <?php
                        $judul = e($layanan[$lk][0]) . ' <span style="font-weight:400;color:#6b6470">· ' . e(rupiah($layanan[$lk][1])) . '</span>';

                        /* rincian pegawai yang mengerjakan layanan ini */
                        $perPeg = [];
                        foreach ($its as $i) { if (!$i['batal']) $perPeg[$i['pegawai']] = ($perPeg[$i['pegawai']] ?? 0) + 1; }
                        arsort($perPeg);
                        $ringkas = '';
                        if ($perPeg) {
                            $ringkas = '<div class="ad-ringkas"><i>Dikerjakan oleh:</i>';
                            foreach ($perPeg as $nm => $n) { $ringkas .= '<span>' . e($nm) . ' ×' . (int)$n . '</span>'; }
                            $ringkas .= '</div>';
                        }
                        echo grupHtml($judul, '', $its, $ringkas);
                        ?>
                    <?php endforeach; ?>

                    <?php $tl = hitungGrup($items); ?>
                    <div class="ad-jumlah"><span>Total (<?= (int)$tl['jumlah'] ?> layanan)</span><span><?= e(rupiah($tl['total'])) ?></span></div>
                </div>


                <!-- PER PEGAWAI -->
                <div class="ad-panel" id="panel-pegawai">
                    <?php $urut = 0; foreach ($grupPegawai as $pid => $its): ?>
                        <?php
                        $p = $pegawai[$pid];
                        $s = hitungGrup($its);

                        $judul  = '<span class="ad-org"><span class="ad-ava">' . e(inisial($p['nama'])) . '</span><span><b>' . e($p['nama']) . '</b>';
                        if ($urut === 0 && $s['total'] > 0) $judul .= '<span class="ad-juara">Tertinggi</span>';
                        $judul .= '<small>' . e($p['keahlian']) . '</small></span></span>';

                        /* rincian layanan yang dikerjakan pegawai */
                        $perLay = [];
                        foreach ($its as $i) { if (!$i['batal']) $perLay[$i['layanan']] = ($perLay[$i['layanan']] ?? 0) + 1; }
                        $ringkas = '';
                        if ($perLay) {
                            $ringkas = '<div class="ad-ringkas"><i>Layanan:</i>';
                            foreach ($perLay as $nm => $n) { $ringkas .= '<span>' . e($nm) . ' ×' . (int)$n . '</span>'; }
                            $persen = $totalPenghasilan > 0 ? round($s['total'] / $totalPenghasilan * 100) : 0;
                            $ringkas .= '<span><i>Kontribusi:</i> ' . (int)$persen . '%</span></div>';
                        }

                        echo grupHtml($judul, '', $its, $ringkas);
                        $urut++;
                        ?>
                    <?php endforeach; ?>

                    <div class="ad-jumlah"><span>Total (<?= (int)$tl['jumlah'] ?> layanan)</span><span><?= e(rupiah($tl['total'])) ?></span></div>
                </div>


                <!-- SEMUA TRANSAKSI -->
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

        </main>

        <footer class="ad-foot">© RESERVIN · BOOKING SALON</footer>

    </div>


    <!-- MODAL INVOICE / DETAIL TRANSAKSI -->
    <div class="iv-overlay" id="invoiceModal">
        <div class="iv-box" id="invoiceIsi"></div>
    </div>


<script>

/* ===== INVOICE / DETAIL TRANSAKSI ===== */

const INVOICE = <?= json_encode($dataInvoice, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

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

    /* kepala */
    const head = buatEl("div", "iv-head");
    head.appendChild(buatEl("div", "iv-brand", "RESERVIN"));

    const judul = buatEl("div", "iv-judul");
    judul.appendChild(buatEl("b", "", "INVOICE"));
    judul.appendChild(buatEl("span", "", "INV-" + d.kode));
    head.appendChild(judul);
    box.appendChild(head);

    /* data umum */
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

    /* rincian per orang (lengkap dengan nama pegawai) */
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

    /* total */
    const tot = buatEl("div", "iv-total");
    tot.appendChild(buatEl("span", "", "Total" + (d.jumlah > 1 ? " (" + d.jumlah + " orang)" : "")));
    tot.appendChild(buatEl("b", "", d.total));
    box.appendChild(tot);

    box.appendChild(buatEl("div", "iv-catatan", "Invoice ini dibuat otomatis oleh sistem Reservin."));

    /* tombol */
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


/* ===== TAB TAMPILAN, BUKA/TUTUP, PENCARIAN ===== */

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

        try { history.replaceState(null, "", "#" + nama); } catch (e) { /* abaikan */ }

        saring();

    }

    tabs.forEach(function (t) {
        t.addEventListener("click", function () { pilihTab(t.dataset.panel); });
    });

    document.getElementById("bukaSemua").addEventListener("click", function () {
        panelAktif().querySelectorAll("details").forEach(function (d) { d.open = true; });
    });

    document.getElementById("tutupSemua").addEventListener("click", function () {
        panelAktif().querySelectorAll("details").forEach(function (d) { d.open = false; });
    });

    const cari = document.getElementById("cari");

    function saring() {

        const q = cari.value.trim().toLowerCase();
        const panel = panelAktif();
        let tampil = 0;

        panel.querySelectorAll(".ad-baris").forEach(function (tr) {
            const cocok = q === "" || tr.textContent.toLowerCase().indexOf(q) !== -1;
            tr.style.display = cocok ? "" : "none";
            if (cocok) tampil++;
        });

        panel.querySelectorAll("details.ad-grup").forEach(function (d) {

            const ada = d.querySelectorAll(".ad-baris").length > 0;
            const cocokBaris = Array.prototype.some.call(
                d.querySelectorAll(".ad-baris"),
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

        document.getElementById("kosongCari").style.display = (q !== "" && tampil === 0) ? "block" : "none";

    }

    cari.addEventListener("input", saring);

    const awal = (location.hash || "").replace("#", "");
    if (["harian", "layanan", "pegawai", "semua"].indexOf(awal) !== -1) pilihTab(awal);

})();


/* ===== SIDEBAR & MENU PENGGUNA ===== */

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
