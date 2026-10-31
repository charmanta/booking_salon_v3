<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Reservin</title>
<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-customer p-dashboard">

<?php include __DIR__ . '/customer_menu.php'; ?>

<header class="site-header site-header--customer">
<nav class="site-nav"><a href="dashboard.php" class="active">Beranda</a><a href="booking.php">Reservasi</a><a href="riwayat.php">Riwayat</a><a href="https://gemini.google.com/" target="_blank">Tanya AI</a><a href="../login.php">Keluar</a></nav>
<a class="brand" href="dashboard.php"><span class="brand-name">RESERVIN</span><span class="brand-sub">Salon Booking</span></a>
<div class="header-right"><a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a></div>
</header>
<main class="customer-home">

<section class="customer-hero">
    <div class="hero-content">
        <span class="eyebrow">RESERVIN MEMBER</span>

        <h1>
            Hai, Rina.<br>
            <em>Siap tampil lebih fresh?</em>
        </h1>

        <p>Pilih salon dan atur jadwal perawatanmu dengan mudah.</p>

        <a href="pilih_salon.php" class="btn btn-booking">
            Booking Sekarang
        </a>
    </div>
</section>
<section class="quick-grid"><a href="pilih_salon.php"><span>01</span><h2>Reservasi</h2><p>Pilih salon, layanan, stylist, dan waktu.</p>→</a><a href="riwayat.php"><span>02</span><h2>Riwayat</h2><p>Lihat dan ganti jadwal reservasi yang tersedia.</p>→</a><a href="https://gemini.google.com/" target="_blank"><span>03</span><h2>Tanya AI</h2><p>Cari inspirasi dan rekomendasi perawatan.</p>→</a></section>
<section class="customer-gallery"><div class="section-head"><div><span class="eyebrow">SALON MOOD</span><h2>Inspirasi gaya</h2></div><div class="slider-actions"><button onclick="slide(-1)">←</button><button onclick="slide(1)">→</button></div></div><div class="horizontal-track" id="gallery"><img src="../assets/images/curly-hair.jpg" alt="Inspirasi rambut"><img src="../assets/images/creambath.jpg" alt="Inspirasi rambut"><img src="../assets/images/hair dye.jpg" alt="Inspirasi rambut"><img src="../assets/images/model rambut.jpg" alt="Salon beauty"></div></section>
</main>
<footer class="site-footer site-footer--slim"><div class="copy">© RESERVIN · BOOKING SALON</div></footer>
<script>
function slide(d){document.getElementById('gallery').scrollBy({left:d*390,behavior:'smooth'})}
const g=document.getElementById('gallery');let down=false,x=0,s=0;
g.addEventListener('mousedown',e=>{down=true;x=e.pageX-g.offsetLeft;s=g.scrollLeft;g.classList.add('dragging')});
window.addEventListener('mouseup',()=>{down=false;g.classList.remove('dragging')});
g.addEventListener('mousemove',e=>{if(!down)return;e.preventDefault();g.scrollLeft=s-(e.pageX-g.offsetLeft-x)*1.2});
</script>
</body>
</html>
