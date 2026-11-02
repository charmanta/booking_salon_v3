<?php
/* =====================================================================
   RESERVIN — LAYANAN SALON ADMIN (admin/layanan.php)
   Halaman daftar dan manajemen layanan (Creambath, Hair Spa, dll.)
   Termasuk fitur modal Tambah Layanan, Edit, dan Hapus.
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
// Script khusus halaman layanan (modal buka, tutup, simpan, hapus)
$extra_js = '
<script>
(function () {
    const modal = document.getElementById("modal");

    function buka(judul, nama, harga, durasi, ket) {
        document.getElementById("modalTitle").textContent = judul;
        document.getElementById("nama").value = nama;
        document.getElementById("harga").value = harga;
        document.getElementById("durasi").value = durasi;
        document.getElementById("keterangan").value = ket;
        modal.classList.add("show");
        document.getElementById("nama").focus();
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
        if (document.getElementById("nama").value.trim() === "") {
            alert("Nama layanan belum diisi.");
            return;
        }
        alert("Data layanan berhasil disimpan.");
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
