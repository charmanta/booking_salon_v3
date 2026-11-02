<?php
/* =====================================================================
   RESERVIN — LAYOUT HEADER ADMIN (admin/includes/header.php)
   Bagian atas kerangka HTML:
   - <head> (Meta, Fonts, Stylesheet CSS)
   - <body> opening
   - Include sidebar
   - Pembuka wrapper .ad-wrap
   - Include topbar
   - Pembuka konten utama <main class="ad-main">
   ===================================================================== */
$judul = isset($page_title) ? $page_title . ' — Reservin Salon' : 'Admin — Reservin Salon Booking';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($judul) ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Admin Terpusat -->
    <link rel="stylesheet" href="css/admin.css">

    <!-- CSS Tambahan (Opsional per Halaman) -->
    <?php if (!empty($extra_css)): ?>
        <?= $extra_css ?>
    <?php endif; ?>
</head>
<body class="ad-body">

    <!-- Sidebar & Mobile Overlay -->
    <?php require __DIR__ . '/sidebar.php'; ?>

    <!-- Pembungkus Konten Utama -->
    <div class="ad-wrap" id="wrap">

        <!-- Topbar Menu & Profil -->
        <?php require __DIR__ . '/topbar.php'; ?>

        <!-- Konten Halaman Spesifik -->
        <main class="ad-main">

