<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-admin-salon">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="salon.php" class="active">Data Salon</a>
            <a href="layanan.php">Layanan</a>
            <a href="pegawai.php">Pegawai</a>
            <a href="laporan.php">Laporan</a>
            <a href="profil.php">Profil</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <div class="user-chip"><span class="avatar">SA</span><span><b>Siti Amelia</b><small>Pemilik Salon</small></span></div>
            <a href="../login.php" class="btn btn-cta" style="padding:26px 34px">Logout</a>
        </div>
    </header>



<div class="app">

<!-- SIDEBAR -->





<!-- MAIN -->

<main class="main">

    <!-- TOPBAR -->

    <div class="hero hero--sm">
                <h2>Data Salon</h2>
            </div>


    <!-- CONTENT -->

    <section class="content">

        <div class="page-title">

            

            <p>
                Kelola informasi salon Anda.
            </p>

        </div>


        <!-- INFORMASI SALON -->

        <div class="card">

            <div class="card-title">
                Informasi Salon
            </div>

            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nama Salon
                    </label>

                    <input
                        type="text"
                        value="Luna Salon">

                </div>


                <div class="form-group">

                    <label>
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        value="081234567890">

                </div>


                <div class="form-group full">

                    <label>
                        Alamat Salon
                    </label>

                    <textarea>Jl. Mawar No. 10, Surakarta</textarea>

                </div>


                <div class="form-group full">

                    <label>
                        Deskripsi Salon
                    </label>

                    <textarea>Salon kecantikan yang menyediakan berbagai layanan perawatan rambut dan kecantikan.</textarea>

                </div>

            </div>

        </div>


        <!-- JAM OPERASIONAL -->

        <div class="card">

            <div class="card-title">
                Jam Operasional
            </div>

            <div class="time-box">

                <div class="form-group">

                    <label>
                        Jam Buka
                    </label>

                    <input
                        type="time"
                        value="09:00">

                </div>


                <div class="form-group">

                    <label>
                        Jam Tutup
                    </label>

                    <input
                        type="time"
                        value="20:00">

                </div>

            </div>

        </div>


        <!-- FASILITAS -->

        <div class="card">

            <div class="card-title">
                Fasilitas Salon
            </div>

            <div class="facilities">

                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        AC
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        WiFi
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        Ruang Tunggu
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        Parkir
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        Toilet
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox"
                        checked>

                    <span>
                        Ruang Ganti
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox">

                    <span>
                        Mushola
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox">

                    <span>
                        Minuman
                    </span>

                </label>


                <label class="facility">

                    <input
                        type="checkbox">

                    <span>
                        TV
                    </span>

                </label>

            </div>


            <!-- BUTTON -->

            <div class="actions">

                <button
                    class="btn btn-primary"
                    onclick="simpan()">

                    Simpan Perubahan

                </button>


                <button
                    class="btn btn-secondary"
                    onclick="kembali()">

                    Kembali

                </button>

            </div>

        </div>

    </section>

</main>

</div>


<script>

function simpan(){

    alert(
        "Data salon berhasil disimpan."
    );

}

function kembali(){

    window.location.href =
        "dashboard.php";

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
