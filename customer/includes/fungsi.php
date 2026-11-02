<?php
/* =====================================================================
   RESERVIN — FUNGSI HELPER CUSTOMER (customer/includes/fungsi.php)
   Kumpulan fungsi pembantu customer (ikon SVG, format rupiah, tanggal, dll.)
   ===================================================================== */

if (!function_exists('e')) {
    /**
     * Sanitasi teks untuk keamanan output HTML (XSS Protection)
     */
    function e($s) {
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('rp')) {
    /**
     * Format angka ke Rupiah standar: Rp150.000
     */
    function rp($n) {
        return 'Rp' . number_format((int)$n, 0, ',', '.');
    }
}

if (!function_exists('rupiah')) {
    /**
     * Alias fungsi rp()
     */
    function rupiah($n) {
        return rp($n);
    }
}

if (!function_exists('tgl')) {
    /**
     * Format lengkap tanggal dengan jam: Sen, 17 Okt 2026 · 18.00
     */
    function tgl($ts) {
        $hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return ($hari[(int)date('w', $ts)] ?? '') . ', ' 
            . date('j', $ts) . ' ' 
            . ($bulan[(int)date('n', $ts)] ?? '') . ' ' 
            . date('Y', $ts) . ' · ' 
            . date('H.i', $ts);
    }
}

if (!function_exists('tglHari')) {
    /**
     * Format tanggal tanpa jam: Sen, 17 Okt 2026
     */
    function tglHari($ts) {
        $hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return ($hari[(int)date('w', $ts)] ?? '') . ', ' 
            . date('j', $ts) . ' ' 
            . ($bulan[(int)date('n', $ts)] ?? '') . ' ' 
            . date('Y', $ts);
    }
}

if (!function_exists('cm_ikon')) {
    /**
     * Render ikon SVG garis (stroke) untuk panel customer
     */
    function cm_ikon($nama) {
        $p = [
            'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
            'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
            'riwayat'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 13h6M9 17h4"/>',
            'chat'     => '<path d="M21 12a8 8 0 0 1-11.500 7.200L4 21l1.800-5A8 8 0 1 1 21 12z"/>',
            'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
            'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
            'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
            'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
        ];
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
            . ($p[$nama] ?? '') . '</svg>';
    }
}

