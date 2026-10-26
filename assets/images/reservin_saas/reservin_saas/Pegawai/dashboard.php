<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/pegawai.css">
</head>
<body class="page-pegawai p-pegawai-dashboard">

    <header class="topnav">
        <a class="tn-brand" href="dashboard.php"><b>RESERVIN</b><small>Staff</small></a>
        <nav class="tn-menu">
            <a href="dashboard.php" class="active">Dashboard</a>
            <a href="daftar_booking.php">Daftar Booking</a>
            <a href="profil.php">Profil</a>
        </nav>
        <div class="tn-right">
            <div class="tn-user"><span class="av">SA</span><div><b>Siti Amelia</b><small>Pegawai</small></div></div>
            <a class="tn-out" href="../login.php">Logout</a>
        </div>
    </header>


<div class="app">

<!-- SIDEBAR -->


<!-- MAIN -->
<main class="main">

    <!-- HEADER -->
    

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
                            <span class="status waiting">
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
                            <span class="status confirmed">
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
                            <span class="status confirmed">
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

    <footer class="pg-foot">© Reservin · Ruang Kerja Pegawai</footer>
</body>
</html>
