<?php
/* =====================================================================
   RESERVIN — LAYOUT HEADER CUSTOMER (customer/includes/header.php)
   Kerangka atas HTML pelanggan:
   - <head> (Meta, Fonts, theme.css, customer.css)
   - <body> opening
   - Include sidebar & overlay (sidebar.php)
   - Include topbar brand header (topbar.php)
   ===================================================================== */
$judul = isset($page_title) ? $page_title . ' — Reservin' : 'Reservin Salon Booking';
$kelasBody = isset($body_class) ? ' ' . $body_class : '';
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

    <!-- CSS Global Tema & Customer -->
    <link rel="stylesheet" href="../assets/css/theme.css">
    <link rel="stylesheet" href="css/customer.css">

    <!-- CSS Tambahan Khusus Halaman (Opsional) -->
    <?php if (!empty($extra_css)): ?>
        <?= $extra_css ?>
    <?php endif; ?>
</head>
<body class="page-customer<?= $kelasBody ?>">

    <!-- Sidebar Navigasi Customer & Mobile Overlay -->
    <?php require __DIR__ . '/sidebar.php'; ?>

    <!-- Header Atas (Brand & CTA Booking) -->
    <?php require __DIR__ . '/topbar.php'; ?>

