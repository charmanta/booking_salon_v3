<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/customer.css">
</head>
<body class="page-auth p-login">

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
            <span class="eyebrow">Selamat datang kembali</span>
            <h1>Masuk</h1>
            <p class="sub">Masuk ke akun kamu</p>
            <form onsubmit="return masuk(event)">
                <div class="roles-pick" role="radiogroup" aria-label="Masuk sebagai">
                    <input type="radio" name="peran" id="r1" value="customer/dashboard.php" checked><label for="r1">Pelanggan</label>
                    <input type="radio" name="peran" id="r2" value="admin/dashboard.php"><label for="r2">Pemilik Salon</label>
                    <input type="radio" name="peran" id="r3" value="Pegawai/dashboard.php"><label for="r3">Pegawai</label>
                </div>
                <div class="fld"><label>Username</label><input type="text" class="form-control" placeholder="Masukkan username" required></div>
                <div class="fld"><label>Password</label><input type="password" class="form-control" placeholder="Masukkan password" required></div>
                <button type="submit" class="btn">Login</button>
            </form>
            <script>
                /* Demo tampilan: arahkan ke dashboard sesuai peran yang dipilih. */
                function masuk(e) {
                    e.preventDefault();
                    window.location.href = document.querySelector('input[name=peran]:checked').value;
                    return false;
                }
            </script>
            <div class="note">
                <span>Belum punya akun? <a href="registrasi.php">Registrasi</a></span>
                <span>Pemilik salon? <a href="daftar_salon.php">Daftarkan salon</a></span>
                <a href="index.php">← Kembali ke halaman utama</a>
            </div>
        </div>
    </main>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
