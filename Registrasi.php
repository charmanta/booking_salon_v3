<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/theme.css">

     <style>
.hero.hero--lg {
  background-image:
    linear-gradient(rgba(96, 62, 48, 0.72), rgba(96, 62, 48, 0.72)),
    url('assets/images/warna_rambut.jpg') !important;
  background-size: cover !important;
  background-position: center !important;
  background-repeat: no-repeat !important;
  min-height: 700px;
}

.hero.hero--lg h1 { color: #fffaf3; }
.hero.hero--lg h1::after { display: none; }
.hero.hero--lg > p { color: #f2e7dc; }

.hero.hero--lg a:not(.btn) { color: #fffaf3; border-color: #fffaf3; }
.hero.hero--lg .hero-form p { color: #f2e7dc; }
</style>

</head>
<body class="page-auth">

    <!-- ===== HEADER ===== -->
    <header class="site-header ">
        <nav class="site-nav">
            <a href="index.php">Beranda</a>
            <a href="login.php">Booking</a>
            <a href="#daftar-salon">Daftar Salon</a>
            <a href="login.php">Login</a>
            <a href="Registrasi.php" class="active">Registrasi</a>
        </nav>
        <a class="brand" href="index.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a href="login.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>

    <!-- ===== HERO + FORM ===== -->
    <section class="hero hero--lg">
        <h1>Registrasi</h1>
        <p>Buat akun pelanggan Reservin</p>

        <div class="hero-form">
            <form>
                <div class="field">
                    <label class="sr-only">Nama Lengkap</label>
                    <input type="text" class="form-control" placeholder="Masukkan nama lengkap" required>
                </div>
                <div class="field">
                    <label class="sr-only">No. HP</label>
                    <input type="tel" class="form-control" placeholder="Masukkan nomor HP" required>
                </div>
                <div class="field">
                    <label class="sr-only">Username</label>
                    <input type="text" class="form-control" placeholder="Buat username" required>
                </div>
                <div class="field">
                    <label class="sr-only">Password</label>
                    <input type="password" class="form-control" placeholder="Buat password" required>
                </div>
                <div class="field">
                    <label class="sr-only">Konfirmasi Password</label>
                    <input type="password" class="form-control" placeholder="Ulangi password" required>
                </div>
                <button type="submit" class="btn btn-register">Daftar</button>
            </form>
            <div class="note">
                <span>Sudah punya akun? <a href="login.php">Login</a></span>
                <a href="index.php">← Kembali ke halaman utama</a>
            </div>
        </div>
    </section>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
