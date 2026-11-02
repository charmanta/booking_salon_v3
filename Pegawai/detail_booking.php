<?php
date_default_timezone_set('Asia/Jakarta');

if (!function_exists('mb_substr')) {
    function mb_substr($str, $start, $length = null, $encoding = null) {
        return $length === null ? substr($str, $start) : substr($str, $start, $length);
    }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($str, $encoding = null) {
        return strtoupper($str);
    }
}

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
        'kembali'  => '<path d="M19 12H5M11 6l-6 6 6 6"/>',
        'cek'      => '<path d="M5 12.500l4.500 4.500L19 7.500"/>',
        'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
        'daftar'   => '<rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 10h6M9 14h6M9 18h3"/>',
        'gambar'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="1.800"/><path d="M21 16l-5-5-8 8"/>',
        'lonceng'  => '<path d="M6 16v-5a6 6 0 0 1 12 0v5l2 2H4z"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'mata'     => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
        'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'telepon'  => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'filter'   => '<polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>',
        'kilau'    => '<path d="M12 2l2.4 7.2L22 12l-7.6 2.8L12 22l-2.4-7.2L2 12l7.6-2.8z"/>',
    ];
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($p[$nama] ?? '') . '</svg>';
}

function rupiah($n) { return 'Rp ' . number_format((int)$n, 0, ',', '.'); }

/* Profil Pegawai */
$pegawai = ['nama' => 'Siti Amelia', 'peran' => 'Pegawai', 'inisial' => 'SA'];

$menu = [
    ['dashboard.php',        'Dashboard',        'home',    false],
    ['detail_booking.php',   'Pesanan Masuk',    'lonceng', true],
    ['daftar_reservasi.php', 'Daftar Reservasi', 'booking', false],
    ['jadwal_saya.php',      'Jadwal Saya',      'booking', false],
    ['profil.php',           'Profil',           'user',    false],
];

/* Data Daftar Pesanan Masuk (Order Notifications) */
$daftarOrder = [
    [
        'kode'         => 'RSV-001',
        'status'       => 'Menunggu Verifikasi',
        'waktu_notif'  => '3 menit lalu',
        'is_baru'      => true,
        'pelanggan'    => 'Rina Anggraini',
        'telepon'      => '081234567890',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Creambath Tradisional',
        'tanggal'      => '17 Oktober 2026',
        'jam'          => '10:00',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank BCA',
        'total'        => 100000,
        'dp'           => 50000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Mohon staf yang lembut saat creambath.',
    ],
    [
        'kode'         => 'RSV-004',
        'status'       => 'Menunggu Verifikasi',
        'waktu_notif'  => '15 menit lalu',
        'is_baru'      => true,
        'pelanggan'    => 'Nadia Putri',
        'telepon'      => '081377889900',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Hair Spa + Creambath',
        'tanggal'      => '18 Oktober 2026',
        'jam'          => '13:00',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank Mandiri',
        'total'        => 150000,
        'dp'           => 150000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Pembayaran lunas penuh di muka.',
    ],
    [
        'kode'         => 'RSV-006',
        'status'       => 'Menunggu Verifikasi',
        'waktu_notif'  => '40 menit lalu',
        'is_baru'      => true,
        'pelanggan'    => 'Citra Dewanti',
        'telepon'      => '085211223344',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Hair Coloring (Coklat Hazel)',
        'tanggal'      => '19 Oktober 2026',
        'jam'          => '14:30',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank BNI',
        'total'        => 250000,
        'dp'           => 125000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Sudah pernah bleaching sebelumnya.',
    ],
    [
        'kode'         => 'RSV-002',
        'status'       => 'Dikonfirmasi',
        'waktu_notif'  => 'Kemarin, 14:20',
        'is_baru'      => false,
        'pelanggan'    => 'Dewi Lestari',
        'telepon'      => '081298765432',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Potong Rambut Layer',
        'tanggal'      => '17 Oktober 2026',
        'jam'          => '13:00',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank BCA',
        'total'        => 50000,
        'dp'           => 50000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Booking sudah dikonfirmasi.',
    ],
    [
        'kode'         => 'RSV-003',
        'status'       => 'Dikonfirmasi',
        'waktu_notif'  => '2 hari lalu',
        'is_baru'      => false,
        'pelanggan'    => 'Maya Putri',
        'telepon'      => '081377788899',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Hair Spa Aromatherapy',
        'tanggal'      => '18 Oktober 2026',
        'jam'          => '15:00',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank BCA',
        'total'        => 150000,
        'dp'           => 75000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Booking sudah dikonfirmasi.',
    ],
    [
        'kode'         => 'RSV-005',
        'status'       => 'Ditolak',
        'waktu_notif'  => '3 hari lalu',
        'is_baru'      => false,
        'pelanggan'    => 'Sinta Maharani',
        'telepon'      => '081355566677',
        'salon'        => 'Luna Salon',
        'layanan'      => 'Hair Coloring',
        'tanggal'      => '16 Oktober 2026',
        'jam'          => '11:00',
        'pegawai'      => 'Siti Amelia',
        'metode'       => 'Transfer Bank BRI',
        'total'        => 250000,
        'dp'           => 125000,
        'bukti'        => '../uploads/bukti_transfer.jpg',
        'catatan'      => 'Ditolak: Bukti transfer buram dan nominal tidak sesuai.',
    ]
];

$totalMenunggu = 0;
foreach ($daftarOrder as $ord) {
    if ($ord['status'] === 'Menunggu Verifikasi') $totalMenunggu++;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Masuk & Konfirmasi Order — Reservin</title>
    
    <!-- Google Fonts -->
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

    <!-- ===== KONTEN UTAMA ===== -->
    <div class="ad-wrap" id="wrap">
        <header class="ad-top">
            <button type="button" class="ad-burger" id="burger" aria-label="Buka menu" aria-expanded="false" aria-controls="sidebar">
                <?= ikon('menu') ?>
            </button>

            <div class="ad-user-wrap">
                <button type="button" class="ad-user" id="userBtn" aria-haspopup="true" aria-expanded="false">
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
            <a href="dashboard.php" class="ad-kembali"><?= ikon('kembali') ?> Kembali ke Dashboard</a>

            <div class="ad-head-bar">
                <section class="ad-sapa">
                    <h1>
                        Pesanan Masuk
                        <span class="notif-badge-head" id="badgeMenunggu">
                            <span class="notif-dot-pulse"></span>
                            <span id="jmlMenungguTeks"><?= $totalMenunggu ?> Menunggu Konfirmasi</span>
                        </span>
                    </h1>
                    <p>Daftar pesanan terbaru dari pelanggan yang memerlukan verifikasi dan konfirmasi staf.</p>
                </section>

                <button type="button" class="ad-simulasi-btn" id="btnSimulasiOrder" title="Klik untuk mencoba simulasi notifikasi order baru masuk!">
                    <?= ikon('kilau') ?>
                    Simulasi Order Baru Masuk
                </button>
            </div>

            <!-- TAB FILTER STATUS -->
            <div class="order-tabs" role="tablist">
                <button type="button" class="order-tab active" data-filter="semua">
                    Semua Pesanan <span class="tab-jml" id="tabJmlSemua"><?= count($daftarOrder) ?></span>
                </button>
                <button type="button" class="order-tab" data-filter="menunggu">
                    Menunggu Konfirmasi <span class="tab-jml" id="tabJmlMenunggu"><?= $totalMenunggu ?></span>
                </button>
                <button type="button" class="order-tab" data-filter="dikonfirmasi">
                    Dikonfirmasi <span class="tab-jml" id="tabJmlDikonfirmasi">2</span>
                </button>
                <button type="button" class="order-tab" data-filter="ditolak">
                    Ditolak <span class="tab-jml" id="tabJmlDitolak">1</span>
                </button>
            </div>

            <!-- FEED DAFTAR PESANAN MASUK -->
            <div class="order-list" id="orderList">
                <?php foreach ($daftarOrder as $ord): ?>
                    <?php
                    $inisial = mb_substr($ord['pelanggan'], 0, 2);
                    $kelasStatus = $ord['status'] === 'Dikonfirmasi' ? 'status-dikonfirmasi' : ($ord['status'] === 'Ditolak' ? 'status-ditolak' : 'status-menunggu');
                    $pilKelas = $ord['status'] === 'Dikonfirmasi' ? 'ok' : ($ord['status'] === 'Ditolak' ? 'tolak' : 'tunggu');
                    ?>
                    <article class="order-card <?= $kelasStatus ?>" id="card-<?= e($ord['kode']) ?>" data-status="<?= e(strtolower(str_replace(' ', '', $ord['status']))) ?>">
                        <div class="order-card-top">
                            <div class="order-cust-info">
                                <div class="order-cust-ava"><?= e(strtoupper($inisial)) ?></div>
                                <div class="order-cust-teks">
                                    <b><?= e($ord['pelanggan']) ?></b>
                                    <div class="meta-waktu">
                                        <?php if ($ord['is_baru'] && $ord['status'] === 'Menunggu Verifikasi'): ?>
                                            <span class="badge-baru">Pesanan Baru</span>
                                        <?php endif; ?>
                                        <span><?= ikon('jam') ?> <?= e($ord['waktu_notif']) ?></span>
                                        <span>·</span>
                                        <span><?= ikon('telepon') ?> <?= e($ord['telepon']) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="order-card-status">
                                <span class="order-kode"><?= e($ord['kode']) ?></span>
                                <span class="ad-pil <?= $pilKelas ?>" id="badge-<?= e($ord['kode']) ?>"><?= e($ord['status']) ?></span>
                            </div>
                        </div>

                        <!-- Baris Grid Informasi Detail -->
                        <div class="order-card-grid">
                            <div class="order-cell">
                                <small>Layanan Salon</small>
                                <span><?= e($ord['layanan']) ?></span>
                            </div>
                            <div class="order-cell">
                                <small>Jadwal Kedatangan</small>
                                <span><?= e($ord['tanggal']) ?> · <?= e($ord['jam']) ?></span>
                            </div>
                            <div class="order-cell">
                                <small>Pegawai Dipilih</small>
                                <span><?= e($ord['pegawai']) ?></span>
                            </div>
                            <div class="order-cell">
                                <small>Total / Pembayaran</small>
                                <span class="harga-highlight"><?= e(rupiah($ord['total'])) ?></span>
                            </div>
                        </div>

                        <!-- Baris Bawah: Pratinjau Bukti & Tombol Lihat Order -->
                        <div class="order-card-foot">
                            <div class="order-bukti-ringkas">
                                <img src="<?= e($ord['bukti']) ?>" alt="Bukti Transfer" class="order-bukti-thumb" onclick="zoomGambar('<?= e($ord['bukti']) ?>')" title="Klik untuk memperbesar bukti transfer">
                                <div>
                                    <span style="font-weight: 600; color: var(--ink);">Bukti Transfer Terlampir</span>
                                    <span style="display:block; font-size: 12.5px;"><?= e($ord['metode']) ?> · DP: <?= e(rupiah($ord['dp'])) ?></span>
                                </div>
                            </div>

                            <button type="button" class="btn-lihat-order" onclick="bukaModalOrder('<?= e($ord['kode']) ?>')">
                                <?= ikon('mata') ?>
                                Lihat Order & Konfirmasi
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </main>

        <footer class="ad-foot">© RESERVIN · SISTEM MANAJEMEN PESANAN SALON</footer>
    </div>

    <!-- ===== MODAL POP-UP DETAIL ORDER & KONFIRMASI ===== -->
    <div class="ad-modal" id="modalOrder" role="dialog" aria-modal="true" aria-label="Detail Pesanan">
        <div class="modal-order-box">
            <div class="modal-order-head">
                <h2>
                    <span id="mKode">RSV-001</span>
                    <span class="ad-pil tunggu" id="mStatusBadge">Menunggu Verifikasi</span>
                </h2>
                <button type="button" class="ad-x" onclick="tutupModalOrder()" aria-label="Tutup"><?= ikon('tutup') ?></button>
            </div>

            <!-- Detail Grid Pelanggan & Layanan -->
            <div class="modal-grid">
                <div class="modal-item">
                    <small>Nama Pelanggan</small>
                    <b id="mPelanggan">Rina Anggraini</b>
                </div>
                <div class="modal-item">
                    <small>Nomor Telepon / WhatsApp</small>
                    <b id="mTelepon">081234567890</b>
                </div>
                <div class="modal-item">
                    <small>Nama Salon</small>
                    <b id="mSalon">Luna Salon</b>
                </div>
                <div class="modal-item">
                    <small>Layanan yang Dipesan</small>
                    <b id="mLayanan">Creambath</b>
                </div>
                <div class="modal-item">
                    <small>Tanggal Booking</small>
                    <b id="mTanggal">17 Oktober 2026</b>
                </div>
                <div class="modal-item">
                    <small>Jam Booking</small>
                    <b id="mJam">10:00</b>
                </div>
                <div class="modal-item">
                    <small>Pegawai yang Melayani</small>
                    <b id="mPegawai">Siti Amelia</b>
                </div>
                <div class="modal-item">
                    <small>Metode Pembayaran</small>
                    <b id="mMetode">Transfer Bank</b>
                </div>
                <div class="modal-item full" id="mBoxCatatan">
                    <small>Catatan Khusus Pelanggan</small>
                    <b id="mCatatan" style="font-weight: 400; color: var(--muted);">-</b>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="modal-sub-head">
                <?= ikon('booking') ?>
                Rincian Pembayaran
            </div>
            <div class="modal-bayar-grid">
                <div class="modal-bayar-box">
                    <small>Total Harga</small>
                    <b id="mTotal">Rp 100.000</b>
                </div>
                <div class="modal-bayar-box">
                    <small>DP Dibayarkan</small>
                    <b id="mDp" style="color: #2e9468;">Rp 50.000</b>
                </div>
                <div class="modal-bayar-box">
                    <small>Sisa Pembayaran</small>
                    <b id="mSisa" style="color: var(--tan-dark);">Rp 50.000</b>
                </div>
            </div>

            <!-- Bukti Transfer -->
            <div class="modal-sub-head">
                <?= ikon('gambar') ?>
                Bukti Transfer Pelanggan
            </div>
            <div class="modal-bukti-wrap">
                <img src="../uploads/bukti_transfer.jpg" id="mBuktiImg" class="modal-bukti-img" alt="Bukti Transfer" onclick="zoomGambar(this.src)" title="Klik untuk melihat ukuran penuh">
                <div class="modal-bukti-teks">
                    <b style="font-size: 15px; color: var(--ink);">Foto Bukti Transfer Bank</b>
                    <small>Periksa kesesuaian nama rekening pengirim dan nominal transfer yang tertera pada struk.</small>
                    <small style="color: var(--tan-dark); font-weight: 500; cursor: pointer;" onclick="zoomGambar(document.getElementById('mBuktiImg').src)">🔍 Klik gambar untuk memperbesar</small>
                </div>
            </div>

            <!-- Tombol Aksi Konfirmasi Pesanan -->
            <div class="modal-order-aksi">
                <button type="button" class="ad-btn tutup-bawah" onclick="tutupModalOrder()">Tutup</button>
                <button type="button" class="ad-btn tolak" id="mBtnTolak" onclick="tolakPesananModal()">
                    <?= ikon('tutup') ?>
                    Tolak Pesanan
                </button>
                <button type="button" class="ad-btn terima" id="mBtnTerima" onclick="terimaPesananModal()">
                    <?= ikon('cek') ?>
                    Terima &amp; Konfirmasi Pesanan
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL ZOOM GAMBAR BUKTI -->
    <div class="modal-zoom" id="modalZoom" onclick="this.classList.remove('show')">
        <img src="" id="imgZoomBesar" alt="Bukti Transfer Ukuran Penuh">
    </div>

    <!-- TOAST NOTIFIKASI ORDER MASUK -->
    <div class="toast-notif sembunyi" id="toastNotif">
        <div class="toast-icon">
            <?= ikon('lonceng') ?>
        </div>
        <div class="toast-content">
            <b id="toastJudul">Pesanan Baru Masuk!</b>
            <small id="toastPesan">Pelanggan baru saja melakukan booking layanan.</small>
        </div>
    </div>

    <!-- SCRIPT DATA & INTERAKTIF -->
    <script>
    const DATA_ORDER = <?= json_encode($daftarOrder, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    let orderAktifKode = null;

    function formatRupiah(num) {
        return "Rp " + Number(num).toLocaleString("id-ID");
    }

    /* Modal Buka Detail Order */
    function bukaModalOrder(kode) {
        const ord = DATA_ORDER.find(o => o.kode === kode);
        if (!ord) return;

        orderAktifKode = kode;

        document.getElementById("mKode").textContent = ord.kode;
        const bStatus = document.getElementById("mStatusBadge");
        bStatus.textContent = ord.status;
        bStatus.className = "ad-pil " + (ord.status === "Dikonfirmasi" ? "ok" : (ord.status === "Ditolak" ? "tolak" : "tunggu"));

        document.getElementById("mPelanggan").textContent = ord.pelanggan;
        document.getElementById("mTelepon").textContent = ord.telepon;
        document.getElementById("mSalon").textContent = ord.salon;
        document.getElementById("mLayanan").textContent = ord.layanan;
        document.getElementById("mTanggal").textContent = ord.tanggal;
        document.getElementById("mJam").textContent = ord.jam;
        document.getElementById("mPegawai").textContent = ord.pegawai;
        document.getElementById("mMetode").textContent = ord.metode;
        document.getElementById("mCatatan").textContent = ord.catatan || "-";

        document.getElementById("mTotal").textContent = formatRupiah(ord.total);
        document.getElementById("mDp").textContent = formatRupiah(ord.dp);
        document.getElementById("mSisa").textContent = formatRupiah(ord.total - ord.dp);

        document.getElementById("mBuktiImg").src = ord.bukti;

        // Atur status tombol terima / tolak
        const btnTerima = document.getElementById("mBtnTerima");
        const btnTolak = document.getElementById("mBtnTolak");
        if (ord.status === "Dikonfirmasi") {
            btnTerima.disabled = true;
            btnTerima.innerHTML = "<?= ikon('cek') ?> Sudah Dikonfirmasi";
            btnTolak.disabled = false;
        } else if (ord.status === "Ditolak") {
            btnTerima.disabled = false;
            btnTolak.disabled = true;
            btnTolak.innerHTML = "<?= ikon('tutup') ?> Sudah Ditolak";
        } else {
            btnTerima.disabled = false;
            btnTolak.disabled = false;
            btnTerima.innerHTML = "<?= ikon('cek') ?> Terima & Konfirmasi Pesanan";
            btnTolak.innerHTML = "<?= ikon('tutup') ?> Tolak Pesanan";
        }

        document.getElementById("modalOrder").classList.add("show");
    }

    function tutupModalOrder() {
        document.getElementById("modalOrder").classList.remove("show");
        orderAktifKode = null;
    }

    /* Konfirmasi Terima Pesanan */
    function terimaPesananModal() {
        if (!orderAktifKode) return;
        const ord = DATA_ORDER.find(o => o.kode === orderAktifKode);
        if (!ord) return;

        if (confirm("Konfirmasi pesanan " + ord.kode + " untuk pelanggan " + ord.pelanggan + "?")) {
            ord.status = "Dikonfirmasi";
            ord.is_baru = false;

            // Update badge di kartu list
            const badgeCard = document.getElementById("badge-" + ord.kode);
            if (badgeCard) {
                badgeCard.textContent = "Dikonfirmasi";
                badgeCard.className = "ad-pil ok";
            }
            const cardEl = document.getElementById("card-" + ord.kode);
            if (cardEl) {
                cardEl.className = "order-card status-dikonfirmasi";
                cardEl.dataset.status = "dikonfirmasi";
            }

            tutupModalOrder();
            hitungUlangNotif();
            tampilkanToast("Pesanan Dikonfirmasi!", "Order " + ord.kode + " (" + ord.pelanggan + ") berhasil diterima dan masuk ke jadwal.");
        }
    }

    /* Tolak Pesanan */
    function tolakPesananModal() {
        if (!orderAktifKode) return;
        const ord = DATA_ORDER.find(o => o.kode === orderAktifKode);
        if (!ord) return;

        const alasan = prompt("Masukkan alasan penolakan pesanan ini:", "Bukti transfer tidak valid atau slot jam penuh");
        if (alasan && alasan.trim() !== "") {
            ord.status = "Ditolak";
            ord.is_baru = false;
            ord.catatan = "Ditolak: " + alasan.trim();

            const badgeCard = document.getElementById("badge-" + ord.kode);
            if (badgeCard) {
                badgeCard.textContent = "Ditolak";
                badgeCard.className = "ad-pil tolak";
            }
            const cardEl = document.getElementById("card-" + ord.kode);
            if (cardEl) {
                cardEl.className = "order-card status-ditolak";
                cardEl.dataset.status = "ditolak";
            }

            tutupModalOrder();
            hitungUlangNotif();
            tampilkanToast("Pesanan Ditolak", "Order " + ord.kode + " telah ditolak: " + alasan.trim());
        }
    }

    /* Hitung Ulang Badge Counter */
    function hitungUlangNotif() {
        let nMenunggu = 0, nKonfirm = 0, nTolak = 0;
        DATA_ORDER.forEach(o => {
            if (o.status === "Menunggu Verifikasi") nMenunggu++;
            else if (o.status === "Dikonfirmasi") nKonfirm++;
            else if (o.status === "Ditolak") nTolak++;
        });

        document.getElementById("jmlMenungguTeks").textContent = nMenunggu + " Menunggu Konfirmasi";
        document.getElementById("tabJmlMenunggu").textContent = nMenunggu;
        document.getElementById("tabJmlDikonfirmasi").textContent = nKonfirm;
        document.getElementById("tabJmlDitolak").textContent = nTolak;
        document.getElementById("tabJmlSemua").textContent = DATA_ORDER.length;

        const badgeHead = document.getElementById("badgeMenunggu");
        if (badgeHead) {
            badgeHead.style.display = nMenunggu > 0 ? "inline-flex" : "none";
        }
    }

    /* Zoom Gambar Bukti */
    function zoomGambar(src) {
        document.getElementById("imgZoomBesar").src = src;
        document.getElementById("modalZoom").classList.add("show");
    }

    /* Toast Notification */
    let toastTimeout;
    function tampilkanToast(judul, pesan) {
        const toast = document.getElementById("toastNotif");
        document.getElementById("toastJudul").textContent = judul;
        document.getElementById("toastPesan").textContent = pesan;
        toast.classList.remove("sembunyi");

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            toast.classList.add("sembunyi");
        }, 4500);
    }

    /* Simulasi Pesanan Baru Masuk Real-Time */
    let simulasiId = 7;
    document.getElementById("btnSimulasiOrder").addEventListener("click", function () {
        const namaDummy = ["Lina Marlina", "Fitri Handayani", "Agus Pratama", "Tika Maharani"];
        const layDummy  = ["Hair Spa Aromatherapy", "Creambath Ginseng", "Paket Smoothing + Blow", "Potong Rambut Stylish"];
        const pNama = namaDummy[Math.floor(Math.random() * namaDummy.length)];
        const pLay  = layDummy[Math.floor(Math.random() * layDummy.length)];
        const kodeBaru = "RSV-0" + (simulasiId < 10 ? "0" + simulasiId : simulasiId);
        simulasiId++;

        const newOrder = {
            kode: kodeBaru,
            status: "Menunggu Verifikasi",
            waktu_notif: "Baru saja",
            is_baru: true,
            pelanggan: pNama,
            telepon: "0812" + Math.floor(10000000 + Math.random() * 90000000),
            salon: "Luna Salon",
            layanan: pLay,
            tanggal: "20 Oktober 2026",
            jam: "11:00",
            pegawai: "Siti Amelia",
            metode: "Transfer Bank BCA",
            total: 120000,
            dp: 60000,
            bukti: "../uploads/bukti_transfer.jpg",
            catatan: "Pesanan baru saja masuk melalui reservasi online pelanggan."
        };

        DATA_ORDER.unshift(newOrder);

        // Buat elemen card baru di atas feed
        const cardHtml = `
            <article class="order-card status-menunggu" id="card-${newOrder.kode}" data-status="menungguverifikasi">
                <div class="order-card-top">
                    <div class="order-cust-info">
                        <div class="order-cust-ava">${newOrder.pelanggan.substring(0, 2).toUpperCase()}</div>
                        <div class="order-cust-teks">
                            <b>${newOrder.pelanggan}</b>
                            <div class="meta-waktu">
                                <span class="badge-baru">Pesanan Baru Masuk!</span>
                                <span><?= ikon('jam') ?> Baru saja</span>
                                <span>·</span>
                                <span><?= ikon('telepon') ?> ${newOrder.telepon}</span>
                            </div>
                        </div>
                    </div>
                    <div class="order-card-status">
                        <span class="order-kode">${newOrder.kode}</span>
                        <span class="ad-pil tunggu" id="badge-${newOrder.kode}">Menunggu Verifikasi</span>
                    </div>
                </div>
                <div class="order-card-grid">
                    <div class="order-cell">
                        <small>Layanan Salon</small>
                        <span>${newOrder.layanan}</span>
                    </div>
                    <div class="order-cell">
                        <small>Jadwal Kedatangan</small>
                        <span>${newOrder.tanggal} · ${newOrder.jam}</span>
                    </div>
                    <div class="order-cell">
                        <small>Pegawai Dipilih</small>
                        <span>${newOrder.pegawai}</span>
                    </div>
                    <div class="order-cell">
                        <small>Total / Pembayaran</small>
                        <span class="harga-highlight">${formatRupiah(newOrder.total)}</span>
                    </div>
                </div>
                <div class="order-card-foot">
                    <div class="order-bukti-ringkas">
                        <img src="${newOrder.bukti}" alt="Bukti Transfer" class="order-bukti-thumb" onclick="zoomGambar('${newOrder.bukti}')" title="Klik untuk memperbesar bukti transfer">
                        <div>
                            <span style="font-weight: 600; color: var(--ink);">Bukti Transfer Terlampir</span>
                            <span style="display:block; font-size: 12.5px;">${newOrder.metode} · DP: ${formatRupiah(newOrder.dp)}</span>
                        </div>
                    </div>
                    <button type="button" class="btn-lihat-order" onclick="bukaModalOrder('${newOrder.kode}')">
                        <?= ikon('mata') ?>
                        Lihat Order & Konfirmasi
                    </button>
                </div>
            </article>
        `;

        const listContainer = document.getElementById("orderList");
        listContainer.insertAdjacentHTML("afterbegin", cardHtml);

        hitungUlangNotif();
        tampilkanToast("🔔 Order Baru Masuk!", "Pelanggan " + newOrder.pelanggan + " memesan " + newOrder.layanan + " (" + newOrder.kode + ")");
    });

    /* Tab Filter Status */
    document.querySelectorAll(".order-tab").forEach(tab => {
        tab.addEventListener("click", function () {
            document.querySelectorAll(".order-tab").forEach(t => t.classList.remove("active"));
            this.classList.add("active");

            const filter = this.dataset.filter;
            const cards = document.querySelectorAll(".order-card");

            cards.forEach(card => {
                const status = card.dataset.status;
                if (filter === "semua") {
                    card.style.display = "";
                } else if (filter === "menunggu" && status.includes("menunggu")) {
                    card.style.display = "";
                } else if (filter === "dikonfirmasi" && status.includes("dikonfirmasi")) {
                    card.style.display = "";
                } else if (filter === "ditolak" && status.includes("ditolak")) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });

    /* Tutup Modal saat klik di luar kotak */
    document.getElementById("modalOrder").addEventListener("click", function (e) {
        if (e.target === this) tutupModalOrder();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            tutupModalOrder();
            document.getElementById("modalZoom").classList.remove("show");
        }
    });

    </script>
    <!-- Script Interaktivitas Global Admin & Ripple Wave -->
    <script src="../admin/js/admin.js"></script>
</body>
</html>
