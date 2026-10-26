<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="page-admin p-admin-laporan">


<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        RESERVIN
    </div>

    <nav class="menu">

        <a href="dashboard.php">
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

        <a href="laporan.php" class="active">
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
            Laporan
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
                Laporan Salon
            </h1>

            <p>
                Pantau penghasilan dan aktivitas salon.
            </p>

        </div>


        <!-- FILTER -->

        <div class="filter">

            <div class="filter-group">

                <label>
                    Bulan
                </label>

                <select id="bulan">

                    <option value="Januari">
                        Januari
                    </option>

                    <option value="Februari">
                        Februari
                    </option>

                    <option value="Maret">
                        Maret
                    </option>

                    <option value="April">
                        April
                    </option>

                    <option value="Mei">
                        Mei
                    </option>

                    <option value="Juni" selected>
                        Juni
                    </option>

                    <option value="Juli">
                        Juli
                    </option>

                    <option value="Agustus">
                        Agustus
                    </option>

                    <option value="September">
                        September
                    </option>

                    <option value="Oktober">
                        Oktober
                    </option>

                    <option value="November">
                        November
                    </option>

                    <option value="Desember">
                        Desember
                    </option>

                </select>

            </div>


            <div class="filter-group">

                <label>
                    Tahun
                </label>

                <select id="tahun">

                    <option>2026</option>
                    <option>2025</option>

                </select>

            </div>


            <button
                class="btn btn-primary"
                onclick="tampilkanLaporan()">

                Tampilkan

            </button>

        </div>


        <!-- SUMMARY -->

        <div class="summary">

            <div class="summary-card">

                <div class="summary-title">
                    Total Penghasilan
                </div>

                <div class="summary-value">
                    Rp5.250.000
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-title">
                    Total Booking
                </div>

                <div class="summary-value">
                    42
                </div>

            </div>


            <div class="summary-card">

                <div class="summary-title">
                    Layanan Terlaris
                </div>

                <div class="summary-value">
                    Creambath
                </div>

            </div>

        </div>


        <!-- DIAGRAM -->

        <div class="card">

            <div class="card-title">
                Penghasilan Bulanan
            </div>

            <div class="card-subtitle">
                Perbandingan penghasilan salon setiap bulan
            </div>


            <div class="chart">

                <div class="bar-item">

                    <div class="bar-value">
                        Rp3 jt
                    </div>

                    <div
                        class="bar"
                        style="height:45%;">
                    </div>

                    <div class="bar-label">
                        Jan
                    </div>

                </div>


                <div class="bar-item">

                    <div class="bar-value">
                        Rp3,8 jt
                    </div>

                    <div
                        class="bar"
                        style="height:57%;">
                    </div>

                    <div class="bar-label">
                        Feb
                    </div>

                </div>


                <div class="bar-item">

                    <div class="bar-value">
                        Rp4,2 jt
                    </div>

                    <div
                        class="bar"
                        style="height:63%;">
                    </div>

                    <div class="bar-label">
                        Mar
                    </div>

                </div>


                <div class="bar-item">

                    <div class="bar-value">
                        Rp4,8 jt
                    </div>

                    <div
                        class="bar"
                        style="height:72%;">
                    </div>

                    <div class="bar-label">
                        Apr
                    </div>

                </div>


                <div class="bar-item">

                    <div class="bar-value">
                        Rp4,6 jt
                    </div>

                    <div
                        class="bar"
                        style="height:69%;">
                    </div>

                    <div class="bar-label">
                        Mei
                    </div>

                </div>


                <div class="bar-item">

                    <div class="bar-value">
                        Rp5,25 jt
                    </div>

                    <div
                        class="bar"
                        style="height:82%;">
                    </div>

                    <div class="bar-label">
                        Jun
                    </div>

                </div>

            </div>

        </div>


        <!-- DETAIL -->

        <div class="card">

            <div class="card-title">
                Detail Penghasilan
            </div>

            <div class="card-subtitle">
                Rincian penghasilan berdasarkan layanan.
            </div>


            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>
                                No
                            </th>

                            <th>
                                Layanan
                            </th>

                            <th>
                                Jumlah Booking
                            </th>

                            <th>
                                Harga
                            </th>

                            <th>
                                Total Penghasilan
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr>

                            <td>1</td>

                            <td class="total">
                                Creambath
                            </td>

                            <td>
                                15
                            </td>

                            <td>
                                Rp100.000
                            </td>

                            <td class="total">
                                Rp1.500.000
                            </td>

                        </tr>


                        <tr>

                            <td>2</td>

                            <td class="total">
                                Hair Spa
                            </td>

                            <td>
                                10
                            </td>

                            <td>
                                Rp150.000
                            </td>

                            <td class="total">
                                Rp1.500.000
                            </td>

                        </tr>


                        <tr>

                            <td>3</td>

                            <td class="total">
                                Potong Rambut
                            </td>

                            <td>
                                20
                            </td>

                            <td>
                                Rp50.000
                            </td>

                            <td class="total">
                                Rp1.000.000
                            </td>

                        </tr>


                        <tr>

                            <td>4</td>

                            <td class="total">
                                Hair Coloring
                            </td>

                            <td>
                                5
                            </td>

                            <td>
                                Rp250.000
                            </td>

                            <td class="total">
                                Rp1.250.000
                            </td>

                        </tr>


                        <tr>

                            <td colspan="4" class="total">
                                Total
                            </td>

                            <td class="total">
                                Rp5.250.000
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </section>

</main>


<script>

function tampilkanLaporan(){

    let bulan =
        document.getElementById("bulan").value;

    let tahun =
        document.getElementById("tahun").value;

    alert(
        "Menampilkan laporan " +
        bulan +
        " " +
        tahun
    );

}

</script>

    <footer class="admin-foot">© Reservin · Panel Pemilik Salon</footer>
</body>
</html>
