<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/customer.css">
</head>
<body class="page-home">

    <!-- ===== HEADER ===== -->
    <header class="site-header ">
        <nav class="site-nav">
            <a href="index.php#peran">Untuk Siapa</a>
            <a href="index.php#fitur">Fitur</a>
            <a href="index.php#cara">Cara Kerja</a>
            <a href="index.php#salon">Salon</a>
        </nav>
        <a class="brand" href="index.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a class="btn-plain" href="login.php">Masuk</a><a href="login.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>


    <!-- ===== HERO ===== -->
    <section class="lp-hero">
        <div class="wrap lp-grid">
            <div>
                <span class="eyebrow">Platform booking salon</span>
                <h1>Satu tempat untuk <em>semua salon</em> favoritmu.</h1>
                <p class="lead">Selamat datang di website booking salon. Pelanggan memesan layanan dan jadwal dengan mudah, pemilik salon mengelola layanan, pegawai dan laporan dalam satu platform.</p>
                <div class="lp-cta">
                    <a href="login.php" class="btn">Booking Sekarang</a>
                    <a href="daftar_salon.php" class="btn btn-ghost">Daftarkan Salon</a>
                </div>
                <div class="lp-trust">
                    <div><b>3</b>jenis akun</div>
                    <div><b>24 jam</b>booking online</div>
                    <div><b>1 klik</b>ganti jadwal</div>
                </div>
            </div>

            <div class="mock-wrap" aria-hidden="true">
                <span class="blob a"></span><span class="blob b"></span>
                <span class="chip a">✓ DP sudah dibayar</span>
                <span class="chip b">✿ Dilayani Owner</span>
                <div class="mock">
                    <div class="mock-top"><span>RSV-001</span><em>Dikonfirmasi</em></div>
                    <h4>Luna Salon</h4>
                    <div class="sub">📍 Bandung · 09.00 – 20.00 WIB</div>
                    <ul>
                        <li>Creambath <b>Rp100.000</b></li>
                        <li>Hair Spa <b>Rp150.000</b></li>
                    </ul>
                    <div class="mock-slots"><i>10:00</i><i class="on">13:00</i><i>15:00</i></div>
                    <a class="btn">Konfirmasi Reservasi</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 3 JENIS PENGGUNA ===== -->
    <section class="lp-section alt" id="peran">
        <div class="wrap">
            <div class="lp-head">
                <span class="eyebrow">Satu platform, tiga peran</span>
                <h2>Dibuat untuk semua orang di salon</h2>
                <p>Setiap pengguna punya tampilan sendiri yang disesuaikan dengan kebutuhannya.</p>
            </div>
            <div class="roles">
                <div class="role featured">
                    <span class="ic">💅</span>
                    <h3>Booking</h3>
                    <p>Pesan layanan salon sesuai kebutuhanmu dan tentukan jadwal yang kamu inginkan.</p>
                    <ul><li>Pilih salon &amp; layanan</li><li>Booking bersama teman</li><li>Ganti jadwal dari riwayat</li></ul>
                    <a href="login.php" class="btn">Booking Sekarang</a>
                </div>
                <div class="role">
                    <span class="ic">🏪</span>
                    <h3>Daftarkan Salon</h3>
                    <p>Pemilik salon dapat mendaftarkan salon dan mengelola layanan serta booking pelanggan.</p>
                    <ul><li>Data salon &amp; fasilitas</li><li>Layanan, harga &amp; durasi</li><li>Pegawai &amp; laporan penghasilan</li></ul>
                    <a href="daftar_salon.php" class="btn">Daftarkan Salon</a>
                </div>
                <div class="role">
                    <span class="ic">✂️</span>
                    <h3>Pegawai</h3>
                    <p>Pegawai melihat jadwal booking, memeriksa pembayaran dan mengonfirmasi pesanan pelanggan.</p>
                    <ul><li>Daftar &amp; filter booking</li><li>Verifikasi bukti transfer</li><li>Profil &amp; akun pribadi</li></ul>
                    <a href="login.php" class="btn btn-ghost">Masuk sebagai Pegawai</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FITUR ===== -->
    <section class="lp-section" id="fitur">
        <div class="wrap">
            <div class="lp-head">
                <span class="eyebrow">Fitur lengkap</span>
                <h2>Semua yang dibutuhkan salon modern</h2>
            </div>
            <div class="features">
                <div class="feat"><span class="n">01</span><h3>Pilih salon</h3><p>Temukan salon lengkap dengan alamat, jam operasional dan fasilitasnya.</p></div>
                <div class="feat"><span class="n">02</span><h3>Reservasi fleksibel</h3><p>Pilih layanan, orang yang dilayani, serta dilayani oleh Pegawai atau Owner.</p></div>
                <div class="feat"><span class="n">03</span><h3>Ganti jadwal</h3><p>Ubah tanggal dan jam langsung dari riwayat booking sampai 30 menit sebelumnya.</p></div>
                <div class="feat"><span class="n">04</span><h3>Pembayaran DP</h3><p>Unggah bukti transfer, pegawai memverifikasi dan booking langsung dikonfirmasi.</p></div>
                <div class="feat"><span class="n">05</span><h3>Kelola salon</h3><p>Atur data salon, layanan, harga, durasi, fasilitas dan data pegawai.</p></div>
                <div class="feat"><span class="n">06</span><h3>Laporan penghasilan</h3><p>Pantau penghasilan per bulan dan layanan terlaris lewat grafik yang jelas.</p></div>
            </div>
        </div>
    </section>

    <!-- ===== CARA KERJA ===== -->
    <section class="lp-section tint" id="cara">
        <div class="wrap">
            <div class="lp-head">
                <span class="eyebrow">Mudah &amp; cepat</span>
                <h2>Cara kerja</h2>
            </div>
            <div class="steps">
                <div class="step"><h3>Pilih salon &amp; layanan</h3><p>Telusuri salon dan pilih perawatan yang kamu inginkan.</p></div>
                <div class="step"><h3>Tentukan jadwal</h3><p>Pilih tanggal, jam dan siapa yang melayani.</p></div>
                <div class="step"><h3>Bayar DP &amp; datang</h3><p>Konfirmasi reservasi, bayar DP, lalu nikmati perawatanmu.</p></div>
            </div>
        </div>
    </section>

    <!-- ===== SALON ===== -->
    <section class="lp-section alt" id="salon">
        <div class="wrap">
            <div class="lp-head">
                <span class="eyebrow">Salon yang tersedia</span>
                <h2>Pilih salon favoritmu</h2>
            </div>
            <div class="salons">
                <div class="salon-tile"><div class="ph">💇‍♀️</div><div class="bd"><h3>Luna Salon</h3><p>📍 Bandung · 09.00 – 20.00 WIB</p><a href="login.php" class="btn">Booking</a></div></div>
                <div class="salon-tile"><div class="ph">💄</div><div class="bd"><h3>Salon Anggun</h3><p>📍 Jakarta · 10.00 – 21.00 WIB</p><a href="login.php" class="btn">Booking</a></div></div>
                <div class="salon-tile"><div class="ph">🌸</div><div class="bd"><h3>Ayu Salon</h3><p>📍 Surabaya · 09.00 – 19.00 WIB</p><a href="login.php" class="btn">Booking</a></div></div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="lp-section" style="padding-top:20px">
        <div class="wrap">
            <div class="cta-band">
                <h2>Punya salon? Bawa online hari ini.</h2>
                <p>Daftarkan salonmu, atur layanan dan pegawai, lalu terima booking pelanggan setiap hari.</p>
                <div class="row">
                    <a href="daftar_salon.php" class="btn">Daftarkan Salon</a>
                    <a href="login.php" class="btn btn-line">Booking Sekarang</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="lp-footer">
        <div class="wrap">
            <div class="g">
                <div><span class="brand-name">RESERVIN</span><p style="margin-top:12px;max-width:280px">Platform booking salon untuk pelanggan, pemilik salon dan pegawai.</p></div>
                <div><h4>Platform</h4><ul><li><a href="#peran">Untuk siapa</a></li><li><a href="#fitur">Fitur</a></li><li><a href="#cara">Cara kerja</a></li></ul></div>
                <div><h4>Akun</h4><ul><li><a href="login.php">Masuk</a></li><li><a href="Registrasi.php">Registrasi</a></li><li><a href="daftar_salon.php">Daftarkan salon</a></li></ul></div>
                <div><h4>Salon</h4><ul><li>Luna Salon</li><li>Salon Anggun</li><li>Ayu Salon</li></ul></div>
            </div>
            <div class="copy">© Reservin · Booking Salon</div>
        </div>
    </footer>

</body>
</html>
