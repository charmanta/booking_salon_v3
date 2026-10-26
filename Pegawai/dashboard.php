<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-pegawai-dashboard">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="daftar_booking.php">Daftar Booking</a>
            <a href="profil.php">Profil</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <div class="user-chip"><span class="avatar">SA</span><span><b>Siti Amelia</b><small>Pegawai</small></span></div>
            <a href="../login.php" class="btn btn-cta" style="padding:26px 34px">Logout</a>
        </div>
    </header>



<div class="app">

<!-- SIDEBAR -->


<!-- MAIN -->
<main class="main">

    <!-- HEADER -->
    <div class="hero hero--sm">
                <h2>Dashboard Pegawai</h2>
            </div>

    <!-- CONTENT -->
    <section class="content">

        <div class="page-title">

            <h1>
                Halo, Siti 👋
            </h1>

            <p>
                Berikut informasi booking salon hari ini.
            </p>

        </div>

        <!-- STATISTIK -->
        <div class="stats">

            <div class="stat">
                <div class="stat-icon">📋</div>
                <div class="stat-number">12</div>
                <div class="stat-title">Total Booking</div>
            </div>

            <div class="stat">
                <div class="stat-icon">⏳</div>
                <div class="stat-number">4</div>
                <div class="stat-title">Menunggu</div>
            </div>

            <div class="stat">
                <div class="stat-icon">✓</div>
                <div class="stat-number">8</div>
                <div class="stat-title">Dikonfirmasi</div>
            </div>

            <div class="stat">
                <div class="stat-icon">⭐</div>
                <div class="stat-number">4.8</div>
                <div class="stat-title">Rating</div>
            </div>

        </div>

        <!-- BOOKING -->
        <div class="card">

            <div class="card-header">

                <div class="card-title">
                    Booking Hari Ini
                </div>

                <a href="booking.php" class="btn">
                    Lihat Semua
                </a>

            </div>

            <table>

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Layanan</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    <tr>
                        <td>RSV-001</td>
                        <td>Rina</td>
                        <td>Creambath</td>
                        <td>10:00</td>
                        <td>
                            <span class="status">
                                Menunggu
                            </span>
                        </td>
                        <td>
                            <a href="detail_booking.php" class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>RSV-002</td>
                        <td>Dewi</td>
                        <td>Potong Rambut</td>
                        <td>13:00</td>
                        <td>
                            <span class="status">
                                Dikonfirmasi
                            </span>
                        </td>
                        <td>
                            <a href="detail_booking.php" class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td>RSV-003</td>
                        <td>Maya</td>
                        <td>Hair Spa</td>
                        <td>15:00</td>
                        <td>
                            <span class="status">
                                Dikonfirmasi
                            </span>
                        </td>
                        <td>
                            <a href="detail_booking.php" class="btn">
                                Detail
                            </a>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>


    </section>

</main>

</div>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
