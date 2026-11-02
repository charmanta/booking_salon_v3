<?php
/* =====================================================================
   RESERVIN — DASHBOARD CUSTOMER (customer/dashboard.php)
   Halaman beranda pelanggan:
   - Hero sambutan pelanggan & CTA Booking
   - Quick navigation grid (Reservasi, Riwayat, Tanya AI)
   - Galeri inspirasi gaya rambut & salon
   ===================================================================== */
require_once __DIR__ . '/includes/init.php';

$page_title   = 'Dashboard';
$current_page = 'dashboard.php';
$body_class   = 'p-dashboard';

// Script interaktivitas slider galeri
$extra_js = '
<script>
function slide(d) {
    var gal = document.getElementById("gallery");
    if (gal) gal.scrollBy({ left: d * 390, behavior: "smooth" });
}

(function () {
    var g = document.getElementById("gallery");
    if (!g) return;

    var down = false, startX = 0, scrollLeft = 0;

    g.addEventListener("mousedown", function (e) {
        down = true;
        startX = e.pageX - g.offsetLeft;
        scrollLeft = g.scrollLeft;
        g.classList.add("dragging");
    });

    window.addEventListener("mouseup", function () {
        down = false;
        g.classList.remove("dragging");
    });

    g.addEventListener("mousemove", function (e) {
        if (!down) return;
        e.preventDefault();
        g.scrollLeft = scrollLeft - (e.pageX - g.offsetLeft - startX) * 1.2;
    });
})();
</script>
';

require __DIR__ . '/includes/header.php';
?>

<!-- ===== KONTEN UTAMA BERANDA ===== -->
<main class="customer-home">

    <!-- 1. Hero Sambutan -->
    <section class="customer-hero">
        <div class="hero-content">
            <span class="eyebrow"><?= e($cmUser['peran'] ?? 'RESERVIN MEMBER') ?></span>

            <h1>
                Hai, <?= e($cmUser['nama'] ?? 'Pelanggan') ?>.<br>
                <em>Siap tampil lebih fresh?</em>
            </h1>

            <p>Pilih salon favoritmu dan atur jadwal perawatan dengan mudah tanpa antre.</p>

            <a href="pilih_salon.php" class="btn btn-cta btn-booking">
                Booking Sekarang
            </a>
        </div>
    </section>

    <!-- 2. Grid Navigasi Cepat -->
    <section class="quick-grid">
        <a href="pilih_salon.php">
            <span>01</span>
            <h2>Reservasi</h2>
            <p>Pilih salon, layanan, stylist, dan tentukan waktu terbaikmu.</p>
            <span class="qg-arrow">&rarr;</span>
        </a>
        <a href="riwayat.php">
            <span>02</span>
            <h2>Riwayat</h2>
            <p>Lihat status reservasi, bukti invoice, dan ganti jadwal fleksibel.</p>
            <span class="qg-arrow">&rarr;</span>
        </a>
        <a href="https://gemini.google.com/" target="_blank" rel="noopener">
            <span>03</span>
            <h2>Tanya AI</h2>
            <p>Konsultasi tren rambut dan rekomendasi perawatan kecantikan.</p>
            <span class="qg-arrow">&rarr;</span>
        </a>
    </section>

    <!-- 3. Inspirasi & Mood Galeri -->
    <section class="customer-gallery">
        <div class="section-head" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
            <div>
                <span class="eyebrow">SALON MOOD</span>
                <h2 style="margin: 8px 0 0;">Inspirasi gaya</h2>
            </div>
            <div class="slider-actions" style="display: flex; gap: 8px;">
                <button type="button" class="btn-line" style="padding: 10px 16px;" onclick="slide(-1)" aria-label="Geser ke kiri">&larr;</button>
                <button type="button" class="btn-line" style="padding: 10px 16px;" onclick="slide(1)" aria-label="Geser ke kanan">&rarr;</button>
            </div>
        </div>

        <div class="horizontal-track" id="gallery">
            <img src="../assets/images/curly-hair.jpg" alt="Inspirasi curly hair">
            <img src="../assets/images/creambath.jpg" alt="Inspirasi creambath salon">
            <img src="../assets/images/hair dye.jpg" alt="Inspirasi hair coloring">
            <img src="../assets/images/model rambut.jpg" alt="Model gaya rambut modern">
        </div>
    </section>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
