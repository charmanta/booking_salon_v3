<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="page-admin p-admin-dashboard">


<div class="app">

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        RESERVIN
    </div>

    <nav class="menu">

        <a href="dashboard.php" class= "active">
            🏠 Dashboard
        </a>

        <a href="salon.php">
            🏪 Data Salon
        </a>

        <a href="layanan.php">
            💇 Layanan
        </a>

        <a href="pegawai.php">
            👤 Pegawai
        </a>

        <a href="laporan.php">
            📊 Laporan
        </a>

        <a href="profil.php">
            ⚙️ Profil
        </a>

        <a href="../login.php">
            🚪 Logout
        </a>

    </nav>

</aside>


<!-- MAIN -->

<main class="main">

    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Dashboard
        </div>

        <div class="profile">

            <div class="profile-icon">
                👤
            </div>

            <div>

                <b>Siti Amelia</b>

                <br>

                <small>Pemilik Salon</small>

            </div>

        </div>

    </header>


    <!-- CONTENT -->

    <section class="content">

        <div class="page-title">

            <h1>
                Dashboard Salon
            </h1>

            <p>
                Kelola dan pantau informasi salon Anda.
            </p>

        </div>


        <!-- STATISTIK -->

        <div class="stats">

            <div class="stat">

                <div class="stat-icon">
                    💇
                </div>

                <div class="stat-title">
                    Total Layanan
                </div>

                <div class="stat-number">
                    8
                </div>

            </div>


            <div class="stat">

                <div class="stat-icon">
                    🏪
                </div>

                <div class="stat-title">
                    Total Fasilitas
                </div>

                <div class="stat-number">
                    6
                </div>

            </div>

        </div>


        <!-- DIAGRAM DAN LAYANAN -->

        <div class="row">

            <!-- PENGHASILAN -->

            <div class="card">

                <div class="card-title">
                    Penghasilan Salon
                </div>

                <div class="card-subtitle">
                    Penghasilan per bulan
                </div>


                <div class="chart">

                    <div class="bar-item">

                        <div class="bar-value">
                            3 jt
                        </div>

                        <div
                            class="bar"
                            style="height:45%;">

                        </div>

                        <div class="month">
                            Jan
                        </div>

                    </div>


                    <div class="bar-item">

                        <div class="bar-value">
                            4 jt
                        </div>

                        <div
                            class="bar"
                            style="height:60%;">

                        </div>

                        <div class="month">
                            Feb
                        </div>

                    </div>


                    <div class="bar-item">

                        <div class="bar-value">
                            5 jt
                        </div>

                        <div
                            class="bar"
                            style="height:75%;">

                        </div>

                        <div class="month">
                            Mar
                        </div>

                    </div>


                    <div class="bar-item">

                        <div class="bar-value">
                            4,5 jt
                        </div>

                        <div
                            class="bar"
                            style="height:68%;">

                        </div>

                        <div class="month">
                            Apr
                        </div>

                    </div>


                    <div class="bar-item">

                        <div class="bar-value">
                            6 jt
                        </div>

                        <div
                            class="bar"
                            style="height:90%;">

                        </div>

                        <div class="month">
                            Mei
                        </div>

                    </div>


                    <div class="bar-item">

                        <div class="bar-value">
                            5,5 jt
                        </div>

                        <div
                            class="bar"
                            style="height:82%;">

                        </div>

                        <div class="month">
                            Jun
                        </div>

                    </div>

                </div>

            </div>


            <!-- LAYANAN -->

            <div class="card">

                <div class="card-title">
                    Layanan Salon
                </div>

                <div class="card-subtitle">
                    Layanan yang tersedia
                </div>


                <div class="list">

                    <div class="list-item">

                        <div>

                            <div class="item-name">
                                Creambath
                            </div>

                            <div class="item-info">
                                Perawatan rambut
                            </div>

                        </div>

                        <div class="price">
                            Rp100.000
                        </div>

                    </div>


                    <div class="list-item">

                        <div>

                            <div class="item-name">
                                Hair Spa
                            </div>

                            <div class="item-info">
                                Perawatan rambut
                            </div>

                        </div>

                        <div class="price">
                            Rp150.000
                        </div>

                    </div>


                    <div class="list-item">

                        <div>

                            <div class="item-name">
                                Potong Rambut
                            </div>

                            <div class="item-info">
                                Haircut
                            </div>

                        </div>

                        <div class="price">
                            Rp50.000
                        </div>

                    </div>


                    <div class="list-item">

                        <div>

                            <div class="item-name">
                                Hair Coloring
                            </div>

                            <div class="item-info">
                                Pewarnaan rambut
                            </div>

                        </div>

                        <div class="price">
                            Rp250.000
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- FASILITAS -->

        <div class="card">

            <div class="card-title">
                Fasilitas Salon
            </div>

            <div class="card-subtitle">
                Fasilitas yang tersedia di salon
            </div>


            <div class="row">

                <div class="list">

                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            AC
                        </span>

                    </div>


                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            WiFi
                        </span>

                    </div>


                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            Ruang Tunggu
                        </span>

                    </div>

                </div>


                <div class="list">

                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            Parkir
                        </span>

                    </div>


                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            Toilet
                        </span>

                    </div>


                    <div class="facility">

                        <div class="check">
                            ✓
                        </div>

                        <span>
                            Ruang Ganti
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

</div>

    <footer class="admin-foot">© Reservin · Panel Pemilik Salon</footer>
</body>
</html>
