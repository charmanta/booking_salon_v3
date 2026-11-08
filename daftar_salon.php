<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaSalon  = trim($_POST['nama_salon'] ?? '');
    $alamat     = trim($_POST['alamat_salon'] ?? '');
    $jam        = trim($_POST['jam_operasional'] ?? '');
    $namaAdmin  = trim($_POST['nama_admin'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';
    $konfirm    = $_POST['konfirmasi'] ?? '';

    if ($namaSalon === '' || $alamat === '' || $jam === '' || $namaAdmin === '' || $username === '' || $password === '') {
        $error = 'Semua kolom wajib diisi.';
    } elseif ($password !== $konfirm) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        // TODO: simpan salon + akun admin ke database (gunakan password_hash)
        header('Location: login.php?salon=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Salon - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="page-split">

<main class="split">

    <!-- ===== PANEL KIRI ===== -->
    <section class="split-left" style="--panel-img:url('assets/images/produk_salon.jpg')">
        <a class="panel-brand" href="index.php" aria-label="Reservin">
            <span class="name">RESERVIN</span>
            <span class="sub">Salon Booking</span>
        </a>

        <h2>Kelola salonmu di satu tempat</h2>
        <p>Daftarkan salon, atur layanan, pegawai, dan jadwal dalam satu aplikasi.</p>

        <a class="panel-foot" href="index.php">Kembali ke beranda</a>
    </section>

    <!-- ===== PANEL KANAN (FORM) ===== -->
    <section class="split-right">
        <a class="back-link" href="daftar.php">← Kembali ke pilihan akun</a>

        <h1>Daftar Salon</h1>
        <p class="lead">Isi data untuk mendaftarkan salonmu.</p>

        <form method="post" action="daftar_salon.php">
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <h3>Data salon</h3>
            <div class="field">
                <label for="nama_salon">Nama Salon</label>
                <input type="text" id="nama_salon" name="nama_salon" placeholder="Contoh: Luna Salon" value="<?= htmlspecialchars($_POST['nama_salon'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="alamat_salon">Alamat Salon</label>
                <input type="text" id="alamat_salon" name="alamat_salon" placeholder="Jalan, kota" value="<?= htmlspecialchars($_POST['alamat_salon'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="jam_operasional">Jam Operasional</label>
                <input type="text" id="jam_operasional" name="jam_operasional" placeholder="Contoh: 09.00 - 20.00" value="<?= htmlspecialchars($_POST['jam_operasional'] ?? '') ?>" required>
            </div>

            <h3>Akun admin</h3>
            <div class="field">
                <label for="nama_admin">Nama Admin</label>
                <input type="text" id="nama_admin" name="nama_admin" placeholder="Nama lengkap admin" value="<?= htmlspecialchars($_POST['nama_admin'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Buat username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Buat password" required>
            </div>
            <div class="field">
                <label for="konfirmasi">Konfirmasi Password</label>
                <input type="password" id="konfirmasi" name="konfirmasi" placeholder="Ulangi password" required>
            </div>

            <button type="submit" class="btn-block">Daftarkan Salon</button>
        </form>

        <div class="form-links">
            Sudah ada akun? <a href="login.php">Masuk</a>
        </div>
    </section>

</main>

</body>
</html>