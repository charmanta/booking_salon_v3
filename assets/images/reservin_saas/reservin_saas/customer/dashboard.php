<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/customer.css">
</head>
<body class="page-customer p-dashboard">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php" class="active">Beranda</a>
            <a href="booking.php">Reservasi</a>
            <a href="riwayat.php">Riwayat</a>
            <a href="https://gemini.google.com/" target="_blank">Tanya AI</a>
            <a href="../login.php">Keluar</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>

    <!-- ===== BANNER (taruh fotomu di assets/img/banner.jpg) ===== -->
    <div class="banner" role="img" aria-label="Salon"></div>



<div class="container">

    <!-- HEADER -->
    

    <!-- ISI DASHBOARD -->
    <div class="content">

        <div class="welcome">
            <small style="display:block;margin-bottom:14px;letter-spacing:.1em">Selamat datang, Pelanggan 👋</small>
            <h3>Mau booking salon hari ini?</h3>
            <p>Pilih layanan salon yang kamu inginkan.</p>
        </div>

        <!-- BOOKING -->
        <div class="card">
            <h4>Booking Salon</h4>
            <p>
                Pilih salon, layanan, orang yang akan
                dilayani, dan jadwal reservasi.
            </p>

            <a href="pilih_salon.php" class="btn">
                Booking Sekarang
            </a>
        </div>

        <!-- RIWAYAT -->
        <div class="card">
            <h4>Riwayat Booking</h4>
            <p>
                Lihat daftar reservasi yang pernah
                kamu lakukan.
            </p>

            <a href="riwayat.php" class="btn">
                Lihat Riwayat
            </a>
        </div>

        <!-- TANYA AI -->
        <div class="card">
            <h4>Tanya AI</h4>
            <p>
                Tanyakan informasi mengenai layanan,
                harga, dan salon.
            </p>

            <a href="https://gemini.google.com/" target="_blank">
                Chat dengan AI
            </a>
        </div>

        <!-- KALENDER -->
        <div class="calendar">

            <h4>Kalender</h4>

            <p>
                Lihat jadwal salon yang tersedia.
            </p>

            <div class="dates">

                <div class="date">
                    15<br>
                    Sen
                </div>

                <div class="date">
                    16<br>
                    Sel
                </div>

                <div class="date active">
                    17<br>
                    Rab
                </div>

                <div class="date">
                    18<br>
                    Kam
                </div>

            </div>

        </div>

    </div>

    <!-- BOTTOM NAVIGATION -->
    <div class="bottom">

        <a href="dashboard.php" class="active">
            <span class="icon">🏠</span>
            Beranda
        </a>

        <a href="booking.php">
            <span class="icon">📅</span>
            Reservasi
        </a>

        <a href="riwayat.php">
            <span class="icon">📋</span>
            Riwayat
        </a>

        <a href="https://gemini.google.com/" target="_blank">
            <span class="icon">💬</span>
            Tanya AI
        </a>

    </div>

</div>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
