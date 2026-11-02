<?php
/* =====================================================================
   RESERVIN — INISIALISASI CUSTOMER (customer/includes/init.php)
   File konfigurasi utama customer:
   - Pengaturan timezone
   - Pemanggilan file helper fungsi.php
   - Inisialisasi data profil user customer
   - Konfigurasi daftar menu sidebar customer terpusat
   ===================================================================== */

date_default_timezone_set('Asia/Jakarta');

require_once __DIR__ . '/fungsi.php';

// Data pengguna yang sedang login (dapat diganti dengan data dari $_SESSION)
if (!isset($cmUser) || !is_array($cmUser)) {
    $cmUser = [
        'nama'    => 'Rina',
        'peran'   => 'Reservin Member',
        'inisial' => 'R',
    ];
}

/**
 * DAFTAR MENU SIDEBAR CUSTOMER
 * Key: URL tujuan
 * Value: [
 *   'judul'   => Label teks menu,
 *   'ikon'    => Nama ikon di fungsi.php,
 *   'blank'   => Buka di tab baru (true/false),
 *   'aliases' => Nama-nama file halaman yang menandai menu ini aktif
 * ]
 */
$cmMenu = [
    'dashboard.php'   => [
        'judul'   => 'Beranda',
        'ikon'    => 'home',
        'blank'   => false,
        'aliases' => ['dashboard.php'],
    ],
    'pilih_salon.php' => [
        'judul'   => 'Reservasi',
        'ikon'    => 'kalender',
        'blank'   => false,
        'aliases' => ['pilih_salon.php', 'booking.php'],
    ],
    'riwayat.php'     => [
        'judul'   => 'Riwayat',
        'ikon'    => 'riwayat',
        'blank'   => false,
        'aliases' => ['riwayat.php'],
    ],
    'https://gemini.google.com/' => [
        'judul'   => 'Tanya AI',
        'ikon'    => 'chat',
        'blank'   => true,
        'aliases' => [],
    ],
];

