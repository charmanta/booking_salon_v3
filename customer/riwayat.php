<?php
date_default_timezone_set('Asia/Jakarta');

$sekarang = time();
$hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
$bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp' . number_format($n, 0, ',', '.'); }
function tgl($ts) {
    global $hari, $bulan;
    return $hari[(int)date('w', $ts)] . ', ' . date('j', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts) . ' · ' . date('H.i', $ts);
}

/*
 * Data contoh (nanti ganti dengan data dari database).
 * bayar : 'menunggu' | 'lunas'
 * batal : true jika booking dibatalkan
 */
$bookings = [
    [
        'kode' => 'RSV-004', 'salon' => 'Luna Salon', 'kota' => 'Bandung', 'dibuat' => '2026-10-29 14:20',
        'bayar' => 'menunggu', 'batal' => false,
        'orang' => [
            ['nama' => 'Rina (Saya)',   'layanan' => 'Creambath', 'pegawai' => 'Rani',  'waktu' => '2026-11-01 18:00', 'harga' => 100000],
            ['nama' => 'Dewi (Teman)',  'layanan' => 'Facial',    'pegawai' => 'Sinta', 'waktu' => '2026-11-01 19:00', 'harga' => 120000],
        ],
    ],
    [
        'kode' => 'RSV-003', 'salon' => 'Luna Salon', 'kota' => 'Bandung', 'dibuat' => '2026-10-30 09:05',
        'bayar' => 'lunas', 'batal' => false,
        'orang' => [
            ['nama' => 'Rina (Saya)', 'layanan' => 'Potong Rambut', 'pegawai' => 'Dewi', 'waktu' => '2026-11-04 10:00', 'harga' => 75000],
        ],
    ],
    [
        'kode' => 'RSV-002', 'salon' => 'Luna Salon', 'kota' => 'Bandung', 'dibuat' => '2026-10-15 16:40',
        'bayar' => 'lunas', 'batal' => false,
        'orang' => [
            ['nama' => 'Rina (Saya)',  'layanan' => 'Potong Rambut', 'pegawai' => 'Rani',  'waktu' => '2026-10-19 17:40', 'harga' => 75000],
            ['nama' => 'Dewi (Teman)', 'layanan' => 'Facial',        'pegawai' => 'Sinta', 'waktu' => '2026-10-19 18:40', 'harga' => 120000],
        ],
    ],
    [
        'kode' => 'RSV-001', 'salon' => 'Luna Salon', 'kota' => 'Bandung', 'dibuat' => '2026-10-12 11:15',
        'bayar' => 'lunas', 'batal' => false,
        'orang' => [
            ['nama' => 'Rina (Saya)', 'layanan' => 'Creambath', 'pegawai' => 'Rani', 'waktu' => '2026-10-17 18:00', 'harga' => 100000],
        ],
    ],
];

/* Hitung status, total, dan urutan */
$hitung = ['akan' => 0, 'selesai' => 0, 'dibatalkan' => 0];

foreach ($bookings as &$b) {
    $total = 0;
    $awal = PHP_INT_MAX;
    $akhir = 0;

    foreach ($b['orang'] as &$o) {
        $o['ts'] = strtotime($o['waktu']);
        $total += $o['harga'];
        $awal = min($awal, $o['ts']);
        $akhir = max($akhir, $o['ts']);
    }
    unset($o);

    $b['total'] = $total;
    $b['awal'] = $awal;
    $b['akhir'] = $akhir;

    if ($b['batal']) {
        $b['status'] = 'dibatalkan';
    } elseif ($akhir < $sekarang) {
        $b['status'] = 'selesai';
    } else {
        $b['status'] = 'akan';
    }

    $hitung[$b['status']]++;
}
unset($b);

/* Akan datang (terdekat dulu), lalu selesai/dibatalkan (terbaru dulu) */
usort($bookings, function ($a, $b) {
    $ga = $a['status'] === 'akan' ? 0 : 1;
    $gb = $b['status'] === 'akan' ? 0 : 1;
    if ($ga !== $gb) return $ga <=> $gb;
    return $ga === 0 ? $a['awal'] <=> $b['awal'] : $b['akhir'] <=> $a['akhir'];
});

/* Data untuk invoice (detail transaksi) yang dibuka lewat JavaScript */
$namaStatus = ['akan' => 'Akan datang', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
$dataInvoice = [];

foreach ($bookings as $b) {

    $items = [];

    foreach ($b['orang'] as $o) {
        $items[] = [
            'nama'    => $o['nama'],
            'layanan' => $o['layanan'],
            'pegawai' => $o['pegawai'],
            'waktu'   => tgl($o['ts']),
            'harga'   => rp($o['harga']),
        ];
    }

    $dataInvoice[$b['kode']] = [
        'kode'   => $b['kode'],
        'salon'  => $b['salon'],
        'kota'   => $b['kota'],
        'dibuat' => tgl(strtotime($b['dibuat'])),
        'status' => $namaStatus[$b['status']],
        'bayar'  => $b['bayar'],
        'items'  => $items,
        'jumlah' => count($b['orang']),
        'total'  => rp($b['total']),
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        /* ===== Daftar riwayat: satu kolom, turun ke bawah ===== */
        body.p-riwayat .content {
            display: flex; flex-direction: column; gap: 24px;
            width: 100%; box-sizing: border-box;
            max-width: 1280px; margin: 0 auto; padding: 56px clamp(20px, 5vw, 72px) 96px; overflow: visible;
        }

        .rv-judul { display: flex; flex-wrap: wrap; align-items: flex-end; justify-content: space-between; gap: 12px; }
        .rv-judul h2 { margin: 0; font-family: var(--serif, 'Cormorant Garamond', serif); font-weight: 500; font-size: clamp(34px, 4vw, 48px); line-height: 1.05; text-transform: none; letter-spacing: 0; }
        .rv-judul span { font-size: 14px; color: #6b5f57; }

        .rv-tabs { display: flex; flex-wrap: wrap; gap: 4px; border-bottom: 1px solid var(--line, #e6dccf); margin-bottom: 4px; }
        .rv-tab { background: none; border: 0; border-bottom: 3px solid transparent; margin-bottom: -1px; padding: 14px 20px; font-family: inherit; font-size: 15px; color: #6b5f57; cursor: pointer; }
        .rv-tab b { font-weight: 500; }
        .rv-tab.active { color: var(--ink, #2b1e19); font-weight: 600; border-bottom-color: var(--tan, #c4a074); }

        .rv-card { background: var(--white, #fff); border: 1px solid var(--line, #e6dccf); padding: 40px 36px 32px; display: flex; flex-direction: column; gap: 6px; }
        .rv-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; }
        .rv-kode { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 36px; font-weight: 500; line-height: 1.1; }
        .rv-salon { font-size: 14px; color: #6b5f57; margin-top: 4px; }
        .rv-badges { display: flex; flex-direction: column; gap: 8px; align-items: flex-end; }
        .rv-b { display: inline-block; padding: 6px 14px; border-radius: 999px; font-size: 11px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; white-space: nowrap; }
        .rv-b.akan { border: 1px solid var(--ink, #2b1e19); color: var(--ink, #2b1e19); }
        .rv-b.selesai { background: #ece7e1; color: #5c534c; }
        .rv-b.dibatalkan { background: #f4dedb; color: #8a3326; }
        .rv-b.lunas { background: var(--ok-bg, #e3ebdc); color: var(--ok-ink, #2f4a23); }
        .rv-b.menunggu { background: #f3e2cf; color: #6b3f12; }

        .rv-orang { margin-top: 0; padding: 20px 0; border-top: 1px solid var(--line, #e6dccf); display: flex; flex-direction: column; gap: 6px; }
        .rv-card .rv-top + .rv-orang { margin-top: 20px; }
        .rv-baris { display: flex; justify-content: space-between; align-items: baseline; gap: 12px; }
        .rv-nama { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 26px; font-weight: 500; }
        .rv-harga { font-size: 15px; font-weight: 600; white-space: nowrap; }
        .rv-layanan { font-size: 15px; }
        .rv-waktu { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #6b5f57; }
        .rv-ganti { align-self: flex-start; margin-top: 8px; font-family: inherit; font-size: 11px; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; background: transparent; border: 1px solid var(--ink, #2b1e19); color: var(--ink, #2b1e19); padding: 10px 18px; cursor: pointer; }
        .rv-ganti:hover { background: var(--ink, #2b1e19); color: var(--cream, #faf6f0); }

        .rv-total { padding: 18px 0 4px; border-top: 1px solid var(--ink, #2b1e19); display: flex; justify-content: space-between; align-items: baseline; gap: 12px; }
        .rv-total span { font-size: 13px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; }
        .rv-total b { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 30px; font-weight: 600; }

        .rv-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px; }
        .rv-btn { display: inline-block; text-decoration: none; text-align: center; font-family: inherit; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 12px 20px; border: 1px solid var(--ink, #2b1e19); background: transparent; color: var(--ink, #2b1e19); cursor: pointer; }
        .rv-btn:hover { background: var(--ink, #2b1e19); color: var(--cream, #faf6f0); }
        .rv-btn.utama { background: var(--tan, #c4a074); border-color: var(--tan, #c4a074); }
        .rv-btn.utama:hover { filter: brightness(.95); background: var(--tan, #c4a074); color: var(--ink, #2b1e19); }
        .rv-btn.batal { border-color: #9a3b2e; color: #9a3b2e; }
        .rv-btn.batal:hover { background: #9a3b2e; color: #fff; }
        .rv-info { font-size: 13px; color: #6b5f57; margin-top: 10px; }

        .rv-kosong { display: none; text-align: center; padding: 48px 24px; color: #6b5f57; border: 1px dashed var(--line, #e6dccf); }

        /* ===== Invoice / detail transaksi ===== */
        .iv-overlay { display: none; position: fixed; inset: 0; z-index: 300; background: rgba(48,30,24,.55); align-items: flex-start; justify-content: center; padding: 24px 16px; overflow-y: auto; }
        .iv-overlay.show { display: flex; }
        .iv-box { background: #fff; width: 100%; max-width: 720px; padding: 44px 44px 36px; margin: auto 0; box-sizing: border-box; color: var(--ink, #2b1e19); }
        .iv-head { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 16px; padding-bottom: 24px; border-bottom: 1px solid var(--ink, #2b1e19); }
        .iv-brand { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 30px; letter-spacing: .26em; font-weight: 500; }
        .iv-judul { text-align: right; }
        .iv-judul b { display: block; font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 34px; font-weight: 500; letter-spacing: .08em; }
        .iv-judul span { font-size: 14px; color: #6b5f57; }
        .iv-meta { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px 28px; padding: 24px 0; border-bottom: 1px solid var(--line, #e6dccf); }
        .iv-meta small { display: block; font-size: 11px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: #6b5f57; margin-bottom: 4px; }
        .iv-meta div { font-size: 15px; }
        .iv-item { display: flex; justify-content: space-between; gap: 16px; padding: 18px 0; border-bottom: 1px solid var(--line, #e6dccf); }
        .iv-item .nm { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 24px; font-weight: 500; }
        .iv-item .sub { font-size: 14px; color: #6b5f57; margin-top: 2px; }
        .iv-item .hg { font-weight: 600; white-space: nowrap; }
        .iv-judul-bagian { margin: 24px 0 0; font-size: 12px; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: #6b5f57; }
        .iv-total { display: flex; justify-content: space-between; align-items: baseline; padding: 20px 0 6px; }
        .iv-total span { font-size: 13px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; }
        .iv-total b { font-family: var(--serif, 'Cormorant Garamond', serif); font-size: 34px; font-weight: 600; }
        .iv-catatan { font-size: 13px; color: #6b5f57; margin-top: 12px; }
        .iv-aksi { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 24px; }
        .iv-aksi .rv-btn { flex: 1 1 140px; }

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

        /* Modal ganti jadwal */
        .p-riwayat .calendar .date.kosong { visibility: hidden; pointer-events: none; border: 0; background: none; }
        .p-riwayat .time.off { opacity: .35; cursor: not-allowed; text-decoration: line-through; }

        /* Layar lebar (desktop): kartu melebar, tiap orang jadi satu baris */
        @media (min-width: 900px) {
            .rv-card { padding: 44px 48px 36px; }
            .rv-orang { display: grid; grid-template-columns: minmax(180px, 1.1fr) minmax(0, 1.5fr) minmax(0, 1.5fr) auto auto; column-gap: 28px; align-items: center; }
            .rv-baris { display: contents; }
            .rv-nama { order: 1; }
            .rv-layanan { order: 2; }
            .rv-waktu { order: 3; }
            .rv-harga { order: 4; text-align: right; }
            .rv-ganti { order: 5; margin-top: 0; align-self: center; }
        }

        @media (max-width: 560px) {
            .rv-card { padding: 28px 20px 24px; }
            .rv-kode { font-size: 30px; }
            .rv-nama { font-size: 22px; }
        }
    </style>
</head>
<body class="page-customer p-riwayat">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php">Beranda</a>
            <a href="booking.php">Reservasi</a>
            <a href="riwayat.php" class="active">Riwayat</a>
            <a href="https://gemini.google.com/" target="_blank">Tanya AI</a>
            <a href="../login.php">Keluar</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>



<div class="app">

    


    <!-- CONTENT -->

    <div class="content">

        <div class="rv-judul">
            <h2>Booking Anda</h2>
            <span>Diurutkan dari jadwal terdekat</span>
        </div>

        <div class="rv-tabs" id="tabs">
            <button class="rv-tab active" data-filter="semua">Semua <b><?= count($bookings) ?></b></button>
            <button class="rv-tab" data-filter="akan">Akan datang <b><?= $hitung['akan'] ?></b></button>
            <button class="rv-tab" data-filter="selesai">Selesai <b><?= $hitung['selesai'] ?></b></button>
            <button class="rv-tab" data-filter="dibatalkan">Dibatalkan <b><?= $hitung['dibatalkan'] ?></b></button>
        </div>


        <?php foreach ($bookings as $b): ?>

            <?php
            $labelStatus = ['akan' => 'Akan datang', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'][$b['status']];
            $bisaBatal = $b['status'] === 'akan' && ($b['awal'] - $sekarang) > 1800;
            ?>

            <div class="rv-card" data-status="<?= e($b['status']) ?>">

                <div class="rv-top">
                    <div>
                        <div class="rv-kode"><?= e($b['kode']) ?></div>
                        <div class="rv-salon"><?= e($b['salon']) ?> · <?= e($b['kota']) ?></div>
                    </div>

                    <div class="rv-badges">
                        <span class="rv-b <?= e($b['status']) ?>"><?= e($labelStatus) ?></span>
                        <?php if ($b['bayar'] === 'lunas'): ?>
                            <span class="rv-b lunas">Lunas</span>
                        <?php else: ?>
                            <span class="rv-b menunggu">Menunggu verifikasi</span>
                        <?php endif; ?>
                    </div>
                </div>


                <?php foreach ($b['orang'] as $o): ?>

                    <?php $bisaGanti = $b['status'] === 'akan' && ($o['ts'] - $sekarang) > 1800; ?>

                    <div class="rv-orang">

                        <div class="rv-baris">
                            <div class="rv-nama"><?= e($o['nama']) ?></div>
                            <div class="rv-harga"><?= rp($o['harga']) ?></div>
                        </div>

                        <div class="rv-layanan">
                            <?= e($o['layanan']) ?> · dilayani <?= e($o['pegawai']) ?>
                        </div>

                        <div class="rv-waktu">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="1"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                            <?= e(tgl($o['ts'])) ?>
                        </div>

                        <?php if ($bisaGanti): ?>
                            <button
                                class="rv-ganti"
                                data-kode="<?= e($b['kode']) ?>"
                                data-nama="<?= e($o['nama']) ?>"
                                data-pegawai="<?= e($o['pegawai']) ?>"
                                onclick="bukaJadwal(this)">

                                Ganti jadwal

                            </button>
                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>


                <div class="rv-total">
                    <span>Total<?= count($b['orang']) > 1 ? ' (' . count($b['orang']) . ' orang)' : '' ?></span>
                    <b><?= rp($b['total']) ?></b>
                </div>


                <div class="rv-aksi">

                    <?php if ($b['status'] === 'selesai'): ?>
                        <a class="rv-btn utama" href="booking.php?salon=<?= urlencode($b['salon']) ?>">Booking lagi</a>
                    <?php endif; ?>

                    <button class="rv-btn" onclick="bukaInvoice('<?= e($b['kode']) ?>')">Lihat detail transaksi</button>

                    <?php if ($bisaBatal): ?>
                        <button class="rv-btn batal" onclick="batalkan('<?= e($b['kode']) ?>')">Batalkan</button>
                    <?php endif; ?>

                </div>

                <?php if ($b['status'] === 'akan'): ?>
                    <div class="rv-info">
                        Jadwal bisa diganti paling lambat 30 menit sebelum jam booking.
                    </div>
                <?php endif; ?>

            </div>

        <?php endforeach; ?>


        <div class="rv-kosong" id="kosong">
            Belum ada booking di kategori ini.
        </div>

    </div>


    <!-- MENU BAWAH -->

    <div class="bottom">

        <a href="dashboard.php">

            <span class="icon">
                🏠
            </span>

            Beranda

        </a>


        <a href="booking.php">

            <span class="icon">
                📅
            </span>

            Reservasi

        </a>


        <a
            href="riwayat.php"
            class="active">

            <span class="icon">
                📋
            </span>

            Riwayat

        </a>


        <a
            href="https://gemini.google.com/"
            target="_blank">

            <span class="icon">
                💬
            </span>

            Tanya AI

        </a>

    </div>

</div>


<!-- MODAL GANTI JADWAL -->

<div
    class="modal"
    id="scheduleModal">

    <div class="modal-box">

        <div class="modal-title">
            Pilih tanggal dan jam
        </div>


        <div class="owner-info" id="infoModal"></div>


        <!-- HARI -->

        <div class="week">

            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>

        </div>


        <!-- KALENDER OTOMATIS -->

        <div
            class="calendar"
            id="calendar">

        </div>


        <!-- JAM -->

        <div class="time-title">

            Pilih Jam

        </div>


        <div
            class="times"
            id="times">

            <div>
                Pilih tanggal terlebih dahulu.
            </div>

        </div>


        <button
            class="modal-btn"
            onclick="simpanJadwal()">

            Pilih jadwal ini

        </button>


        <button
            class="cancel-btn"
            onclick="tutupJadwal()">

            Batal

        </button>

    </div>

</div>


<!-- MODAL INVOICE / DETAIL TRANSAKSI -->

<div
    class="iv-overlay"
    id="invoiceModal">

    <div class="iv-box" id="invoiceIsi">

    </div>

</div>


<script>

let bookingDipilih = "";

let namaDipilih = "";

let tanggalDipilih = "";

let jamDipilih = "";


function pad(n) {
    return String(n).padStart(2, "0");
}

function isoLokal(d) {
    return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate());
}


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
            w.appendChild(buatEl("span", "rv-b " + badge.kelas, nilai));
        } else {
            w.appendChild(document.createTextNode(nilai));
        }

        meta.appendChild(w);

    }

    baris("Kode booking", d.kode);
    baris("Tanggal booking", d.dibuat);
    baris("Salon", d.salon + " · " + d.kota);
    baris("Status booking", d.status);
    baris("Status pembayaran",
        d.bayar === "lunas" ? "Lunas" : "Menunggu verifikasi",
        { kelas: d.bayar === "lunas" ? "lunas" : "menunggu" });
    baris("Metode pembayaran", "Transfer bank (bayar penuh)");

    box.appendChild(meta);


    /* rincian per orang */

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

    tot.appendChild(buatEl("span", "",
        "Total" + (d.jumlah > 1 ? " (" + d.jumlah + " orang)" : "")));

    tot.appendChild(buatEl("b", "", d.total));

    box.appendChild(tot);

    box.appendChild(buatEl("div", "iv-catatan",
        "Invoice ini dibuat otomatis oleh sistem Reservin."));


    /* tombol */

    const aksi = buatEl("div", "iv-aksi");
    const cetak = buatEl("button", "rv-btn", "Cetak / simpan PDF");
    cetak.onclick = function () { window.print(); };
    aksi.appendChild(cetak);

    const tutup = buatEl("button", "rv-btn utama", "Tutup");
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

document.addEventListener("keydown", function (e) {

    if (e.key === "Escape") tutupInvoice();

});


/* FILTER TAB */

document.querySelectorAll(".rv-tab").forEach(function (tab) {

    tab.onclick = function () {

        document
            .querySelectorAll(".rv-tab")
            .forEach(function (t) { t.classList.remove("active"); });

        tab.classList.add("active");

        const f = tab.dataset.filter;
        let tampil = 0;

        document.querySelectorAll(".rv-card").forEach(function (card) {

            const cocok = f === "semua" || card.dataset.status === f;

            card.style.display = cocok ? "" : "none";

            if (cocok) tampil++;

        });

        document.getElementById("kosong").style.display =
            tampil === 0 ? "block" : "none";

    };

});


/* BATALKAN BOOKING */

function batalkan(kode) {

    if (!confirm("Batalkan booking " + kode + "?")) {
        return;
    }

    /* nanti kirim ke server, mis. batal_booking.php?kode=... */
    alert("Booking " + kode + " dibatalkan.");

}


/* BUKA MODAL */

function bukaJadwal(tombol) {

    bookingDipilih = tombol.dataset.kode;

    namaDipilih = tombol.dataset.nama;

    tanggalDipilih = "";

    jamDipilih = "";

    document
        .getElementById("infoModal")
        .innerHTML = "";

    const info = document.getElementById("infoModal");

    const b = document.createElement("b");
    b.textContent = namaDipilih + " · dilayani " + tombol.dataset.pegawai;

    info.appendChild(b);

    document
        .getElementById("scheduleModal")
        .style.display = "flex";

    buatKalender();

    document
        .getElementById("times")
        .innerHTML =
        "<div>Pilih tanggal terlebih dahulu.</div>";

}


/* TUTUP MODAL */

function tutupJadwal() {

    document
        .getElementById("scheduleModal")
        .style.display = "none";

}


/* KALENDER OTOMATIS */

function buatKalender() {

    let calendar =
        document.getElementById("calendar");

    calendar.innerHTML = "";


    let sekarang = new Date();


    /* kotak kosong supaya tanggal pas di bawah nama harinya */

    for (let k = 0; k < sekarang.getDay(); k++) {

        let kosong =
            document.createElement("div");

        kosong.className = "date kosong";

        calendar.appendChild(kosong);

    }


    /*
       Membuat tanggal otomatis
       mulai hari ini sampai
       30 hari ke depan.
    */

    for (let i = 0; i < 30; i++) {

        let tanggal = new Date();

        tanggal.setDate(
            sekarang.getDate() + i
        );


        let tombol =
            document.createElement("div");

        tombol.className = "date";


        tombol.textContent =
            tanggal.getDate();


        tombol.onclick = function () {

            document
                .querySelectorAll("#calendar .date")
                .forEach(function(item) {

                    item.classList.remove(
                        "active"
                    );

                });


            tombol.classList.add(
                "active"
            );


            tanggalDipilih =
                isoLokal(tanggal);

            jamDipilih = "";


            buatJam();

        };


        calendar.appendChild(tombol);

    }

}


/* JAM OTOMATIS */

function buatJam() {

    let times =
        document.getElementById("times");

    times.innerHTML = "";


    let sekarang = new Date();

    let hariIni =
        tanggalDipilih === isoLokal(sekarang);

    let menitSekarang =
        sekarang.getHours() * 60 + sekarang.getMinutes();


    /*
       Jam salon 09.00 - 20.00
    */

    for (
        let jam = 9;
        jam <= 20;
        jam++
    ) {

        let waktu =
            pad(jam) + ":00";


        let tombol =
            document.createElement("div");


        tombol.className = "time";

        tombol.textContent = waktu;


        /* jam yang sudah lewat tidak bisa dipilih */

        if (hariIni && jam * 60 <= menitSekarang) {

            tombol.classList.add("off");

            times.appendChild(tombol);

            continue;

        }


        tombol.onclick = function () {

            document
                .querySelectorAll("#times .time")
                .forEach(function(item) {

                    item.classList.remove(
                        "active"
                    );

                });


            tombol.classList.add(
                "active"
            );


            jamDipilih = waktu;

        };


        times.appendChild(tombol);

    }

}


/* SIMPAN JADWAL */

function simpanJadwal() {

    if (tanggalDipilih == "") {

        alert(
            "Silakan pilih tanggal terlebih dahulu."
        );

        return;

    }


    if (jamDipilih == "") {

        alert(
            "Silakan pilih jam terlebih dahulu."
        );

        return;

    }


    alert(
        "Jadwal berhasil dipilih!\n\n"
        + "Booking: "
        + bookingDipilih
        + "\nAtas nama: "
        + namaDipilih
        + "\nTanggal: "
        + tanggalDipilih
        + "\nJam: "
        + jamDipilih
    );


    tutupJadwal();

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>