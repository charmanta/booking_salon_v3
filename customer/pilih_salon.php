<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Salon — Reservin</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-customer p-pilih">

<?php include __DIR__ . '/customer_menu.php'; ?>

<header class="site-header site-header--customer">
<nav class="site-nav"><a href="dashboard.php">Beranda</a><a href="pilih_salon.php" class="active">Reservasi</a><a href="riwayat.php">Riwayat</a><a href="https://gemini.google.com/" target="_blank">Tanya AI</a><a href="../login.php">Keluar</a></nav>
<a class="brand" href="dashboard.php"><span class="brand-name">RESERVIN</span><span class="brand-sub">Salon Booking</span></a>
<div class="header-right"><a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a></div>
</header>

<main class="select-page">
<div class="select-heading"><span class="eyebrow">STEP 01</span><h1>Pilih salon yang kamu suka.</h1><p>Geser ke samping untuk melihat salon lainnya.</p></div>
<div class="slider-actions select-actions"><button onclick="slide(-1)">←</button><button onclick="slide(1)">→</button></div>

<div class="salon-carousel" id="salonCarousel">
<article class="salon-card-new">
<img src="../assets/images/hair_left2.jpg" alt="Luna Salon">
<div class="salon-card-body"><span>Bandung · 09.00–20.00</span><h2>Luna Salon</h2><p>Jl. Merdeka No. 25, Bandung</p><div class="chips"><b>WiFi</b><b>AC</b><b>Parkir</b><b>Ruang Tunggu</b></div><button onclick="pilihSalon('Luna Salon')">Pilih Salon →</button></div>
</article>
<article class="salon-card-new">
<img src="../assets/images/hair_center2.jpg" alt="Salon Anggun">
<div class="salon-card-body"><span>Jakarta · 10.00–21.00</span><h2>Salon Anggun</h2><p>Jl. Sudirman No. 18, Jakarta</p><div class="chips"><b>WiFi</b><b>AC</b><b>Parkir</b><b>Toilet</b></div><button onclick="pilihSalon('Salon Anggun')">Pilih Salon →</button></div>
</article>
<article class="salon-card-new">
<img src="../assets/images/hair_right2.jpg" alt="Ayu Salon">
<div class="salon-card-body"><span>Surabaya · 09.00–19.00</span><h2>Ayu Salon</h2><p>Jl. Diponegoro No. 10, Surabaya</p><div class="chips"><b>WiFi</b><b>AC</b><b>Parkir</b><b>Toilet</b></div><button onclick="pilihSalon('Ayu Salon')">Pilih Salon →</button></div>
</article>
<article class="salon-card-new">
<img src="../assets/images/products.jpg" alt="Glow Hair Studio">
<div class="salon-card-body"><span>Jakarta · 09.00–20.00</span><h2>Glow Hair Studio</h2><p>Jl. Kemang Raya No. 8, Jakarta</p><div class="chips"><b>Hair Spa</b><b>Coloring</b><b>AC</b></div><button onclick="pilihSalon('Glow Hair Studio')">Pilih Salon →</button></div>
</article>
</div>
</main>

<div class="modal" id="modalSalon"><div class="modal-box"><h2 id="namaSalon">Pilih Salon</h2><p class="modal-info">Kamu memilih salon ini. Selanjutnya pilih layanan, tanggal, jam, dan apakah ingin dilayani Owner atau Pegawai.</p><button class="modal-btn lanjut" onclick="lanjutBooking()">Lanjut Booking</button><button class="modal-btn batal" onclick="tutupModal()">Batal</button></div></div>

<script>
let salonDipilih='';
function pilihSalon(nama){salonDipilih=nama;document.getElementById('namaSalon').textContent=nama;document.getElementById('modalSalon').style.display='flex'}
function tutupModal(){document.getElementById('modalSalon').style.display='none'}
function lanjutBooking(){location.href='booking.php?salon='+encodeURIComponent(salonDipilih)}
function slide(d){document.getElementById('salonCarousel').scrollBy({left:d*390,behavior:'smooth'})}
const c=document.getElementById('salonCarousel');let down=false,x=0,s=0;
c.addEventListener('mousedown',e=>{down=true;x=e.pageX-c.offsetLeft;s=c.scrollLeft;c.classList.add('dragging')});
window.addEventListener('mouseup',()=>{down=false;c.classList.remove('dragging')});
c.addEventListener('mousemove',e=>{if(!down)return;e.preventDefault();c.scrollLeft=s-(e.pageX-c.offsetLeft-x)*1.2});
</script>
<footer class="site-footer site-footer--slim"><div class="copy">© RESERVIN · BOOKING SALON</div></footer>
</body>
</html>
