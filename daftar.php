<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/theme.css">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="page-choose">

<!-- ===== HEADER ===== -->
<header class="site-header">
    <nav class="site-nav">
        <a href="index.php">Beranda</a>
        <a href="login.php">Booking</a>
        <a href="index.php#salon">Daftar Salon</a>
        <a href="index.php#layanan">Layanan</a>
    </nav>
    <a class="brand" href="index.php" aria-label="Reservin">
        <span class="brand-name">RESERVIN</span>
        <span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span>
    </a>
    <div class="header-right">
        <a href="login.php" class="btn-ghost">Masuk</a>
        <a href="daftar.php" class="btn-solid">Daftar</a>
    </div>
</header>

<!-- ===== PILIH JENIS AKUN ===== -->
<main class="choose-wrap">
    <h1>Daftar</h1>
    <p class="lead">Pilih jenis akun yang ingin kamu buat.</p>

    <div class="choose-grid">
        <article class="choose-card">
            <span class="tag">Pelanggan</span>
            <h2>Saya customer</h2>
            <p>Cari salon, pilih layanan, dan booking jadwal perawatan.</p>
            <ul>
                <li>Booking salon favorit</li>
                <li>Pilih layanan &amp; jadwal</li>
                <li>Pantau status booking</li>
            </ul>
            <a href="registrasi.php" class="btn-block">Daftar sebagai customer</a>
        </article>

        <article class="choose-card">
            <span class="tag">Pemilik Salon</span>
            <h2>Saya pemilik salon</h2>
            <p>Kelola salonmu, layanan, pegawai, dan jadwal dalam satu tempat.</p>
            <ul>
                <li>Atur data &amp; jam operasional</li>
                <li>Kelola layanan dan pegawai</li>
                <li>Akses dashboard admin</li>
            </ul>
            <a href="daftar_salon.php" class="btn-block">Daftarkan salon</a>
        </article>
    </div>

    <p class="choose-note">Sudah punya akun? <a href="login.php">Masuk</a> atau pilih jenis akun di atas.</p>
</main>

<footer class="site-footer site-footer--slim">
    <div class="copy">© RESERVIN · BOOKING SALON</div>
</footer>

</body>
</html>