<?php
/* =====================================================================
   RESERVIN — PILIH SALON (customer/pilih_salon.php)
   Halaman pemilihan cabang salon:
   - Carousel pilihan salon terdaftar
   - Modal konfirmasi pemilihan salon
   - Tombol geser interaktif
   ===================================================================== */
require_once __DIR__ . '/includes/init.php';

$page_title   = 'Pilih Salon';
$current_page = 'pilih_salon.php';
$body_class   = 'p-pilih';

// Data daftar salon (dapat dihubungkan ke database jika diperlukan)
$daftarSalon = [
    [
        'nama'      => 'Luna Salon',
        'gambar'    => '../assets/images/hair_left2.jpg',
        'kota_jam'  => 'Bandung · 09.00–20.00',
        'alamat'    => 'Jl. Merdeka No. 25, Bandung',
        'fasilitas' => ['WiFi', 'AC', 'Parkir', 'Ruang Tunggu'],
    ],
    [
        'nama'      => 'Salon Anggun',
        'gambar'    => '../assets/images/hair_center2.jpg',
        'kota_jam'  => 'Jakarta · 10.00–21.00',
        'alamat'    => 'Jl. Sudirman No. 18, Jakarta',
        'fasilitas' => ['WiFi', 'AC', 'Parkir', 'Toilet'],
    ],
    [
        'nama'      => 'Ayu Salon',
        'gambar'    => '../assets/images/hair_right2.jpg',
        'kota_jam'  => 'Surabaya · 09.00–19.00',
        'alamat'    => 'Jl. Diponegoro No. 10, Surabaya',
        'fasilitas' => ['WiFi', 'AC', 'Parkir', 'Toilet'],
    ],
    [
        'nama'      => 'Glow Hair Studio',
        'gambar'    => '../assets/images/products.jpg',
        'kota_jam'  => 'Jakarta · 09.00–20.00',
        'alamat'    => 'Jl. Kemang Raya No. 8, Jakarta',
        'fasilitas' => ['Hair Spa', 'Coloring', 'AC'],
    ],
];

// Script interaktivitas carousel dan modal konfirmasi
$extra_js = '
<script>
var salonDipilih = "";

function pilihSalon(nama) {
    salonDipilih = nama;
    var elNama = document.getElementById("namaSalon");
    var elModal = document.getElementById("modalSalon");
    if (elNama) elNama.textContent = nama;
    if (elModal) elModal.style.display = "flex";
}

function tutupModal() {
    var elModal = document.getElementById("modalSalon");
    if (elModal) elModal.style.display = "none";
}

function lanjutBooking() {
    if (!salonDipilih) return;
    window.location.href = "booking.php?salon=" + encodeURIComponent(salonDipilih);
}

function slide(d) {
    var c = document.getElementById("salonCarousel");
    if (c) c.scrollBy({ left: d * 390, behavior: "smooth" });
}

(function () {
    var c = document.getElementById("salonCarousel");
    if (!c) return;

    var down = false, startX = 0, scrollLeft = 0;

    c.addEventListener("mousedown", function (e) {
        down = true;
        startX = e.pageX - c.offsetLeft;
        scrollLeft = c.scrollLeft;
        c.classList.add("dragging");
    });

    window.addEventListener("mouseup", function () {
        down = false;
        c.classList.remove("dragging");
    });

    c.addEventListener("mousemove", function (e) {
        if (!down) return;
        e.preventDefault();
        c.scrollLeft = scrollLeft - (e.pageX - c.offsetLeft - startX) * 1.2;
    });
})();
</script>
';

require __DIR__ . '/includes/header.php';
?>

<!-- ===== KONTEN UTAMA PILIH SALON ===== -->
<main class="select-page">

    <div class="select-heading">
        <span class="eyebrow">STEP 01</span>
        <h1>Pilih salon yang kamu suka.</h1>
        <p>Geser ke samping untuk melihat salon dan cabang lainnya.</p>
    </div>

    <!-- Tombol Navigasi Slider Carousel -->
    <div class="slider-actions select-actions">
        <button type="button" onclick="slide(-1)" aria-label="Geser salon ke kiri">&larr;</button>
        <button type="button" onclick="slide(1)" aria-label="Geser salon ke kanan">&rarr;</button>
    </div>

    <!-- Carousel Kartu Salon -->
    <div class="salon-carousel" id="salonCarousel">
        <?php foreach ($daftarSalon as $s): ?>
            <article class="salon-card-new">
                <img src="<?= e($s['gambar']) ?>" alt="<?= e($s['nama']) ?>" loading="lazy">
                <div class="salon-card-body">
                    <span><?= e($s['kota_jam']) ?></span>
                    <h2><?= e($s['nama']) ?></h2>
                    <p><?= e($s['alamat']) ?></p>
                    
                    <div class="chips">
                        <?php foreach ($s['fasilitas'] as $f): ?>
                            <b><?= e($f) ?></b>
                        <?php endforeach; ?>
                    </div>

                    <button type="button" onclick="pilihSalon(<?= json_encode($s['nama']) ?>)">
                        Pilih Salon &rarr;
                    </button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</main>

<!-- Modal Konfirmasi Salon -->
<?php require __DIR__ . '/modals/modal_pilih_salon.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
