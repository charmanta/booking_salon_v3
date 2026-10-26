<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Salon - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/customer.css">
</head>
<body class="page-auth p-salon">

    <!-- ===== HEADER ===== -->
    <header class="site-header ">
        <nav class="site-nav">
            <a href="index.php#peran">Untuk Siapa</a>
            <a href="index.php#fitur">Fitur</a>
            <a href="index.php#cara">Cara Kerja</a>
            <a href="index.php#salon">Salon</a>
        </nav>
        <a class="brand" href="index.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a class="btn-plain" href="login.php">Masuk</a><a href="login.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>

    <main class="auth-wrap">
        <div class="auth-card">
            <span class="eyebrow">Untuk pemilik salon</span>
            <h1>Daftarkan Salon</h1>
            <p class="sub">Kelola layanan, pegawai dan booking pelanggan</p>
            <form onsubmit="event.preventDefault(); alert('Salon berhasil didaftarkan. Silakan masuk sebagai Pemilik Salon.'); location.href='login.php';">
                <div class="two">
                <div class="fld"><label>Nama Pemilik</label><input type="text" class="form-control" placeholder="Nama lengkap pemilik" required></div>
                <div class="fld"><label>No. HP</label><input type="tel" class="form-control" placeholder="Nomor HP" required></div>
                </div>
                <div class="fld"><label>Nama Salon</label><input type="text" class="form-control" placeholder="Contoh: Luna Salon" required></div>
                <div class="two">
                <div class="fld"><label>Kota</label><input type="text" class="form-control" placeholder="Contoh: Bandung" required></div>
                <div class="fld"><label>Username</label><input type="text" class="form-control" placeholder="Buat username" required></div>
                </div>
                <div class="fld"><label>Alamat Salon</label><input type="text" class="form-control" placeholder="Alamat lengkap salon" required></div>
                <div class="two">
                <div class="fld"><label>Password</label><input type="password" class="form-control" placeholder="Buat password" required></div>
                <div class="fld"><label>Konfirmasi Password</label><input type="password" class="form-control" placeholder="Ulangi password" required></div>
                </div>
                <button type="submit" class="btn">Daftarkan Salon</button>
            </form>
            <div class="note">
                <span>Sudah terdaftar? <a href="login.php">Login</a></span>
                <a href="index.php">← Kembali ke halaman utama</a>
            </div>
        </div>
    </main>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
