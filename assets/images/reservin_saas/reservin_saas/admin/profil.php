<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="page-admin p-admin-profil">


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

        <a href="laporan.php">
            📊 Laporan
        </a>

        <a href="profil.php" class="active">
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
            Profil
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
                Profil
            </h1>

            <p>
                Kelola informasi akun dan salon Anda.
            </p>

        </div>


        <!-- DATA AKUN -->

        <div class="card">

            <div class="card-title">
                Informasi Akun
            </div>

            <div class="card-subtitle">
                Informasi pemilik akun yang digunakan untuk mengelola salon.
            </div>


            <div class="profile-box">

                <div class="big-profile">
                    👩
                </div>

                <div>

                    <div class="profile-name">
                        Siti Amelia
                    </div>

                    <div class="profile-role">
                        Pemilik / Admin Salon
                    </div>

                </div>

            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nama Pemilik
                    </label>

                    <input
                        type="text"
                        value="Siti Amelia"
                        id="namaPemilik">

                </div>


                <div class="form-group">

                    <label>
                        Nomor Telepon
                    </label>

                    <input
                        type="text"
                        value="081234567890"
                        id="telepon">

                </div>


                <div class="form-group full">

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        value="sitiamelia@gmail.com"
                        id="email">

                </div>

            </div>

        </div>


        <!-- DATA SALON -->

        <div class="card">

            <div class="card-title">
                Informasi Salon
            </div>

            <div class="card-subtitle">
                Informasi salon yang ditampilkan kepada pelanggan.
            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nama Salon
                    </label>

                    <input
                        type="text"
                        value="Luna Salon"
                        id="namaSalon">

                </div>


                <div class="form-group">

                    <label>
                        Nomor Telepon Salon
                    </label>

                    <input
                        type="text"
                        value="081234567890"
                        id="teleponSalon">

                </div>


                <div class="form-group full">

                    <label>
                        Alamat Salon
                    </label>

                    <textarea id="alamatSalon">Jl. Merdeka No. 10, Bandung</textarea>

                </div>


                <div class="form-group">

                    <label>
                        Jam Buka
                    </label>

                    <input
                        type="time"
                        value="09:00"
                        id="jamBuka">

                </div>


                <div class="form-group">

                    <label>
                        Jam Tutup
                    </label>

                    <input
                        type="time"
                        value="20:00"
                        id="jamTutup">

                </div>

            </div>


            <div class="button-area">

                <button
                    class="btn btn-secondary"
                    onclick="batal()">

                    Batal

                </button>

                <button
                    class="btn btn-primary"
                    onclick="simpanProfil()">

                    Simpan Perubahan

                </button>

            </div>

        </div>


        <!-- RINGKASAN SALON -->

        <div class="card">

            <div class="card-title">
                Ringkasan Salon
            </div>

            <div class="card-subtitle">
                Informasi utama salon Anda.
            </div>


            <div class="info-grid">

                <div class="info-item">

                    <div class="info-label">
                        Nama Salon
                    </div>

                    <div class="info-value">
                        Luna Salon
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Lokasi
                    </div>

                    <div class="info-value">
                        Bandung
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Jam Operasional
                    </div>

                    <div class="info-value">
                        09.00 - 20.00
                    </div>

                </div>


                <div class="info-item">

                    <div class="info-label">
                        Status Salon
                    </div>

                    <div class="info-value">
                        Aktif
                    </div>

                </div>

            </div>

        </div>

    </section>

</main>


<script>

function simpanProfil(){

    let nama =
        document.getElementById("namaPemilik").value;

    let salon =
        document.getElementById("namaSalon").value;

    if(nama === "" || salon === ""){

        alert("Nama pemilik dan nama salon wajib diisi.");

        return;
    }

    alert("Perubahan profil berhasil disimpan.");

}


function batal(){

    location.reload();

}

</script>

    <footer class="admin-foot">© Reservin · Panel Pemilik Salon</footer>
</body>
</html>
