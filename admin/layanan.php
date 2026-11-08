<?php
/* =====================================================================
   RESERVIN — LAYANAN SALON ADMIN (admin/layanan.php)
   Halaman daftar dan manajemen layanan (Creambath, Hair Spa, dll.)
   Termasuk fitur modal Tambah Layanan, Edit, dan Hapus, serta
   pengelolaan warna rambut untuk layanan pewarnaan (Kelola Warna).
   ===================================================================== */

$page_title   = 'Layanan Salon';
$current_page = 'layanan.php';

require_once __DIR__ . '/includes/init.php';

/* ===== DATA CONTOH LAYANAN (Nantinya diganti dari database) ===== */
/* [nama, harga, durasi (menit), keterangan] */
$layanan = [
    ['Creambath',     100000, 60,  'Perawatan rambut dan kulit kepala.'],
    ['Hair Spa',      150000, 90,  'Perawatan rambut intensif.'],
    ['Potong Rambut',  50000, 45,  'Potong rambut sesuai model pilihan.'],
    ['Hair Coloring', 250000, 120, 'Pewarnaan rambut sesuai pilihan pelanggan.'],
];

/* ===== DATA CONTOH WARNA RAMBUT (Nantinya diganti dari database) ===== */
/* nama, kode warna (hex), tersedia (true = tampil di booking customer) */
$warna = [
    ['nama' => 'Hitam',      'hex' => '#1c1512', 'tersedia' => true],
    ['nama' => 'Dark Brown', 'hex' => '#3b2418', 'tersedia' => true],
    ['nama' => 'Chestnut',   'hex' => '#8a4b2d', 'tersedia' => true],
    ['nama' => 'Copper',     'hex' => '#c8753d', 'tersedia' => false],
    ['nama' => 'Burgundy',   'hex' => '#6d1a36', 'tersedia' => true],
    ['nama' => 'Ash Blonde', 'hex' => '#c9b79c', 'tersedia' => true],
];

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- KEPALA HALAMAN & TOMBOL TAMBAH -->
<div class="ad-sapa-baris">
    <section class="ad-sapa">
        <h1>Layanan Salon</h1>
        <p>Kelola layanan yang tersedia di salon Anda.</p>
    </section>

    <button type="button" class="ad-btn utama" id="btnTambah">
        <?= ikon('plus') ?> Tambah Layanan
    </button>
</div>

<!-- DAFTAR LAYANAN -->
<section class="ad-kartu">
    <div class="ad-kartu-head">
        <h2>Daftar Layanan</h2>
        <span class="ad-jumlah"><?= count($layanan) ?> layanan</span>
    </div>

    <div class="ad-tabel-box">
        <table class="ad-tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Layanan</th>
                    <th>Harga</th>
                    <th>Durasi</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($layanan as $i => $l): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td class="nama"><?= e($l[0]) ?></td>
                        <td class="harga"><?= e(rupiah($l[1])) ?></td>
                        <td class="durasi"><?= (int)$l[2] ?> menit</td>
                        <td class="ket"><?= e($l[3]) ?></td>
                        <td>
                            <div class="ad-aksi-sel">
                                <button type="button" class="ad-mini btn-edit"
                                    data-nama="<?= e($l[0]) ?>"
                                    data-harga="<?= (int)$l[1] ?>"
                                    data-durasi="<?= (int)$l[2] ?>"
                                    data-ket="<?= e($l[3]) ?>">
                                    <?= ikon('edit') ?> Edit
                                </button>
                                <button type="button" class="ad-mini bahaya btn-hapus" data-nama="<?= e($l[0]) ?>">
                                    <?= ikon('hapus') ?> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- MODAL TAMBAH / EDIT LAYANAN -->
<?php require __DIR__ . '/modals/modal_layanan.php'; ?>

<?php
// Style panel Kelola Warna + script khusus halaman layanan (modal buka, tutup, simpan, hapus, kelola warna)
$extra_js = '
<style>
/* ===== PANEL KELOLA WARNA (di dalam modal layanan) ===== */
.ad-warna {
    display: none;
    margin-top: 6px;
    padding-top: 20px;
    border-top: 1px solid var(--line);
}
.ad-warna.show {
    display: block;
    animation: cmFadeUp .3s cubic-bezier(0.16, 1, 0.3, 1) both;
}
.ad-warna-head h3 {
    margin: 0;
    font-family: var(--serif);
    font-size: 21px;
    font-weight: 600;
    letter-spacing: .02em;
}
.ad-warna-head p {
    margin: 4px 0 14px;
    font-size: 13.5px;
    color: var(--muted);
}
.ad-warna-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 18px;
}
.ad-warna-row {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 10px;
    transition: background-color .18s ease, opacity .18s ease;
}
.ad-warna-row.off { background: #faf6f0; }
.ad-warna-row.off .ad-warna-sw,
.ad-warna-row.off .ad-warna-nama { opacity: .55; }
.ad-warna-sw {
    width: 26px;
    height: 26px;
    border-radius: 6px;
    flex: none;
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .12);
}
.ad-warna-nama {
    flex: 1;
    min-width: 0;
    font-size: 15px;
    font-weight: 500;
    overflow-wrap: anywhere;
}
.ad-warna-st {
    font-size: 12.5px;
    color: var(--muted);
    white-space: nowrap;
}
.ad-warna-row:not(.off) .ad-warna-st { color: var(--ok-ink); }

/* Toggle tersedia */
.ad-switch {
    position: relative;
    width: 42px;
    height: 24px;
    flex: none;
    cursor: pointer;
}
.ad-switch input {
    position: absolute;
    opacity: 0;
    inset: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    cursor: pointer;
}
.ad-switch .sl {
    position: absolute;
    inset: 0;
    background: #d5c8be;
    border-radius: 999px;
    transition: background-color .2s ease;
    pointer-events: none;
}
.ad-switch .sl::after {
    content: "";
    position: absolute;
    top: 3px;
    left: 3px;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 1px 3px rgba(0, 0, 0, .25);
    transition: transform .2s cubic-bezier(0.34, 1.56, 0.64, 1);
}
.ad-switch input:checked + .sl { background: var(--tan); }
.ad-switch input:checked + .sl::after { transform: translateX(18px); }
.ad-switch input:focus-visible + .sl {
    outline: 2px solid var(--tan);
    outline-offset: 2px;
}

.ad-warna-hapus {
    width: 32px;
    height: 32px;
    padding: 0;
    flex: none;
    display: grid;
    place-items: center;
    background: transparent;
    border: 0;
    border-radius: 8px;
    color: var(--bad-ink);
    cursor: pointer;
    transition: background-color .18s ease, transform .16s ease;
}
.ad-warna-hapus:hover { background: var(--bad-bg); }
.ad-warna-hapus:active { transform: scale(0.9); }
.ad-warna-hapus svg { width: 18px; height: 18px; }

.ad-warna-kosong {
    padding: 16px;
    text-align: center;
    font-size: 13.5px;
    color: var(--muted);
    border: 1px dashed var(--line);
    border-radius: 10px;
}

/* Tambah warna baru */
.ad-warna-tambah {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto auto;
    align-items: end;
    gap: 12px;
    padding: 14px;
    background: #faf6f0;
    border: 1px solid var(--line);
    border-radius: 10px;
}
.ad-warna-tambah .ad-field { margin: 0; }
.ad-warna-tambah input[type="color"] {
    width: 64px;
    height: 46px;
    padding: 4px;
    background: #fff;
    border: 1px solid var(--line);
    border-radius: 10px;
    cursor: pointer;
}
.ad-warna-tambah .ad-btn { height: 46px; }
.ad-warna-catatan {
    margin: 12px 0 0;
    font-size: 12.5px;
    color: var(--muted);
}
@media (max-width: 520px) {
    .ad-warna-tambah { grid-template-columns: 1fr 1fr; }
    .ad-warna-tambah .ad-field:first-child { grid-column: 1 / -1; }
}
</style>
<script>
(function () {
    const modal = document.getElementById("modal");

    /* ===== DATA WARNA: salinan tersimpan + salinan yang sedang diedit ===== */
    const WARNA_AWAL = ' . json_encode($warna, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';
    let warnaTersimpan = salin(WARNA_AWAL);
    let warnaKerja     = salin(WARNA_AWAL);

    const panelWarna = document.getElementById("panelWarna");
    const listWarna  = document.getElementById("listWarna");
    const inputNama  = document.getElementById("nama");
    const warnaNama  = document.getElementById("warnaNama");
    const warnaHex   = document.getElementById("warnaHex");

    const IKON_HAPUS = "<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"1.8\" stroke-linecap=\"round\" stroke-linejoin=\"round\" aria-hidden=\"true\"><path d=\"M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3\"/></svg>";

    function salin(a) {
        return JSON.parse(JSON.stringify(a));
    }

    function el(tag, cls, teks) {
        const e = document.createElement(tag);
        if (cls) e.className = cls;
        if (teks !== undefined) e.textContent = teks;
        return e;
    }

    /* Panel Kelola Warna hanya untuk layanan pewarnaan */
    function layananPewarnaan(nama) {
        return /color|warna/i.test(nama);
    }

    function aturPanel() {
        panelWarna.classList.toggle("show", layananPewarnaan(inputNama.value));
    }

    function renderWarna() {
        listWarna.innerHTML = "";

        if (warnaKerja.length === 0) {
            listWarna.appendChild(el("div", "ad-warna-kosong", "Belum ada warna. Tambahkan warna pertama di bawah."));
            return;
        }

        warnaKerja.forEach(function (w, i) {
            const row = el("div", "ad-warna-row" + (w.tersedia ? "" : " off"));

            const sw = el("span", "ad-warna-sw");
            sw.style.background = w.hex;
            row.appendChild(sw);

            row.appendChild(el("span", "ad-warna-nama", w.nama));
            row.appendChild(el("span", "ad-warna-st", w.tersedia ? "Tersedia" : "Nonaktif"));

            const tg = el("label", "ad-switch");
            tg.title = w.tersedia ? "Nonaktifkan warna" : "Aktifkan warna";
            const cb = document.createElement("input");
            cb.type = "checkbox";
            cb.checked = w.tersedia;
            cb.setAttribute("aria-label", "Warna " + w.nama + " tersedia");
            cb.onchange = function () {
                w.tersedia = cb.checked;
                renderWarna();
            };
            tg.appendChild(cb);
            tg.appendChild(el("span", "sl"));
            row.appendChild(tg);

            const del = el("button", "ad-warna-hapus");
            del.type = "button";
            del.setAttribute("aria-label", "Hapus warna " + w.nama);
            del.innerHTML = IKON_HAPUS;
            del.onclick = function () {
                if (confirm("Hapus warna " + w.nama + "?")) {
                    warnaKerja.splice(i, 1);
                    renderWarna();
                }
            };
            row.appendChild(del);

            listWarna.appendChild(row);
        });
    }

    function tambahWarna() {
        const nama = warnaNama.value.trim();

        if (nama === "") {
            alert("Nama warna belum diisi.");
            warnaNama.focus();
            return;
        }

        const ganda = warnaKerja.some(function (w) {
            return w.nama.toLowerCase() === nama.toLowerCase();
        });
        if (ganda) {
            alert("Warna " + nama + " sudah ada di daftar.");
            return;
        }

        warnaKerja.push({ nama: nama, hex: warnaHex.value, tersedia: true });
        warnaNama.value = "";
        renderWarna();
    }

    document.getElementById("btnTambahWarna").addEventListener("click", tambahWarna);
    warnaNama.addEventListener("keydown", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            tambahWarna();
        }
    });
    inputNama.addEventListener("input", aturPanel);

    /* ===== MODAL LAYANAN ===== */
    function buka(judul, nama, harga, durasi, ket) {
        document.getElementById("modalTitle").textContent = judul;
        inputNama.value = nama;
        document.getElementById("harga").value = harga;
        document.getElementById("durasi").value = durasi;
        document.getElementById("keterangan").value = ket;

        // Mulai dari data warna yang sudah tersimpan (perubahan yang dibatalkan dibuang)
        warnaKerja = salin(warnaTersimpan);
        warnaNama.value = "";
        aturPanel();
        renderWarna();

        modal.classList.add("show");
        inputNama.focus();
    }

    function tutup() {
        modal.classList.remove("show");
    }

    document.getElementById("btnTambah").addEventListener("click", function () {
        buka("Tambah Layanan", "", "", "", "");
    });

    document.querySelectorAll(".btn-edit").forEach(function (b) {
        b.addEventListener("click", function () {
            buka("Edit Layanan", b.dataset.nama, b.dataset.harga, b.dataset.durasi, b.dataset.ket);
        });
    });

    document.querySelectorAll(".btn-hapus").forEach(function (b) {
        b.addEventListener("click", function () {
            if (confirm("Hapus layanan " + b.dataset.nama + "?")) {
                alert("Layanan " + b.dataset.nama + " berhasil dihapus.");
            }
        });
    });

    document.getElementById("btnSimpan").addEventListener("click", function () {
        if (inputNama.value.trim() === "") {
            alert("Nama layanan belum diisi.");
            return;
        }

        // TODO: kirim data layanan + daftar warna (warnaKerja) ke server / database
        if (panelWarna.classList.contains("show")) {
            warnaTersimpan = salin(warnaKerja);
            alert("Data layanan dan warna berhasil disimpan.");
        } else {
            alert("Data layanan berhasil disimpan.");
        }
        tutup();
    });

    document.getElementById("btnBatal").addEventListener("click", tutup);
    document.getElementById("btnX").addEventListener("click", tutup);

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