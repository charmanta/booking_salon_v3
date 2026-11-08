<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $hp       = trim($_POST['hp'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $konfirm  = $_POST['konfirmasi'] ?? '';

    if ($nama === '' || $hp === '' || $username === '' || $password === '') {
        $error = 'Semua kolom wajib diisi.';
    } elseif ($password !== $konfirm) {
        $error = 'Konfirmasi password tidak sama.';
    } else {
        // TODO: simpan ke database (gunakan password_hash)
        header('Location: login.php?registered=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - Reservin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body class="page-split">

<main class="split">

    <!-- ===== PANEL KIRI ===== -->
    <section class="split-left" style="--panel-img:url('assets/images/warna_rambut.jpg')">
        <a class="panel-brand" href="index.php" aria-label="Reservin">
            <span class="name">RESERVIN</span>
            <span class="sub">Salon Booking</span>
        </a>

        <h2>Booking jadi lebih mudah</h2>
        <p>Buat akun untuk memilih salon dan menentukan jadwal perawatanmu.</p>

        <a class="panel-foot" href="index.php">Kembali ke beranda</a>
    </section>

    <!-- ===== PANEL KANAN (FORM) ===== -->
    <section class="split-right">
        <a class="back-link" href="daftar.php">← Kembali ke pilihan akun</a>

        <h1>Registrasi</h1>
        <p class="lead">Isi data pelangganmu di Reservin.</p>

        <form method="post" action="registrasi.php">
            <?php if ($error): ?>
                <div class="alert-error"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <div class="field">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
            </div>
            <div class="field">
                <label for="hp">No. HP</label>
                <input type="tel" id="hp" name="hp" placeholder="Masukkan nomor HP" value="<?= htmlspecialchars($_POST['hp'] ?? '') ?>" required>
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

            <button type="submit" class="btn-block">Daftar</button>
        </form>

        <div class="form-links">
            Sudah punya akun? <a href="login.php">Masuk</a>
        </div>
    </section>

</main>

</body>
</html>