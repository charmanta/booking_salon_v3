<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-pegawai-detail_booking">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="daftar_booking.php" class="active">Daftar Booking</a>
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

<div class="hero hero--sm">
                <h2>Detail Booking</h2>
            </div>

<section class="content">

<a href="booking.php" class="back">
    ← Kembali ke Daftar Booking
</a>

<div class="page-title">
    
    <p>Periksa informasi pelanggan dan pembayaran.</p>
</div>

<!-- DATA BOOKING -->
<div class="card">

    <div class="card-top">

        <div class="kode">
            RSV-001
        </div>

        <div class="status">
            Menunggu Verifikasi
        </div>

    </div>

    <div class="detail-grid">

        <div class="detail-item">
            <div class="detail-label">
                Nama Pelanggan
            </div>
            <div class="detail-value">
                Rina
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                No. Telepon
            </div>
            <div class="detail-value">
                081234567890
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Nama Salon
            </div>
            <div class="detail-value">
                Luna Salon
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Layanan
            </div>
            <div class="detail-value">
                Creambath
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Tanggal Booking
            </div>
            <div class="detail-value">
                17 Oktober 2026
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Jam Booking
            </div>
            <div class="detail-value">
                10:00
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Pegawai
            </div>
            <div class="detail-value">
                Siti Amelia
            </div>
        </div>

        <div class="detail-item">
            <div class="detail-label">
                Status Pembayaran
            </div>
            <div class="detail-value">
                <span class="payment-status">
                    Menunggu Verifikasi
                </span>
            </div>
        </div>

    </div>

</div>

<!-- PEMBAYARAN -->
<div class="card">

    <div class="payment-title">
        Pembayaran
    </div>

    <div class="payment">

        <div class="payment-item">

            <div class="payment-label">
                Total Harga
            </div>

            <div class="payment-value">
                Rp 100.000
            </div>

        </div>

        <div class="payment-item">

            <div class="payment-label">
                DP Dibayarkan
            </div>

            <div class="payment-value">
                Rp 50.000
            </div>

        </div>

        <div class="payment-item">

            <div class="payment-label">
                Metode Pembayaran
            </div>

            <div class="payment-value">
                Transfer
            </div>

        </div>

        <div class="payment-item">

            <div class="payment-label">
                Status
            </div>

            <div class="payment-value">
                <span class="payment-status">
                    Menunggu Verifikasi
                </span>
            </div>

        </div>

    </div>

    <!-- BUKTI TRANSFER -->
    <div class="transfer">

        <div class="transfer-title">
            Bukti Transfer
        </div>

        <img
            src="../uploads/bukti_transfer.jpg"
            class="transfer-image"
            alt="Bukti Transfer"
            onclick="bukaBukti()">

        <div class="transfer-note">
            Klik gambar untuk melihat bukti transfer
            lebih besar.
        </div>

    </div>

    <!-- TOTAL -->
    <div class="total">

        <div class="total-row">
            <span>Total Harga</span>
            <span>Rp 100.000</span>
        </div>

        <div class="total-row">
            <span>DP</span>
            <span>Rp 50.000</span>
        </div>

        <div class="total-row final">
            <span>Sisa Pembayaran</span>
            <span>Rp 50.000</span>
        </div>

    </div>

    <!-- ACTION -->
    <div class="actions">

        <button
            class="btn btn-success"
            onclick="terimaPembayaran()">

            ✓ Terima Pembayaran

        </button>

        <button
            class="btn btn-danger"
            onclick="tolakPembayaran()">

            ✕ Tolak Pembayaran

        </button>

    </div>

</div>

</section>

</main>

</div>

<!-- MODAL BUKTI -->
<div class="modal" id="modalBukti">

    <span
        class="close"
        onclick="tutupBukti()">

        ×

    </span>

    <img
        src="../uploads/bukti_transfer.jpg"
        alt="Bukti Transfer">

</div>

<script>

function bukaBukti(){

    document
    .getElementById("modalBukti")
    .style.display="flex";

}

function tutupBukti(){

    document
    .getElementById("modalBukti")
    .style.display="none";

}

function terimaPembayaran(){

    let yakin=confirm(
        "Apakah bukti transfer sudah benar dan pembayaran diterima?"
    );

    if(yakin){

        alert(
            "Pembayaran diterima. Booking berhasil dikonfirmasi."
        );

    }

}

function tolakPembayaran(){

    let alasan=prompt(
        "Masukkan alasan penolakan bukti transfer:"
    );

    if(alasan){

        alert(
            "Bukti transfer ditolak.\nAlasan: "
            + alasan
        );

    }

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
