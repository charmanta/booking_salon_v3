<?php
/* =====================================================================
   RESERVIN — HEADER / TOPBAR CUSTOMER (customer/includes/topbar.php)
   Header atas pelanggan: logo brand Reservin dan tombol aksi cepat.
   ===================================================================== */
$halamanAktif = $current_page ?? basename(parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH));
?>
<!-- ===== HEADER CUSTOMER ===== -->
<header class="site-header site-header--customer">

    <nav class="site-nav">
        <a href="dashboard.php" class="<?= ($halamanAktif === 'dashboard.php') ? 'active' : '' ?>">Beranda</a>
        <a href="pilih_salon.php" class="<?= in_array($halamanAktif, ['pilih_salon.php', 'booking.php'], true) ? 'active' : '' ?>">Reservasi</a>
        <a href="riwayat.php" class="<?= ($halamanAktif === 'riwayat.php') ? 'active' : '' ?>">Riwayat</a>
        <a href="#" class="open-chatbot">Tanya AI</a>
        <a href="../login.php">Keluar</a>
    </nav>

    <a class="brand" href="dashboard.php" aria-label="Reservin">
        <span class="brand-name">RESERVIN</span>
        <span class="brand-sub">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true">
                <circle cx="6" cy="18" r="3"/>
                <circle cx="18" cy="18" r="3"/>
                <path d="M8 16 19 3M16 16 5 3"/>
            </svg> 
            Salon Booking
        </span>
    </a>

    <div class="header-right">
        <a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a>
    </div>

</header>

