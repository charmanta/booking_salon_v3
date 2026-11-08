<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // TODO: ganti dengan pengecekan ke database
    if ($username !== '' && $password !== '') {
        $_SESSION['user'] = ['nama' => $username, 'peran' => 'pelanggan'];
        header('Location: customer/dashboard.php');
        exit;
    }
    $error = 'Username dan password wajib diisi.';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="page-split">

<main class="split">

    <!-- ===== PANEL KIRI ===== -->
    <section class="split-left" style="--panel-img:url('assets/images/alat_salon.jpg')">
        <a class="panel-brand" href="index.php" aria-label="Reservin">
            <span class="name">RESERVIN</span>
            <span class="sub">Salon Booking</span>
        </a>

        <h2>Selamat datang kembali</h2>
        <p>Masuk untuk melanjutkan. Kamu bisa login sebagai admin, pegawai, atau customer.</p>

        <a class="panel-foot" href="index.php">Kembali ke beranda</a>
    </section>

    <!-- ===== PANEL KANAN (FORM) ===== -->
    <section class="split-right">
        <a class="back-link" href="index.php">← Kembali ke beranda</a>

        <h1>Masuk</h1>
        <p class="lead">Masuk ke akun Reservin kamu.</p>

        <form method="post" action="login.php">
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="field">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn-block">Login</button>
        </form>

        <div class="form-links">
            Belum punya akun? <a href="registrasi.php">Registrasi customer</a><br>
            Punya salon? <a href="daftar_salon.php">Daftarkan salon</a><br>
            Bingung pilih? <a href="daftar.php">Lihat jenis akun</a>
        </div>
    </section>

</main>

</body>
</html>