<?php
/* =====================================================================
   RESERVIN — PILIH SALON (customer/pilih_salon.php)
   Klik "Pilih Salon" -> langsung ke halaman reservasi (booking.php)
   ===================================================================== */
require_once __DIR__ . '/includes/init.php';

$page_title   = 'Pilih Salon';
$current_page = 'pilih_salon.php';
$body_class   = 'p-pilih';

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

// Script carousel (tombol geser + drag). Perpindahan halaman TIDAK lewat JS.
$extra_js = '
<script>
function slide(d) {
    var c = document.getElementById("salonCarousel");
    if (c) c.scrollBy({ left: d * 390, behavior: "smooth" });
}

(function () {
    var c = document.getElementById("salonCarousel");
    if (!c) return;

    var down = false, moved = false, startX = 0, scrollLeft = 0;

    c.addEventListener("mousedown", function (e) {
        down = true;
        moved = false;
        startX = e.pageX - c.offsetLeft;
        scrollLeft = c.scrollLeft;
    });

    window.addEventListener("mouseup", function () {
        down = false;
        c.classList.remove("dragging");
    });

    c.addEventListener("mousemove", function (e) {
        if (!down) return;
        var jarak = e.pageX - c.offsetLeft - startX;
        if (Math.abs(jarak) > 5) {
            moved = true;
            c.classList.add("dragging");
        }
        if (moved) {
            e.preventDefault();
            c.scrollLeft = scrollLeft - jarak * 1.2;
        }
    });

    // Kalau user habis menggeser (drag), jangan anggap itu klik link
    c.addEventListener("click", function (e) {
        if (moved) {
            e.preventDefault();
            e.stopPropagation();
            moved = false;
        }
    }, true);
})();
</script>
';

require __DIR__ . '/includes/header.php';
?>

<main class="select-page">

    <div class="select-heading">
        <span class="eyebrow">STEP 01</span>
        <h1>Pilih salon yang kamu suka.</h1>
        <p>Geser ke samping untuk melihat salon dan cabang lainnya.</p>
    </div>

    <div class="slider-actions select-actions">
        <button type="button" onclick="slide(-1)" aria-label="Geser salon ke kiri">&larr;</button>
        <button type="button" onclick="slide(1)" aria-label="Geser salon ke kanan">&rarr;</button>
    </div>

    <div class="salon-carousel" id="salonCarousel">
        <?php foreach ($daftarSalon as $s): ?>
            <article class="salon-card-new">
                <img src="<?= e($s['gambar']) ?>" alt="<?= e($s['nama']) ?>" loading="lazy" draggable="false">
                <div class="salon-card-body">
                    <span><?= e($s['kota_jam']) ?></span>
                    <h2><?= e($s['nama']) ?></h2>
                    <p><?= e($s['alamat']) ?></p>

                    <div class="chips">
                        <?php foreach ($s['fasilitas'] as $f): ?>
                            <b><?= e($f) ?></b>
                        <?php endforeach; ?>
                    </div>

                    <!-- Link biasa langsung ke halaman reservasi -->
                    <a class="btn-pilih-salon"
                       href="booking.php?salon=<?= urlencode($s['nama']) ?>"
                       draggable="false">
                        Pilih Salon &rarr;
                    </a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

</main>

<?php require __DIR__ . '/includes/footer.php'; ?>