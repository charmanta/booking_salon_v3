<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reservin — Booking Salon</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/theme.css">

<style>
.home-hero {
  display: flex !important;
  align-items: center;
  min-height: 600px;
  padding: 60px 8%;
  background-image:
    linear-gradient(90deg,
      rgba(96, 62, 48, 0.96) 0%,
      rgba(128, 88, 70, 0.85) 30%,
      rgba(176, 140, 118, 0.45) 52%,
      rgba(220, 200, 185, 0.10) 70%,
      rgba(255, 255, 255, 0) 85%),
    url('assets/images/model_index.jpg') !important;
  background-size: 120% auto;
  background-position: 20% 100%;
  background-repeat: no-repeat;
}

.home-hero .hero-copy { max-width: 540px; background: none; }
.home-hero .eyebrow { color: #e4c3a7; }
.home-hero h1 { color: #fffaf3; }
.home-hero h1 em { color: #f0cfb3; }
.home-hero p { color: #f2e7dc; }

@media (max-width: 768px) {
  .home-hero {
    background-image:
      linear-gradient(180deg, rgba(96,62,48,.92) 0%, rgba(128,88,70,.75) 55%, rgba(176,140,118,.3) 100%),
      url('assets/images/model_.jpg') !important;
    background-position: 70% center;
  }
}
</style>


</head>
<body class="page-home">
<header class="site-header home-header">
<nav class="site-nav">
<a href="index.php" class="active">Beranda</a>
<a href="login.php">Booking</a>
<a href="#salon">Daftar Salon</a>
<a href="#layanan">Layanan</a>
<a href="login.php">Login</a>
</nav>
<a class="brand" href="index.php" aria-label="Reservin">
<span class="brand-name">RESERVIN</span>
<span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span>
</a>
<div class="header-right"><a href="login.php" class="btn btn-cta">Booking Sekarang</a></div>
</header>

<section class="home-hero">
<div class="hero-copy">
<p class="eyebrow">BEAUTY • CARE • CONFIDENCE</p>
<h1>Temukan salon favoritmu,<br><em>booking tanpa ribet.</em></h1>
<p>Reservin membantu kamu memilih salon, layanan, stylist, dan jadwal yang paling sesuai.</p>
<a href="login.php" class="btn btn-booking">Mulai Reservasi</a>
</div>
</section>

<section class="home-intro">
<div>
<span class="section-number">01</span>
<h2>Salon yang terasa<br><em>lebih personal.</em></h2>
</div>
<p>Dari potong rambut sampai hair treatment, pilih layanan dari salon yang kamu suka dan tentukan sendiri waktu kedatangannya.</p>
</section>

<section class="home-section" id="salon">
<div class="section-head">
<div><span class="eyebrow">EXPLORE</span><h2>Pilihan Salon</h2></div>
<div class="slider-actions"><button onclick="slide('salonTrack',-1)" aria-label="Sebelumnya">←</button><button onclick="slide('salonTrack',1)" aria-label="Berikutnya">→</button></div>
</div>
<div class="horizontal-track" id="salonTrack">
<article class="salon-showcase"><img src="assets/images/luna_salon.jpg" alt="Luna Salon"><div><span>Bandung</span><h3>Luna Salon</h3><p>Salon modern untuk haircare, coloring, dan styling.</p><a href="login.php">Pilih salon →</a></div></article>
<article class="salon-showcase"><img src="assets/images/anggun_salon.jpg" alt="Salon Anggun"><div><span>Jakarta</span><h3>Salon Anggun</h3><p>Perawatan rambut dan kecantikan dengan suasana nyaman.</p><a href="login.php">Pilih salon →</a></div></article>
<article class="salon-showcase"><img src="assets/images/ayu_salon.jpg" alt="Ayu Salon"><div><span>Surabaya</span><h3>Ayu Salon</h3><p>Tempat styling dan treatment untuk tampil lebih percaya diri.</p><a href="login.php">Pilih salon →</a></div></article>
<article class="salon-showcase"><img src="assets/images/Glow Studio.jpg" alt="Salon treatment"><div><span>Jakarta</span><h3>Glow Hair Studio</h3><p>Highlight, blowout, dan treatment untuk tampilan baru.</p><a href="login.php">Pilih salon →</a></div></article>
</div>
</section>

<section class="image-banner">
<img src="assets/images/produk_salon.jpg" alt="Detail rambut setelah treatment">
<div><span class="eyebrow">SELF CARE SESSION</span><h2>Good hair day<br><em>starts here.</em></h2><a href="login.php" class="btn btn-booking">Booking Sekarang</a></div>
</section>

<section class="home-section" id="layanan">
<div class="section-head">
<div><span class="eyebrow">SERVICES</span><h2>Layanan Salon</h2></div>
<div class="slider-actions"><button onclick="slide('serviceTrack',-1)">←</button><button onclick="slide('serviceTrack',1)">→</button></div>
</div>
<div class="horizontal-track service-track" id="serviceTrack">
<div class="service-card"><span>01</span><h3>Cut & Style</h3><p>Potong dan styling yang disesuaikan dengan bentuk wajah dan gaya kamu.</p><a href="login.php">Book now</a></div>
<div class="service-card"><span>02</span><h3>Color & Highlights</h3><p>Balayage, coloring, hingga highlight dengan pilihan warna yang bisa disesuaikan.</p><a href="login.php">Book now</a></div>
<div class="service-card"><span>03</span><h3>Treatment & Care</h3><p>Creambath, hair spa, keratin, dan perawatan untuk rambut lebih sehat.</p><a href="login.php">Book now</a></div>
<div class="service-card"><span>04</span><h3>Blowout & Finish</h3><p>Blowout sleek, volume, atau wave untuk acara spesial maupun sehari-hari.</p><a href="login.php">Book now</a></div>
<div class="service-card"><span>05</span><h3>Bridal & Event</h3><p>Persiapan hairdo untuk pernikahan dan berbagai acara penting.</p><a href="login.php">Book now</a></div>
</div>
</section>

<footer class="site-footer">
<div><h3>Reservin</h3><p class="foot-text">Booking salon lebih mudah, rapi, dan sesuai jadwal.</p></div>
<div class="foot-right"><small>Butuh perawatan?</small><a href="login.php" class="foot-link">Book your next look →</a></div>
<div class="copy">© RESERVIN · BOOKING SALON</div>
</footer>

<script>
function slide(id,direction){
 const el=document.getElementById(id);
 el.scrollBy({left:direction*390,behavior:'smooth'});
}
document.querySelectorAll('.horizontal-track').forEach(track=>{
 let down=false,startX=0,scroll=0;
 track.addEventListener('mousedown',e=>{down=true;startX=e.pageX-track.offsetLeft;scroll=track.scrollLeft;track.classList.add('dragging')});
 window.addEventListener('mouseup',()=>{down=false;track.classList.remove('dragging')});
 track.addEventListener('mouseleave',()=>{down=false;track.classList.remove('dragging')});
 track.addEventListener('mousemove',e=>{if(!down)return;e.preventDefault();track.scrollLeft=scroll-(e.pageX-track.offsetLeft-startX)*1.2});
});
</script>
</body>
</html>