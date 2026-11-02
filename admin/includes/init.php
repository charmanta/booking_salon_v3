<?php
/* =====================================================================
   RESERVIN — INISIALISASI ADMIN (admin/includes/init.php)
   File konfigurasi utama admin:
   - Pengaturan timezone
   - Pemanggilan file helper fungsi.php
   - Inisialisasi data admin (session/mock)
   - Konfigurasi daftar menu navigasi admin terpusat
   ===================================================================== */

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/fungsi.php';

// Data profil admin yang sedang login
// (Nantinya saat integrasi database, ganti dengan data dari $_SESSION)
if (!isset($admin) || !is_array($admin)) {
    $admin = [
        'nama'    => 'Siti Amelia',
        'peran'   => 'Pemilik Salon',
        'inisial' => 'SA',
    ];
}

// Pastikan inisial selalu ada jika nama terisi
if (empty($admin['inisial']) && !empty($admin['nama'])) {
    $admin['inisial'] = inisial($admin['nama']);
}

/**
 * DAFTAR MENU ADMIN TERPUSAT
 * Tim cukup menambah, mengubah, atau menghapus item di array ini:
 * Key  : Nama file URL (misal: 'dashboard.php')
 * Value: [
 *   'judul' => Label teks menu,
 *   'ikon'  => Nama ikon SVG di fungsi.php (home, store, gunting, users, kalender, laporan, user)
 * ]
 */
$menu_admin = [
    'dashboard.php' => ['judul' => 'Dashboard',  'ikon' => 'home'],
    'salon.php'     => ['judul' => 'Data Salon', 'ikon' => 'store'],
    'layanan.php'   => ['judul' => 'Layanan',    'ikon' => 'gunting'],
    'pegawai.php'   => ['judul' => 'Pegawai',    'ikon' => 'users'],
    'jadwal.php'    => ['judul' => 'Jadwal',     'ikon' => 'kalender'],
    'laporan.php'   => ['judul' => 'Laporan',    'ikon' => 'laporan'],
    'profil.php'    => ['judul' => 'Profil',     'ikon' => 'user'],
];

