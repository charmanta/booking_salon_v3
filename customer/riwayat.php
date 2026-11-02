<?php
/* =====================================================================
   RESERVIN — RIWAYAT RESERVASI (customer/riwayat.php)
   Halaman riwayat transaksi dan status booking pelanggan:
   - Filter tab status (Semua, Akan Datang, Selesai, Dibatalkan)
   - Kartu rincian booking & status pembayaran
   - Modal ubah jadwal fleksibel dengan kalender interaktif
   - Modal detail transaksi / invoice digital (cetak & PDF)
   ===================================================================== */
require_once __DIR__ . '/includes/init.php';

$page_title   = 'Riwayat Booking';
$current_page = 'riwayat.php';
$body_class   = 'p-riwayat';

$sekarang = time();

// Data riwayat booking (dapat dihubungkan ke query database)
$bookings = [
    [
        'kode'   => 'RSV-004',
        'salon'  => 'Luna Salon',
        'kota'   => 'Bandung',
        'dibuat' => '2026-10-29 14:20',
        'bayar'  => 'menunggu',
        'batal'  => false,
        'orang'  => [
            ['nama' => 'Rina (Saya)',  'layanan' => 'Creambath', 'pegawai' => 'Rani',  'waktu' => '2026-11-01 18:00', 'harga' => 100000],
            ['nama' => 'Dewi (Teman)', 'layanan' => 'Facial',    'pegawai' => 'Sinta', 'waktu' => '2026-11-01 19:00', 'harga' => 120000],
        ],
    ],
    [
        'kode'   => 'RSV-003',
        'salon'  => 'Luna Salon',
        'kota'   => 'Bandung',
        'dibuat' => '2026-10-30 09:05',
        'bayar'  => 'lunas',
        'batal'  => false,
        'orang'  => [
            ['nama' => 'Rina (Saya)', 'layanan' => 'Potong Rambut', 'pegawai' => 'Dewi', 'waktu' => '2026-11-04 10:00', 'harga' => 75000],
        ],
    ],
    [
        'kode'   => 'RSV-002',
        'salon'  => 'Luna Salon',
        'kota'   => 'Bandung',
        'dibuat' => '2026-10-15 16:40',
        'bayar'  => 'lunas',
        'batal'  => false,
        'orang'  => [
            ['nama' => 'Rina (Saya)',  'layanan' => 'Potong Rambut', 'pegawai' => 'Rani',  'waktu' => '2026-10-19 17:40', 'harga' => 75000],
            ['nama' => 'Dewi (Teman)', 'layanan' => 'Facial',        'pegawai' => 'Sinta', 'waktu' => '2026-10-19 18:40', 'harga' => 120000],
        ],
    ],
    [
        'kode'   => 'RSV-001',
        'salon'  => 'Luna Salon',
        'kota'   => 'Bandung',
        'dibuat' => '2026-10-12 11:15',
        'bayar'  => 'lunas',
        'batal'  => false,
        'orang'  => [
            ['nama' => 'Rina (Saya)', 'layanan' => 'Creambath', 'pegawai' => 'Rani', 'waktu' => '2026-10-17 18:00', 'harga' => 100000],
        ],
    ],
];

// Hitung status, total akumulasi, dan waktu mulai-selesai
$hitung = ['akan' => 0, 'selesai' => 0, 'dibatalkan' => 0];

foreach ($bookings as &$b) {
    $total = 0;
    $awal  = PHP_INT_MAX;
    $akhir = 0;

    foreach ($b['orang'] as &$o) {
        $o['ts'] = strtotime($o['waktu']);
        $total  += $o['harga'];
        $awal    = min($awal, $o['ts']);
        $akhir   = max($akhir, $o['ts']);
    }
    unset($o);

    $b['total'] = $total;
    $b['awal']  = $awal;
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

// Urutkan: jadwal akan datang (terdekat dahulu), lalu selesai/dibatalkan (terbaru dahulu)
usort($bookings, function ($a, $b) {
    $ga = $a['status'] === 'akan' ? 0 : 1;
    $gb = $b['status'] === 'akan' ? 0 : 1;
    if ($ga !== $gb) return $ga <=> $gb;
    return $ga === 0 ? $a['awal'] <=> $b['awal'] : $b['akhir'] <=> $a['akhir'];
});

// Format data invoice untuk popup JavaScript
$namaStatus  = ['akan' => 'Akan datang', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
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
        'status' => $namaStatus[$b['status']] ?? $b['status'],
        'bayar'  => $b['bayar'],
        'items'  => $items,
        'jumlah' => count($b['orang']),
        'total'  => rp($b['total']),
    ];
}

// Script interaktivitas tab filter, modal invoice, dan modal ganti jadwal
$extra_js = '
<script>
let bookingDipilih = "";
let namaDipilih    = "";
let tanggalDipilih = "";
let jamDipilih     = "";

function pad(n) {
    return String(n).padStart(2, "0");
}

function isoLokal(d) {
    return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate());
}

/* Data Invoice untuk Modal */
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
    if (!box) return;
    box.innerHTML = "";

    // Header Invoice
    const head = buatEl("div", "iv-head");
    head.appendChild(buatEl("div", "iv-brand", "RESERVIN"));

    const judul = buatEl("div", "iv-judul");
    judul.appendChild(buatEl("b", "", "INVOICE"));
    judul.appendChild(buatEl("span", "", "INV-" + d.kode));
    head.appendChild(judul);
    box.appendChild(head);

    // Meta Transaksi
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
    baris("Metode pembayaran", "Transfer Bank (Bayar Penuh)");
    box.appendChild(meta);

    // Rincian Layanan per Orang
    box.appendChild(buatEl("div", "iv-judul-bagian", "Rincian Layanan"));

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

    // Total Bayar
    const tot = buatEl("div", "iv-total");
    tot.appendChild(buatEl("span", "", "Total" + (d.jumlah > 1 ? " (" + d.jumlah + " orang)" : "")));
    tot.appendChild(buatEl("b", "", d.total));
    box.appendChild(tot);

    box.appendChild(buatEl("div", "iv-catatan", "Invoice ini diterbitkan secara otomatis oleh sistem Reservin Salon Booking."));

    // Tombol Aksi
    const aksi = buatEl("div", "iv-aksi");
    const cetak = buatEl("button", "rv-btn", "Cetak / Simpan PDF");
    cetak.onclick = function () { window.print(); };
    aksi.appendChild(cetak);

    const tutup = buatEl("button", "rv-btn utama", "Tutup");
    tutup.onclick = tutupInvoice;
    aksi.appendChild(tutup);

    box.appendChild(aksi);

    const ivModal = document.getElementById("invoiceModal");
    if (ivModal) ivModal.classList.add("show");
}

function tutupInvoice() {
    const ivModal = document.getElementById("invoiceModal");
    if (ivModal) ivModal.classList.remove("show");
}

const ivModalEl = document.getElementById("invoiceModal");
if (ivModalEl) {
    ivModalEl.addEventListener("click", function (e) {
        if (e.target === this) tutupInvoice();
    });
}

document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") tutupInvoice();
});

/* Filter Tab Riwayat */
document.querySelectorAll(".rv-tab").forEach(function (tab) {
    tab.onclick = function () {
        document.querySelectorAll(".rv-tab").forEach(function (t) { t.classList.remove("active"); });
        tab.classList.add("active");

        const f = tab.dataset.filter;
        let tampil = 0;

        document.querySelectorAll(".rv-card").forEach(function (card) {
            const cocok = (f === "semua" || card.dataset.status === f);
            card.style.display = cocok ? "" : "none";
            if (cocok) tampil++;
        });

        const elKosong = document.getElementById("kosong");
        if (elKosong) elKosong.style.display = (tampil === 0) ? "block" : "none";
    };
});

/* Batalkan Booking */
function batalkan(kode) {
    if (!confirm("Apakah kamu yakin ingin membatalkan booking " + kode + "?")) return;
    alert("Permintaan pembatalan booking " + kode + " telah diajukan.");
}

/* Modal Ubah Jadwal */
function bukaJadwal(tombol) {
    bookingDipilih = tombol.dataset.kode;
    namaDipilih    = tombol.dataset.nama;
    tanggalDipilih = "";
    jamDipilih     = "";

    const info = document.getElementById("infoModal");
    if (info) {
        info.innerHTML = "";
        const b = document.createElement("b");
        b.textContent = namaDipilih + " · dilayani " + tombol.dataset.pegawai;
        info.appendChild(b);
    }

    const modal = document.getElementById("scheduleModal");
    if (modal) modal.style.display = "flex";

    buatKalender();

    const timesEl = document.getElementById("times");
    if (timesEl) timesEl.innerHTML = "<div>Pilih tanggal terlebih dahulu.</div>";
}

function tutupJadwal() {
    const modal = document.getElementById("scheduleModal");
    if (modal) modal.style.display = "none";
}

function buatKalender() {
    const calendar = document.getElementById("calendar");
    if (!calendar) return;
    calendar.innerHTML = "";

    const sekarang = new Date();

    // Spacing awal hari
    for (let k = 0; k < sekarang.getDay(); k++) {
        const kosong = document.createElement("div");
        kosong.className = "date kosong";
        calendar.appendChild(kosong);
    }

    // 30 hari ke depan
    for (let i = 0; i < 30; i++) {
        const tanggal = new Date();
        tanggal.setDate(sekarang.getDate() + i);

        const tombol = document.createElement("div");
        tombol.className = "date";
        tombol.textContent = tanggal.getDate();

        tombol.onclick = function () {
            document.querySelectorAll("#calendar .date").forEach(function (item) {
                item.classList.remove("active");
            });
            tombol.classList.add("active");

            tanggalDipilih = isoLokal(tanggal);
            jamDipilih = "";
            buatJam();
        };

        calendar.appendChild(tombol);
    }
}

function buatJam() {
    const times = document.getElementById("times");
    if (!times) return;
    times.innerHTML = "";

    const sekarang = new Date();
    const hariIni = (tanggalDipilih === isoLokal(sekarang));
    const menitSekarang = sekarang.getHours() * 60 + sekarang.getMinutes();

    for (let jam = 9; jam <= 20; jam++) {
        const waktu = pad(jam) + ":00";
        const tombol = document.createElement("div");
        tombol.className = "time";
        tombol.textContent = waktu;

        if (hariIni && jam * 60 <= menitSekarang) {
            tombol.classList.add("off");
            times.appendChild(tombol);
            continue;
        }

        tombol.onclick = function () {
            document.querySelectorAll("#times .time").forEach(function (item) {
                item.classList.remove("active");
            });
            tombol.classList.add("active");
            jamDipilih = waktu;
        };

        times.appendChild(tombol);
    }
}

function simpanJadwal() {
    if (!tanggalDipilih) {
        alert("Silakan pilih tanggal terlebih dahulu.");
        return;
    }

    if (!jamDipilih) {
        alert("Silakan pilih jam terlebih dahulu.");
        return;
    }

    alert("Jadwal berhasil diubah!\\n\\n"
        + "Booking: " + bookingDipilih + "\\n"
        + "Atas nama: " + namaDipilih + "\\n"
        + "Tanggal baru: " + tanggalDipilih + "\\n"
        + "Jam baru: " + jamDipilih
    );

    tutupJadwal();
}
</script>
';

require __DIR__ . '/includes/header.php';
?>

<!-- ===== KONTEN UTAMA RIWAYAT BOOKING ===== -->
<div class="app">
    <div class="content">

        <div class="rv-judul">
            <h2>Booking Anda</h2>
            <span>Diurutkan berdasarkan jadwal terdekat</span>
        </div>

        <!-- Filter Tab Kategori Booking -->
        <div class="rv-tabs" id="tabs">
            <button type="button" class="rv-tab active" data-filter="semua">Semua <b><?= count($bookings) ?></b></button>
            <button type="button" class="rv-tab" data-filter="akan">Akan Datang <b><?= $hitung['akan'] ?></b></button>
            <button type="button" class="rv-tab" data-filter="selesai">Selesai <b><?= $hitung['selesai'] ?></b></button>
            <button type="button" class="rv-tab" data-filter="dibatalkan">Dibatalkan <b><?= $hitung['dibatalkan'] ?></b></button>
        </div>

        <!-- Daftar Kartu Riwayat Booking -->
        <?php foreach ($bookings as $b): ?>
            <?php
            $labelStatus = $namaStatus[$b['status']] ?? $b['status'];
            $bisaBatal   = ($b['status'] === 'akan') && (($b['awal'] - $sekarang) > 1800);
            ?>

            <div class="rv-card" data-status="<?= e($b['status']) ?>">

                <div class="rv-top">
                    <div>
                        <div class="rv-kode"><?= e($b['kode']) ?></div>
                        <div class="rv-salon"><?= e($b['salon']) ?> &middot; <?= e($b['kota']) ?></div>
                    </div>

                    <div class="rv-badges">
                        <span class="rv-b <?= e($b['status']) ?>"><?= e($labelStatus) ?></span>
                        <?php if ($b['bayar'] === 'lunas'): ?>
                            <span class="rv-b lunas">Lunas</span>
                        <?php else: ?>
                            <span class="rv-b menunggu">Menunggu Verifikasi</span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Daftar Pelanggan & Layanan -->
                <?php foreach ($b['orang'] as $o): ?>
                    <?php $bisaGanti = ($b['status'] === 'akan') && (($o['ts'] - $sekarang) > 1800); ?>

                    <div class="rv-orang">
                        <div class="rv-baris">
                            <div class="rv-nama"><?= e($o['nama']) ?></div>
                            <div class="rv-harga"><?= rp($o['harga']) ?></div>
                        </div>

                        <div class="rv-layanan">
                            <?= e($o['layanan']) ?> &middot; dilayani <?= e($o['pegawai']) ?>
                        </div>

                        <div class="rv-waktu">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="1"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
                            <?= e(tgl($o['ts'])) ?>
                        </div>

                        <?php if ($bisaGanti): ?>
                            <button
                                type="button"
                                class="rv-ganti"
                                data-kode="<?= e($b['kode']) ?>"
                                data-nama="<?= e($o['nama']) ?>"
                                data-pegawai="<?= e($o['pegawai']) ?>"
                                onclick="bukaJadwal(this)">
                                Ganti Jadwal
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <!-- Total Pembayaran -->
                <div class="rv-total">
                    <span>Total<?= count($b['orang']) > 1 ? ' (' . count($b['orang']) . ' orang)' : '' ?></span>
                    <b><?= rp($b['total']) ?></b>
                </div>

                <!-- Tombol Aksi Transaksi -->
                <div class="rv-aksi">
                    <?php if ($b['status'] === 'selesai'): ?>
                        <a class="rv-btn utama" href="booking.php?salon=<?= urlencode($b['salon']) ?>">Booking Lagi</a>
                    <?php endif; ?>

                    <button type="button" class="rv-btn" onclick="bukaInvoice('<?= e($b['kode']) ?>')">Lihat Detail Transaksi</button>

                    <?php if ($bisaBatal): ?>
                        <button type="button" class="rv-btn batal" onclick="batalkan('<?= e($b['kode']) ?>')">Batalkan</button>
                    <?php endif; ?>
                </div>

                <?php if ($b['status'] === 'akan'): ?>
                    <div class="rv-info">
                        Jadwal dapat diubah paling lambat 30 menit sebelum jam booking.
                    </div>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

        <!-- Notifikasi Kategori Kosong -->
        <div class="rv-kosong" id="kosong">
            Belum ada booking di kategori ini.
        </div>

    </div>
</div>

<!-- Modal Kalender Ganti Jadwal -->
<?php require __DIR__ . '/modals/modal_ganti_jadwal.php'; ?>

<!-- Modal Popup Invoice / Struk Digital -->
<?php require __DIR__ . '/modals/modal_invoice.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
