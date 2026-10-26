<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/customer.css">
</head>
<body class="page-customer p-pilih">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php">Beranda</a>
            <a href="booking.php" class="active">Reservasi</a>
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



<!-- CONTENT -->
<div class="content">

<div class="title">
    <h2>Pilih salon</h2>
    <p>Pilih salon yang ingin kamu gunakan untuk reservasi.</p>
</div>


<!-- LUNA SALON -->
<div class="salon-card">

    <div class="salon-header">

        <h3>Luna Salon</h3>

        <button class="pilih"
                onclick="pilihSalon('Luna Salon')">
            Pilih
        </button>

    </div>

    <div class="location">
        📍 Bandung
    </div>

    <div class="detail">

        <div class="detail-item">

            <div class="detail-title">
                Alamat
            </div>

            <div class="detail-text">
                Jl. Merdeka No. 25, Bandung
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Jam Operasional
            </div>

            <div class="detail-text">
                09.00 - 20.00 WIB
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Fasilitas
            </div>

            <div class="fasilitas">
                <span>WiFi</span>
                <span>AC</span>
                <span>Parkir</span>
                <span>Ruang Tunggu</span>
                <span>Toilet</span>
            </div>

        </div>

    </div>

</div>


<!-- SALON ANGGUN -->
<div class="salon-card">

    <div class="salon-header">

        <h3>Salon Anggun</h3>

        <button class="pilih"
                onclick="pilihSalon('Salon Anggun')">
            Pilih
        </button>

    </div>

    <div class="location">
        📍 Jakarta
    </div>

    <div class="detail">

        <div class="detail-item">

            <div class="detail-title">
                Alamat
            </div>

            <div class="detail-text">
                Jl. Sudirman No. 18, Jakarta
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Jam Operasional
            </div>

            <div class="detail-text">
                10.00 - 21.00 WIB
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Fasilitas
            </div>

            <div class="fasilitas">
                <span>WiFi</span>
                <span>AC</span>
                <span>Parkir</span>
                <span>Ruang Tunggu</span>
                <span>Toilet</span>
            </div>

        </div>

    </div>

</div>


<!-- AYU SALON -->
<div class="salon-card">

    <div class="salon-header">

        <h3>Ayu Salon</h3>

        <button class="pilih"
                onclick="pilihSalon('Ayu Salon')">
            Pilih
        </button>

    </div>

    <div class="location">
        📍 Surabaya
    </div>

    <div class="detail">

        <div class="detail-item">

            <div class="detail-title">
                Alamat
            </div>

            <div class="detail-text">
                Jl. Diponegoro No. 10, Surabaya
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Jam Operasional
            </div>

            <div class="detail-text">
                09.00 - 19.00 WIB
            </div>

        </div>


        <div class="detail-item">

            <div class="detail-title">
                Fasilitas
            </div>

            <div class="fasilitas">
                <span>WiFi</span>
                <span>AC</span>
                <span>Parkir</span>
                <span>Ruang Tunggu</span>
                <span>Toilet</span>
            </div>

        </div>

    </div>

</div>

</div>


<!-- BOTTOM NAVIGATION -->
<div class="bottom">

<a href="dashboard.php">
    <span class="icon">🏠</span>
    Beranda
</a>

<a href="pilih_salon.php" class="active">
    <span class="icon">📅</span>
    Reservasi
</a>

<a href="riwayat.php">
    <span class="icon">📋</span>
    Riwayat
</a>

<a href="chat_ai.php">
    <span class="icon">💬</span>
    Tanya AI
</a>

</div>

</div>


<!-- MODAL -->
<div class="modal" id="modalSalon">

<div class="modal-box">

<h2 id="namaSalon">
    Pilih Salon
</h2>

<div class="modal-info">
    Kamu memilih salon ini.
    <br><br>
    Selanjutnya kamu dapat memilih layanan
    dan menentukan apakah ingin dilayani
    oleh Owner atau Pegawai.
</div>

<button class="modal-btn lanjut"
        onclick="lanjutBooking()">
    Lanjut Booking
</button>

<button class="modal-btn batal"
        onclick="tutupModal()">
    Batal
</button>

</div>

</div>


<script>

let salonDipilih = "";

function pilihSalon(nama){

    salonDipilih = nama;

    document.getElementById("namaSalon").innerHTML =
        nama;

    document.getElementById("modalSalon").style.display =
        "flex";
}

function tutupModal(){

    document.getElementById("modalSalon").style.display =
        "none";
}

function lanjutBooking(){

    window.location.href =
        "booking.php?salon=" +
        encodeURIComponent(salonDipilih);
}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
