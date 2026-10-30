<?php
$salon = $_GET['salon'] ?? 'Luna Salon';

// Daftar layanan (sementara statis, nanti bisa diganti dari database)
$layanan = [
    ['nama' => 'Creambath',     'harga' => 100000],
    ['nama' => 'Potong Rambut', 'harga' => 75000],
    ['nama' => 'Facial',        'harga' => 120000],
    ['nama' => 'Hair Spa',      'harga' => 150000],
];

// Daftar pegawai (sementara statis, nanti bisa diganti dari database)
$pegawai = [
    'Rani - Hair Stylist',
    'Dewi - Hair Stylist',
    'Sinta - Beautician',
    'Putri - Terapis',
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
    <style>
        /* ===== Kartu orang ===== */
        .person .p-head { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
        .person .p-hapus { background: none; border: 0; color: var(--muted); font-family: inherit; font-size: 13px; cursor: pointer; text-decoration: underline; }
        .person .p-nama { width: 100%; margin-top: 10px; }
        .person .p-sub { font-size: 12px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; color: var(--muted); margin: 18px 0 8px; display: block; }
        .person .cb { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 8px 0; cursor: pointer; text-transform: none; letter-spacing: 0; font-weight: 500; font-size: 15px; margin: 0; }
        .person .cb span { display: flex; align-items: center; gap: 10px; }
        .person .cb em { font-style: normal; color: var(--muted); }
        .person select { width: 100%; }
        .person .p-jadwal { margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap; }
        .person .p-jadwal .info { margin: 0; }
        .btn-line { font-family: inherit; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; background: transparent; border: 1px solid var(--ink); color: var(--ink); padding: 12px 20px; cursor: pointer; }
        .btn-line:hover { background: var(--ink); color: var(--cream); }
        .person .p-sub-total { margin-top: 14px; text-align: right; font-weight: 700; font-size: 15px; }

        /* ===== Rincian & pembayaran ===== */
        .pay-box { background: var(--white); border: 1px solid var(--line); padding: 20px 24px; margin-bottom: 12px; }
        .pay-box b { font-size: 17px; letter-spacing: .06em; text-transform: uppercase; }
        .rc-orang { padding: 14px 0; border-bottom: 1px solid var(--line); }
        .rc-orang:first-child { padding-top: 0; }
        .rc-row { display: flex; justify-content: space-between; gap: 12px; font-size: 14px; margin-top: 4px; }
        .rc-row.head { font-weight: 700; font-size: 15px; margin-top: 0; }
        .rc-row.muted { color: var(--muted); }
        .rc-total { display: flex; justify-content: space-between; margin-top: 16px; font-weight: 800; font-size: 20px; }
        .upload-box { background: var(--white); border: 1px dashed var(--ink); padding: 20px 24px; }
        .upload-box input[type="file"] { width: 100%; font-family: inherit; font-size: 14px; }
        #previewBukti { display: none; max-width: 100%; max-height: 320px; margin-top: 14px; border: 1px solid var(--line); }
        #namaFile { margin-top: 10px; }

        /* ===== Popup jadwal ===== */
        .jm-overlay { display: none; position: fixed; inset: 0; z-index: 200; background: rgba(48,30,24,.55); align-items: center; justify-content: center; padding: 16px; }
        .jm-overlay.show { display: flex; }
        .jm-box { background: var(--cream, #faf6f0); width: 100%; max-width: 640px; max-height: 92vh; overflow-y: auto; padding: 32px; }
        .jm-box h3 { font-family: var(--serif); font-weight: 500; font-size: 30px; margin: 0 0 4px; }
        .jm-box .jm-sub { font-size: 12px; font-weight: 600; letter-spacing: .1em; text-transform: uppercase; margin: 22px 0 10px; display: block; }
        .jm-ringkas { background: var(--white); border: 1px solid var(--line); padding: 18px 20px; margin-top: 22px; }
        .jm-actions { display: flex; gap: 12px; margin-top: 20px; }
        .jm-actions button { flex: 1; font-family: inherit; font-size: 12px; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; padding: 16px; border: 1px solid var(--ink); cursor: pointer; background: transparent; color: var(--ink); }
        .jm-actions button.utama { background: var(--tan); border-color: var(--tan); }
        .jm-actions button:disabled { opacity: .4; cursor: not-allowed; }
        .p-booking .time.off { opacity: .35; cursor: not-allowed; text-decoration: line-through; }
    </style>
</head>
<body class="page-customer p-booking">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php">Beranda</a>
            <a href="booking.php" class="active">Reservasi</a>
            <a href="riwayat.php">Riwayat</a>
            <a href="https://gemini.google.com/" target="_blank">Tanya AI</a>
            <a href="../login.php">Keluar</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>


<div class="app">

    
    <div class="content">

        <div class="card">

            <label>Salon</label>

            <div class="salon">
                <b><?= htmlspecialchars($salon) ?></b>
                <div class="info">📍 Bandung</div>
                <div class="info">🕘 09.00 - 20.00</div>
                <div class="info">Fasilitas: WiFi · Parkir · Ruang Tunggu</div>
            </div>


            <label>Orang yang Dibooking</label>

            <!-- Kartu tiap orang dibuat oleh JavaScript -->
            <div id="people"></div>

            <button class="add" onclick="tambahOrang()">+ Tambah orang</button>


            <label style="margin-top:30px">Rincian Pembayaran</label>

            <div class="pay-box" id="rincian"></div>


            <label style="margin-top:20px">Pembayaran</label>

            <div class="pay-box">
                <b>Transfer Bank (bayar penuh)</b>
                <!-- Ganti dengan data rekening salon yang sebenarnya -->
                <div class="info">Bank BCA · 1234567890</div>
                <div class="info">a.n. <?= htmlspecialchars($salon) ?></div>
            </div>


            <label style="margin-top:20px" for="bukti">Upload Bukti Transfer</label>

            <div class="upload-box">
                <input type="file" id="bukti" accept="image/*,application/pdf">
                <div class="info" id="namaFile">Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).</div>
                <img id="previewBukti" alt="Pratinjau bukti transfer">
            </div>


            <button class="btn" onclick="konfirmasi()">Konfirmasi Reservasi</button>

        </div>

    </div>


    <!-- MENU BAWAH -->
    <div class="bottom">
        <a href="dashboard.php"><span class="icon">🏠</span>Beranda</a>
        <a href="booking.php" class="active"><span class="icon">📅</span>Reservasi</a>
        <a href="riwayat.php"><span class="icon">📋</span>Riwayat</a>
        <a href="https://gemini.google.com/" target="_blank"><span class="icon">💬</span>Tanya AI</a>
    </div>

</div>


<!-- ===== POPUP PILIH TANGGAL & JAM ===== -->
<div class="jm-overlay" id="jmOverlay">
    <div class="jm-box">
        <h3 id="jmJudul">Pilih jadwal</h3>
        <div class="info" id="jmInfo"></div>

        <span class="jm-sub">Pilih Tanggal</span>
        <div class="date-grid" id="jmDates"></div>

        <span class="jm-sub">Pilih Jam</span>
        <div class="time-grid" id="jmTimes">
            <div class="info">Pilih tanggal terlebih dahulu.</div>
        </div>

        <div class="jm-ringkas" id="jmRingkas"></div>

        <div class="jm-actions">
            <button onclick="tutupJadwal()">Batal</button>
            <button class="utama" id="jmSimpan" onclick="simpanJadwal()" disabled>Simpan jadwal</button>
        </div>
    </div>
</div>


<script>

const SALON   = <?= json_encode($salon) ?>;
const LAYANAN = <?= json_encode($layanan) ?>;
const PEGAWAI = <?= json_encode($pegawai) ?>;
const MAX_UKURAN = 2 * 1024 * 1024; // 2 MB
const JAM_BUKA = 9, JAM_TUTUP = 20;

/* Data tiap orang: layanan, pegawai, tanggal, jam */
function orangBaru(nama, utama) {
    return { nama: nama, utama: utama, layanan: [], pegawai: "", tanggal: null, jam: "" };
}

let orang = [ orangBaru("Saya", true) ];
let aktif = -1;                       // indeks orang yang sedang diatur jadwalnya
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

function el(tag, cls, teks) {
    const e = document.createElement(tag);
    if (cls) e.className = cls;
    if (teks !== undefined) e.textContent = teks;
    return e;
}


/* ===== KARTU ORANG ===== */

function renderOrang() {

    const wrap = document.getElementById("people");
    wrap.innerHTML = "";

    orang.forEach(function (o, i) {

        const card = el("div", "person");

        /* judul + hapus */
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

        /* layanan (boleh lebih dari satu, beda tiap orang) */
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
                perbarui(card, o);
            };

            kiri.appendChild(cb);
            kiri.appendChild(document.createTextNode(l.nama));
            row.appendChild(kiri);
            row.appendChild(el("em", "", rupiah(l.harga)));
            card.appendChild(row);
        });

        /* pegawai */
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
            /* ganti pegawai bisa membuat jadwal bentrok */
            if (o.tanggal && bentrok(i, o.tanggal.iso, o.jam)) {
                o.tanggal = null;
                o.jam = "";
                alert("Jadwal sebelumnya bentrok dengan pegawai ini. Silakan pilih ulang tanggal dan jam.");
            }
            renderOrang();
            renderRincian();
        };
        card.appendChild(sel);

        /* jadwal */
        const jad = el("div", "p-jadwal");
        jad.appendChild(el("div", "info",
            o.tanggal ? (o.tanggal.label + " · " + o.jam) : "Jadwal belum dipilih"));

        const btn = el("button", "btn-line", o.tanggal ? "Ubah tanggal dan jam" : "Pilih tanggal dan jam");
        btn.type = "button";
        btn.onclick = function () { bukaJadwal(i); };
        jad.appendChild(btn);
        card.appendChild(jad);

        /* subtotal */
        const st = el("div", "p-sub-total", "Subtotal " + rupiah(subtotal(o)));
        st.className = "p-sub-total";
        card.appendChild(st);

        wrap.appendChild(card);
    });
}

/* perbarui subtotal kartu & rincian tanpa menggambar ulang semua kartu */
function perbarui(card, o) {
    card.querySelector(".p-sub-total").textContent = "Subtotal " + rupiah(subtotal(o));
    renderRincian();
}


/* ===== RINCIAN PEMBAYARAN ===== */

function renderRincian() {

    const box = document.getElementById("rincian");
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
                r.appendChild(el("span", "", n));
                r.appendChild(el("span", "", rupiah(harga(n))));
                blok.appendChild(r);
            });
        }

        blok.appendChild(el("div", "rc-row muted",
            "Pegawai: " + (o.pegawai || "-")));
        blok.appendChild(el("div", "rc-row muted",
            "Jadwal: " + (o.tanggal ? o.tanggal.label + ", " + o.jam : "-")));

        box.appendChild(blok);
    });

    const tot = el("div", "rc-total");
    tot.appendChild(el("span", "", "Total bayar (" + orang.length + " orang)"));
    tot.appendChild(el("span", "", rupiah(totalSemua())));
    box.appendChild(tot);
}


/* ===== TAMBAH ORANG ===== */

function tambahOrang() {
    orang.push(orangBaru("", false));
    renderOrang();
    renderRincian();
}


/* ===== POPUP JADWAL ===== */

/* cek apakah pegawai yang sama sudah dipakai orang lain di jam yang sama */
function bentrok(indeks, iso, jam) {
    const peg = orang[indeks].pegawai;
    if (!peg) return false;
    return orang.some(function (o, i) {
        return i !== indeks && o.pegawai === peg && o.tanggal
            && o.tanggal.iso === iso && o.jam === jam;
    });
}

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

    document.getElementById("jmJudul").textContent = "Jadwal " + namaTampil(o, i);
    document.getElementById("jmInfo").textContent = "Pegawai: " + o.pegawai;

    buatTanggal();
    buatJam();
    ringkasPopup();

    document.getElementById("jmOverlay").classList.add("show");
}

function tutupJadwal() {
    document.getElementById("jmOverlay").classList.remove("show");
    aktif = -1;
}

function buatTanggal() {

    const grid = document.getElementById("jmDates");
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

        if (lewat || penuh) {
            c.classList.add("off");
            c.title = lewat ? "Jam sudah lewat" : "Pegawai sudah dipakai di jam ini";
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

/* ringkasan + total orang ini di dalam popup */
function ringkasPopup() {

    const o = orang[aktif];
    const box = document.getElementById("jmRingkas");
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
    box.appendChild(el("div", "rc-row muted",
        "Jadwal: " + (tmp.tanggal ? tmp.tanggal.label : "-") + (tmp.jam ? ", " + tmp.jam : "")));

    const tot = el("div", "rc-total");
    tot.appendChild(el("span", "", "Total"));
    tot.appendChild(el("span", "", rupiah(subtotal(o))));
    box.appendChild(tot);

    document.getElementById("jmSimpan").disabled = !(tmp.tanggal && tmp.jam);
}

function simpanJadwal() {

    if (!tmp.tanggal || !tmp.jam) return;

    orang[aktif].tanggal = tmp.tanggal;
    orang[aktif].jam = tmp.jam;

    tutupJadwal();
    renderOrang();
    renderRincian();
}

document.getElementById("jmOverlay").addEventListener("click", function (e) {
    if (e.target === this) tutupJadwal();
});


/* ===== PRATINJAU BUKTI TRANSFER ===== */

document.getElementById("bukti").addEventListener("change", function () {

    const file = this.files[0];
    const nama = document.getElementById("namaFile");
    const preview = document.getElementById("previewBukti");

    preview.style.display = "none";

    if (!file) {
        nama.textContent = "Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).";
        return;
    }

    if (file.size > MAX_UKURAN) {
        alert("Ukuran file maksimal 2 MB.");
        this.value = "";
        nama.textContent = "Belum ada file dipilih (JPG, PNG, atau PDF, maks. 2 MB).";
        return;
    }

    nama.textContent = "File: " + file.name;

    if (file.type.startsWith("image/")) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});


/* ===== KONFIRMASI ===== */

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

    let teks = "Reservasi berhasil dipilih!\n\nSalon: " + SALON + "\n";

    orang.forEach(function (o, i) {
        teks += "\n" + namaTampil(o, i) + "\n"
            + "  Layanan: " + o.layanan.join(", ") + "\n"
            + "  Pegawai: " + o.pegawai + "\n"
            + "  Jadwal: " + o.tanggal.label + ", " + o.jam + "\n"
            + "  Subtotal: " + rupiah(subtotal(o)) + "\n";
    });

    teks += "\nTotal bayar: " + rupiah(totalSemua())
        + "\nBukti transfer: " + bukti.name;

    alert(teks);
}


/* mulai */
renderOrang();
renderRincian();

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>