<?php
/* =====================================================================
   RESERVIN — SIDEBAR & BURGER CUSTOMER (customer/includes/sidebar.php)
   Komponen navigasi samping customer, tombol burger, profil ringkas,
   dan overlay mobile.
   ===================================================================== */
$halamanAktif = $current_page ?? basename(parse_url($_SERVER['SCRIPT_NAME'] ?? '', PHP_URL_PATH));
?>
<!-- TOMBOL BURGER UNTUK MEMBUKA SIDEBAR -->
<button type="button" class="cm-burger" id="cmBurger" aria-label="Buka menu" aria-expanded="false" aria-controls="cmSide">
    <?= cm_ikon('menu') ?>
</button>

<!-- SIDEBAR CUSTOMER -->
<aside class="cm-side" id="cmSide" aria-label="Menu customer">

    <button type="button" class="cm-tutup" id="cmTutup" aria-label="Tutup menu">
        <?= cm_ikon('tutup') ?>
    </button>

    <a class="cm-logo" href="dashboard.php" aria-label="Reservin Salon Booking">
        <span>
            <b>RESERVIN</b>
            <small>Salon Booking</small>
        </span>
        <?= cm_ikon('gunting') ?>
    </a>

    <nav class="cm-nav">
        <?php foreach ($cmMenu as $url => $m): 
            $isAktif = in_array($halamanAktif, $m['aliases'] ?? [$url], true);
        ?>
            <a href="<?= e($url) ?>"
               class="cm-link<?= $isAktif ? ' active' : '' ?>"
               <?= $isAktif ? 'aria-current="page"' : '' ?>
               <?= !empty($m['blank']) ? 'target="_blank" rel="noopener"' : '' ?>>
                <?= cm_ikon($m['ikon']) ?>
                <?= e($m['judul']) ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="cm-bawah">
        <div class="cm-profil">
            <div class="cm-ava"><?= e($cmUser['inisial'] ?? 'R') ?></div>
            <div>
                <b><?= e($cmUser['nama'] ?? 'Customer') ?></b>
                <small><?= e($cmUser['peran'] ?? 'Reservin Member') ?></small>
            </div>
        </div>

        <a href="../login.php" class="cm-link">
            <?= cm_ikon('logout') ?>
            Keluar
        </a>
    </div>

</aside>

<!-- OVERLAY LATAR GELAP -->
<div class="cm-overlay" id="cmOverlay"></div>

