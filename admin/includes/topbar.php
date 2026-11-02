<?php
/* =====================================================================
   RESERVIN — KOMPONEN TOPBAR ADMIN (admin/includes/topbar.php)
   Header atas: Tombol burger menu (mobile/desktop toggle) dan
   dropdown profil admin / logout di kanan atas.
   ===================================================================== */
?>
<!-- ===== TOPBAR / HEADER ===== -->
<header class="ad-top">

    <button
        type="button"
        class="ad-burger"
        id="burger"
        aria-label="Buka menu"
        aria-expanded="false"
        aria-controls="sidebar">
        <?= ikon('menu') ?>
    </button>

    <div class="ad-user-wrap">

        <button
            type="button"
            class="ad-user"
            id="userBtn"
            aria-haspopup="true"
            aria-expanded="false">

            <span class="ad-ava"><?= e($admin['inisial'] ?? 'SA') ?></span>

            <span class="ad-user-info">
                <b><?= e($admin['nama'] ?? 'Admin') ?></b>
                <small><?= e($admin['peran'] ?? 'Administrator') ?></small>
            </span>

            <?= ikon('turun') ?>

        </button>

        <div class="ad-dd" id="userMenu">
            <a href="profil.php"><?= ikon('user') ?> Profil</a>
            <a href="../login.php"><?= ikon('logout') ?> Logout</a>
        </div>

    </div>

</header>

