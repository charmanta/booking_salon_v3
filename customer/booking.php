<?php
/* =====================================================================
   RESERVIN — FORM RESERVASI / BOOKING (customer/booking.php)
   Halaman pemesanan reservasi salon untuk 1 atau banyak orang:
   - Pemilihan layanan & estimasi durasi otomatis
   - Pemilihan pegawai & pencegahan jadwal bentrok
   - Kalender & jam dinamis dalam modal
   - Rincian total biaya & upload bukti bayar
   ===================================================================== */
require_once __DIR__ . '/includes/init.php';

$page_title   = 'Reservasi';
$current_page = 'booking.php';
$body_class   = 'p-booking';

// Data salon yang dipilih dari URL atau default
$salon = $_GET['salon'] ?? 'Luna Salon';

// Daftar layanan salon (statis atau dari database)
$layanan = [
    ['nama' => 'Creambath',     'harga' => 100000, 'durasi' => 45],
    ['nama' => 'Potong Rambut', 'harga' => 75000,  'durasi' => 30],
    ['nama' => 'Facial',        'harga' => 120000, 'durasi' => 60],
    ['nama' => 'Hair Spa',      'harga' => 150000, 'durasi' => 60],
];

// Daftar pegawai salon (statis atau dari database)
$pegawai = [
    'Rani - Hair Stylist',
    'Dewi - Hair Stylist',
    'Sinta - Beautician',
    'Putri - Terapis',
];

// Script interaktivitas form multi-orang, kalkulasi harga, dan popup jadwal
$extra_js = '
<script>
const SALON      = ' . json_encode($salon) . ';
const LAYANAN    = ' . json_encode($layanan) . ';
const PEGAWAI    = ' . json_encode($pegawai) . ';
const MAX_UKURAN = 2 * 1024 * 1024; // 2 MB
const JAM_BUKA   = 9, JAM_TUTUP = 20;

/* Data tiap orang: layanan, pegawai, tanggal, jam */
function orangBaru(nama, utama) {
    return { nama: nama, utama: utama, layanan: [], pegawai: "", tanggal: null, jam: "" };
}

let orang = [ orangBaru("Saya", true) ];
let aktif = -1; // Indeks orang yang sedang diatur jadwalnya
let tmp   = { tanggal: null, jam: "" };

function rupiah(n) {
    return "Rp" + Number(n).toLocaleString("id-ID");
}

function pad(n) {
    return String(n).padStart(2, "0");
}

function isoTanggal(d) {
    return d.getFullYear() + "-" + pad(d.getMonth() + 1) + "-" + pad(d.getDate());
}

function labelTanggal(d) {
    return d.toLocaleDateString("id-ID", { weekday: "short", day: "numeric", month: "short" });
}

function harga(namaLayanan) {
    const l = LAYANAN.find(function (x) { return x.nama === namaLayanan; });
    return l ? l.harga : 0;
}

function subtotal(o) {
    return o.layanan.reduce(function (t, n) { return t + harga(n); }, 0);
}

function totalSemua() {
    return orang.reduce(function (t, o) { return t + subtotal(o); }, 0);
}

function namaTampil(o, i) {
    if (o.utama) return "Saya";
    return o.nama.trim() || ("Orang " + (i + 1));
}

/* Estimasi Durasi */
function durasiLayanan(namaLayanan) {
    const l = LAYANAN.find(function (x) { return x.nama === namaLayanan; });
    return l ? l.durasi : 0;
}

function durasiTotal(o) {
    return o.layanan.reduce(function (t, n) { return t + durasiLayanan(n); }, 0);
}

function formatDurasi(m) {
    if (!m) return "-";
    const j = Math.floor(m / 60);
    const s = m % 60;
    if (j === 0) return s + " mnt";
    if (s === 0) return j + " jam";
    return j + " jam " + s + " mnt";
}

function menit(jam) {
    const p = jam.split(":");
    return parseInt(p[0], 10) * 60 + parseInt(p[1], 10);
}

function jamSelesai(jam, mnt) {
    const t = menit(jam) + mnt;
    return pad(Math.floor(t / 60)) + ":" + pad(t % 60);
}

function rentangJam(jam, mnt) {
    return jam + " - " + jamSelesai(jam, mnt);
}

function el(tag, cls, teks) {
    const e = document.createElement(tag);
    if (cls) e.className = cls;
    if (teks !== undefined) e.textContent = teks;
    return e;
}

/* Render Kartu Tiap Orang */
function renderOrang() {
    const wrap = document.getElementById("people");
    if (!wrap) return;
    wrap.innerHTML = "";

    orang.forEach(function (o, i) {
        const card = el("div", "person");

        // Header kartu orang
        const head = el("div", "p-head");
        head.appendChild(el("b", "", o.utama ? "Saya" : "Orang " + (i + 1)));

        if (!o.utama) {
            const hapus = el("button", "p-hapus", "Hapus");
            hapus.type = "button";
            hapus.onclick = function () {
                orang.splice(i, 1);
                renderOrang();
                renderRincian();
            };
            head.appendChild(hapus);
        }
        card.appendChild(head);

        if (o.utama) {
            card.appendChild(el("div", "info", "Pemilik akun"));
        } else {
            const inp = document.createElement("input");
            inp.type = "text";
            inp.className = "p-nama";
            inp.placeholder = "Nama teman / saudara";
            inp.value = o.nama;
            inp.oninput = function () {
                o.nama = inp.value;
                renderRincian();
            };
            card.appendChild(inp);
        }

        // Pilihan Layanan
        card.appendChild(el("span", "p-sub", "Layanan"));

        LAYANAN.forEach(function (l) {
            const row = el("label", "cb");
            const kiri = el("span");

            const cb = document.createElement("input");
            cb.type = "checkbox";
            cb.checked = o.layanan.indexOf(l.nama) !== -1;
            cb.onchange = function () {
                if (cb.checked) {
                    o.layanan.push(l.nama);
                } else {
                    o.layanan = o.layanan.filter(function (n) { return n !== l.nama; });
                }

                // Cek apakah perubahan durasi membuat jadwal bentrok
                if (o.tanggal && (bentrok(i, o.tanggal.iso, o.jam) || menit(o.jam) + durasiTotal(o) > JAM_TUTUP * 60)) {
                    o.tanggal = null;
                    o.jam = "";
                    alert("Durasi layanan berubah dan jadwal sebelumnya tidak muat lagi. Silakan pilih ulang tanggal dan jam.");
                    renderOrang();
                    renderRincian();
                    return;
                }

                perbarui(card, o);
            };

            kiri.appendChild(cb);
            kiri.appendChild(document.createTextNode(" " + l.nama));
            row.appendChild(kiri);
            row.appendChild(el("em", "", "± " + formatDurasi(l.durasi) + " · " + rupiah(l.harga)));
            card.appendChild(row);
        });

        // Pilihan Pegawai
        card.appendChild(el("span", "p-sub", "Dilayani oleh"));

        const sel = document.createElement("select");
        const op0 = el("option", "", "Pilih pegawai");
        op0.value = "";
        sel.appendChild(op0);

        PEGAWAI.forEach(function (p) {
            const op = el("option", "", p);
            op.value = p;
            if (o.pegawai === p) op.selected = true;
            sel.appendChild(op);
        });

        sel.onchange = function () {
            o.pegawai = sel.value;
            if (o.tanggal && bentrok(i, o.tanggal.iso, o.jam)) {
                o.tanggal = null;
                o.jam = "";
                alert("Jadwal sebelumnya bentrok dengan pegawai ini. Silakan pilih ulang tanggal dan jam.");
            }
            renderOrang();
            renderRincian();
        };
        card.appendChild(sel);

        // Jadwal
        const jad = el("div", "p-jadwal");
        jad.appendChild(el("div", "info",
            o.tanggal ? (o.tanggal.label + " · " + rentangJam(o.jam, durasiTotal(o))) : "Jadwal belum dipilih"));

        const btn = el("button", "btn-line", o.tanggal ? "Ubah tanggal dan jam" : "Pilih tanggal dan jam");
        btn.type = "button";
        btn.onclick = function () { bukaJadwal(i); };
        jad.appendChild(btn);
        card.appendChild(jad);

        // Estimasi Durasi & Subtotal
        card.appendChild(el("div", "info p-durasi", "Estimasi durasi: " + formatDurasi(durasiTotal(o))));

        const st = el("div", "p-sub-total", "Subtotal " + rupiah(subtotal(o)));
        card.appendChild(st);

        wrap.appendChild(card);
    });
}

function perbarui(card, o) {
    const st = card.querySelector(".p-sub-total");
    const dur = card.querySelector(".p-durasi");
    if (st) st.textContent = "Subtotal " + rupiah(subtotal(o));
    if (dur) dur.textContent = "Estimasi durasi: " + formatDurasi(durasiTotal(o));
    renderRincian();
}

/* Render Rincian Pembayaran */
function renderRincian() {
    const box = document.getElementById("rincian");
    if (!box) return;
    box.innerHTML = "";

    orang.forEach(function (o, i) {
        const blok = el("div", "rc-orang");

        const head = el("div", "rc-row head");
        head.appendChild(el("span", "", namaTampil(o, i)));
        head.appendChild(el("span", "", rupiah(subtotal(o))));
        blok.appendChild(head);

        if (o.layanan.length === 0) {
            blok.appendChild(el("div", "rc-row muted", "Belum ada layanan dipilih"));
        } else {
            o.layanan.forEach(function (n) {
                const r = el("div", "rc-row");
                r.appendChild(el("span", "", n + " (± " + formatDurasi(durasiLayanan(n)) + ")"));
                r.appendChild(el("span", "", rupiah(harga(n))));
                blok.appendChild(r);
            });
        }

        blok.appendChild(el("div", "rc-row muted", "Pegawai: " + (o.pegawai || "-")));
        blok.appendChild(el("div", "rc-row muted", "Estimasi durasi: " + formatDurasi(durasiTotal(o))));
        blok.appendChild(el("div", "rc-row muted",
            "Jadwal: " + (o.tanggal ? o.tanggal.label + ", " + rentangJam(o.jam, durasiTotal(o)) : "-")));

        box.appendChild(blok);
    });

    const tot = el("div", "rc-total");
    tot.appendChild(el("span", "", "Total bayar (" + orang.length + " orang)"));
    tot.appendChild(el("span", "", rupiah(totalSemua())));
    box.appendChild(tot);
}

function tambahOrang() {
    orang.push(orangBaru("", false));
    renderOrang();
    renderRincian();
}

/* Cek bentrok jam pegawai */
function bentrok(indeks, iso, jam) {
    const peg = orang[indeks].pegawai;
    if (!peg) return false;

    const mulai = menit(jam);
    const selesai = mulai + durasiTotal(orang[indeks]);

    return orang.some(function (o, i) {
        if (i === indeks || o.pegawai !== peg || !o.tanggal || o.tanggal.iso !== iso) {
            return false;
        }
        const m2 = menit(o.jam);
        return mulai < m2 + durasiTotal(o) && m2 < selesai;
    });
}

/* Logika Modal Jadwal */
function bukaJadwal(i) {
    const o = orang[i];

    if (o.layanan.length === 0) {
        alert("Pilih minimal satu layanan untuk " + namaTampil(o, i) + " terlebih dahulu.");
        return;
    }

    if (o.pegawai === "") {
        alert("Pilih pegawai yang melayani " + namaTampil(o, i) + " terlebih dahulu.");
        return;
    }

    aktif = i;
    tmp = { tanggal: o.tanggal, jam: o.jam };

    const jmJudul = document.getElementById("jmJudul");
    const jmInfo = document.getElementById("jmInfo");
    if (jmJudul) jmJudul.textContent = "Jadwal " + namaTampil(o, i);
    if (jmInfo) {
        jmInfo.textContent = "Pegawai: " + o.pegawai + " · Estimasi durasi: " + formatDurasi(durasiTotal(o))
            + " · Salon tutup pukul " + pad(JAM_TUTUP) + ".00";
    }

    buatTanggal();
    buatJam();
    ringkasPopup();

    const jmOverlay = document.getElementById("jmOverlay");
    if (jmOverlay) jmOverlay.classList.add("show");
}

function tutupJadwal() {
    const jmOverlay = document.getElementById("jmOverlay");
    if (jmOverlay) jmOverlay.classList.remove("show");
    aktif = -1;
}

function buatTanggal() {
    const grid = document.getElementById("jmDates");
    if (!grid) return;
    grid.innerHTML = "";

    const hariIni = new Date();

    for (let n = 0; n < 14; n++) {
        const d = new Date();
        d.setDate(hariIni.getDate() + n);

        const iso = isoTanggal(d);
        const label = labelTanggal(d);

        const c = el("div", "date", d.getDate() + " " + d.toLocaleDateString("id-ID", { month: "short" }));

        if (tmp.tanggal && tmp.tanggal.iso === iso) c.classList.add("active");

        c.onclick = function () {
            grid.querySelectorAll(".date").forEach(function (x) { x.classList.remove("active"); });
            c.classList.add("active");

            if (!tmp.tanggal || tmp.tanggal.iso !== iso) tmp.jam = "";
            tmp.tanggal = { iso: iso, label: label };

            buatJam();
            ringkasPopup();
        };

        grid.appendChild(c);
    }
}

function buatJam() {
    const grid = document.getElementById("jmTimes");
    if (!grid) return;
    grid.innerHTML = "";

    if (!tmp.tanggal) {
        grid.appendChild(el("div", "info", "Pilih tanggal terlebih dahulu."));
        return;
    }

    const sekarang = new Date();
    const menitSekarang = sekarang.getHours() * 60 + sekarang.getMinutes();
    const hariIni = isoTanggal(sekarang) === tmp.tanggal.iso;

    for (let h = JAM_BUKA; h <= JAM_TUTUP; h++) {
        const waktu = pad(h) + ":00";
        const c = el("div", "time", waktu);

        const lewat = hariIni && h * 60 <= menitSekarang;
        const penuh = bentrok(aktif, tmp.tanggal.iso, waktu);
        const lewatTutup = h * 60 + durasiTotal(orang[aktif]) > JAM_TUTUP * 60;

        if (lewat || penuh || lewatTutup) {
            c.classList.add("off");
            c.title = lewat ? "Jam sudah lewat"
                : (lewatTutup ? "Layanan tidak selesai sebelum salon tutup"
                    : "Pegawai sudah dipakai di jam ini");
        } else {
            if (tmp.jam === waktu) c.classList.add("active");

            c.onclick = function () {
                grid.querySelectorAll(".time").forEach(function (x) { x.classList.remove("active"); });
                c.classList.add("active");
                tmp.jam = waktu;
                ringkasPopup();
            };
        }

        grid.appendChild(c);
    }
}

function ringkasPopup() {
    const o = orang[aktif];
    const box = document.getElementById("jmRingkas");
    if (!box) return;
    box.innerHTML = "";

    const head = el("div", "rc-row head");
    head.appendChild(el("span", "", "Ringkasan " + namaTampil(o, aktif)));
    box.appendChild(head);

    o.layanan.forEach(function (n) {
        const r = el("div", "rc-row");
        r.appendChild(el("span", "", n));
        r.appendChild(el("span", "", rupiah(harga(n))));
        box.appendChild(r);
    });

    box.appendChild(el("div", "rc-row muted", "Pegawai: " + o.pegawai));
    box.appendChild(el("div", "rc-row muted", "Estimasi durasi: " + formatDurasi(durasiTotal(o))));
    box.appendChild(el("div", "rc-row muted",
        "Jadwal: " + (tmp.tanggal ? tmp.tanggal.label : "-")
        + (tmp.jam ? ", " + rentangJam(tmp.jam, durasiTotal(o)) : "")));

    const tot = el("div", "rc-total");
    tot.appendChild(el("span", "", "Total"));
    tot.appendChild(el("span", "", rupiah(subtotal(o))));
    box.appendChild(tot);

    const btnSimpan = document.getElementById("jmSimpan");
    if (btnSimpan) btnSimpan.disabled = !(tmp.tanggal && tmp.jam);
}

function simpanJadwal() {
    if (!tmp.tanggal || !tmp.jam) return;

    orang[aktif].tanggal = tmp.tanggal;
    orang[aktif].jam = tmp.jam;

    tutupJadwal();
    renderOrang();
    renderRincian();
}

// Overlay dismiss
const jmOverlayEl = document.getElementById("jmOverlay");
if (jmOverlayEl) {
    jmOverlayEl.addEventListener("click", function (e) {
        if (e.target === this) tutupJadwal();
    });
}

// Pratinjau Bukti Transfer
const buktiEl = document.getElementById("bukti");
if (buktiEl) {
    buktiEl.addEventListener("change", function () {
        const file = this.files[0];
        const nama = document.getElementById("namaFile");
        const preview = document.getElementById("previewBukti");

        if (preview) preview.style.display = "none";

        if (!file) {
            if (nama) nama.textContent = "Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).";
            return;
        }

        if (file.size > MAX_UKURAN) {
            alert("Ukuran file maksimal 2 MB.");
            this.value = "";
            if (nama) nama.textContent = "Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).";
            return;
        }

        if (nama) nama.textContent = "File: " + file.name;

        if (file.type.startsWith("image/") && preview) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = "block";
        }
    });
}

// Konfirmasi Reservasi
function konfirmasi() {
    for (let i = 0; i < orang.length; i++) {
        const o = orang[i];
        const nama = namaTampil(o, i);

        if (!o.utama && o.nama.trim() === "") {
            alert("Isi nama untuk Orang " + (i + 1) + ".");
            return;
        }

        if (o.layanan.length === 0) {
            alert("Pilih layanan untuk " + nama + ".");
            return;
        }

        if (o.pegawai === "") {
            alert("Pilih pegawai yang melayani " + nama + ".");
            return;
        }

        if (!o.tanggal || !o.jam) {
            alert("Pilih tanggal dan jam untuk " + nama + ".");
            return;
        }
    }

    const bukti = document.getElementById("bukti").files[0];
    if (!bukti) {
        alert("Upload bukti transfer terlebih dahulu.");
        return;
    }

    let teks = "Reservasi berhasil diajukan!\\n\\nSalon: " + SALON + "\\n";

    orang.forEach(function (o, i) {
        teks += "\\n" + namaTampil(o, i) + "\\n"
            + "  Layanan: " + o.layanan.join(", ") + "\\n"
            + "  Pegawai: " + o.pegawai + "\\n"
            + "  Jadwal: " + o.tanggal.label + ", " + rentangJam(o.jam, durasiTotal(o))
            + " (± " + formatDurasi(durasiTotal(o)) + ")\\n"
            + "  Subtotal: " + rupiah(subtotal(o)) + "\\n";
    });

    teks += "\\nTotal bayar: " + rupiah(totalSemua())
        + "\\nBukti transfer: " + bukti.name;

    alert(teks);
}

// Mulai rendering awal saat DOM siap
renderOrang();
renderRincian();
</script>
';

require __DIR__ . '/includes/header.php';
?>

<!-- ===== HERO HALAMAN BOOKING ===== -->
<div class="hero hero-booking">
    <div class="hero-content">
        <span class="eyebrow">FORMULIR RESERVASI</span>
        <h1>Reservasi di <?= e($salon) ?></h1>
        <p>Tentukan perawatan pilihanmu, pilih stylist terbaik, dan tentukan waktu yang paling pas.</p>
    </div>
</div>

<!-- ===== KONTEN FORM RESERVASI ===== -->
<div class="app">
    <div class="content">
        <div class="card">

            <label>Salon Terpilih</label>
            <div class="salon">
                <b><?= e($salon) ?></b>
                <div class="info">&bull; Jam Buka: 09.00 - 20.00 WIB</div>
                <div class="info">&bull; Fasilitas: WiFi &middot; Parkir &middot; Ruang Tunggu &middot; AC</div>
            </div>

            <label>Orang yang Dibooking</label>
            <!-- Kontainer kartu tiap orang dimuat oleh JavaScript -->
            <div id="people"></div>

            <button type="button" class="add" onclick="tambahOrang()">+ Tambah orang</button>

            <label style="margin-top: 30px;">Rincian Pembayaran</label>
            <div class="pay-box" id="rincian"></div>

            <label style="margin-top: 20px;">Metode Pembayaran</label>
            <div class="pay-box">
                <b>Transfer Bank (Bayar Penuh)</b>
                <div class="info">Bank BCA &middot; 1234567890</div>
                <div class="info">a.n. Reservin Official (<?= e($salon) ?>)</div>
            </div>

            <label style="margin-top: 20px;" for="bukti">Upload Bukti Transfer</label>
            <div class="upload-box">
                <input type="file" id="bukti" accept="image/*,application/pdf">
                <div class="info" id="namaFile">Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).</div>
                <img id="previewBukti" alt="Pratinjau bukti transfer">
            </div>

            <button type="button" class="btn" onclick="konfirmasi()">Konfirmasi Reservasi</button>

        </div>
    </div>
</div>

<!-- Modal Jadwal Reservasi -->
<?php require __DIR__ . '/modals/modal_jadwal_booking.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
