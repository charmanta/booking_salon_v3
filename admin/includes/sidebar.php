<?php
/* =====================================================================
   RESERVIN — KOMPONEN SIDEBAR ADMIN (admin/includes/sidebar.php)
   Navigasi samping kiri + logo + info admin ringkas + tombol logout
   ===================================================================== */
$halamanSekarang = $current_page ?? basename($_SERVER['PHP_SELF']);
?>
<!-- ===== SIDEBAR ===== -->
<aside class="ad-side" id="sidebar" aria-label="Menu admin">

    <a class="ad-logo" href="dashboard.php" aria-label="Reservin Salon Booking">
        <span>
            <b>RESERVIN</b>
            <small>Salon Booking</small>
        </span>
        <?= ikon('gunting') ?>
    </a>

    <nav class="ad-nav">
        <?php foreach ($menu_admin as $file => $m): 
            $isActive = ($halamanSekarang === $file);
        ?>
            <a href="<?= e($file) ?>" class="ad-link<?= $isActive ? ' active' : '' ?>"<?= $isActive ? ' aria-current="page"' : '' ?>>
                <?= ikon($m['ikon']) ?>
                <?= e($m['judul']) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="ad-side-bawah">
        <div class="ad-profil">
            <div class="ad-ava"><?= e($admin['inisial'] ?? 'AD') ?></div>
            <div>
                <b><?= e($admin['nama'] ?? 'Admin') ?></b>
                <small><?= e($admin['peran'] ?? 'Administrator') ?></small>
            </div>
        </div>

        <a href="../login.php" class="ad-link">
            <?= ikon('logout') ?>
            Logout
        </a>
    </div>

</aside>

<div class="ad-overlay" id="overlay"></div>
