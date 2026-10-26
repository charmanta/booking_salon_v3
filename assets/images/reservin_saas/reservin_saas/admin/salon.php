<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="page-admin p-admin-salon">


<div class="app">

<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        RESERVIN
    </div>

    <nav class="menu">

        <a href="dashboard.php">
            🏠 Dashboard
        </a>

        <a href="salon.php" class="active">
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
            Data Salon
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
                Data Salon
            </h1>

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

    <footer class="admin-foot">© Reservin · Panel Pemilik Salon</footer>
</body>
</html>
