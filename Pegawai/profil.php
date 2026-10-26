<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pegawai</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-pegawai-profil">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="daftar_booking.php">Daftar Booking</a>
            <a href="profil.php" class="active">Profil</a>
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

    <!-- TOPBAR -->

    <div class="hero hero--sm">
                <h2>Profil Pegawai</h2>
            </div>


    <!-- CONTENT -->

    <section class="content">

        <div class="page-title">

            <h1>
                Profil Saya
            </h1>

            <p>
                Kelola informasi akun dan data diri Anda.
            </p>

        </div>


        <!-- CARD PROFIL -->

        <div class="card">

            <!-- IDENTITAS -->

            <div class="profile-head">

                <div class="big-profile">
                    👤
                </div>

                <div>

                    <div class="profile-name">
                        Siti Amelia
                    </div>

                    <div class="profile-role">
                        Pegawai • Luna Salon
                    </div>

                </div>

            </div>


            <!-- DATA PRIBADI -->

            <div class="section-title">
                Data Pribadi
            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        value="Siti Amelia">

                </div>


                <div class="form-group">

                    <label>
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        value="081234567890">

                </div>


                <div class="form-group">

                    <label>
                        Email
                    </label>

                    <input
                        type="email"
                        value="siti@gmail.com">

                </div>


                <div class="form-group">

                    <label>
                        Alamat
                    </label>

                    <textarea>Jl. Mawar No. 10</textarea>

                </div>

            </div>


            <!-- INFORMASI PEKERJAAN -->

            <div class="section-title">
                Informasi Pekerjaan
            </div>


            <div class="form-grid">

                <div class="form-group">

                    <label>
                        Jabatan
                    </label>

                    <input
                        type="text"
                        value="Pegawai"
                        readonly>

                </div>


                <div class="form-group">

                    <label>
                        Salon
                    </label>

                    <input
                        type="text"
                        value="Luna Salon"
                        readonly>

                </div>


                <div class="form-group">

                    <label>
                        Status
                    </label>

                    <div>

                        <span class="status">
                            Aktif
                        </span>

                    </div>

                </div>

            </div>


            <!-- KEAMANAN -->

            <div class="section-title">
                Keamanan Akun
            </div>


            <div class="form-group">

                <label>
                    Password
                </label>

                <div class="password-box">

                    <input
                        type="password"
                        id="password"
                        value="12345678">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        onclick="lihatPassword()">

                        Lihat

                    </button>

                </div>

            </div>


            <!-- ACTION -->

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

function lihatPassword(){

    let password =
        document.getElementById("password");

    if(password.type === "password"){

        password.type = "text";

    }else{

        password.type = "password";

    }

}


function simpan(){

    alert(
        "Perubahan profil berhasil disimpan."
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
