<?php
/* =====================================================================
   RESERVIN — FUNGSI HELPER ADMIN (admin/includes/fungsi.php)
   Kumpulan fungsi pembantu (formatting, icon svg, helper tanggal, dll.)
   ===================================================================== */

if (!function_exists('e')) {
    /**
     * Sanitasi teks untuk output HTML yang aman (XSS Protection)
     */
    function e($s) {
        return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('rupiah')) {
    /**
     * Format angka ke Rupiah standar: Rp150.000
     */
    function rupiah($n) {
        return 'Rp' . number_format((int)$n, 0, ',', '.');
    }
}

if (!function_exists('jt')) {
    /**
     * Format angka ke satuan juta ringkas: Rp2,5 jt
     */
    function jt($v) {
        return 'Rp' . str_replace('.', ',', rtrim(rtrim(number_format($v, 2, '.', ''), '0'), '.')) . ' jt';
    }
}

if (!function_exists('inisial')) {
    /**
     * Ambil inisial huruf dari nama (maksimal 2 huruf kapital)
     */
    function inisial($nama) {
        $k = preg_split('/\s+/', trim((string)$nama));
        if (empty($k[0])) return 'AD';
        $upper = function_exists('mb_strtoupper') ? 'mb_strtoupper' : 'strtoupper';
        $sub   = function_exists('mb_substr') ? 'mb_substr' : 'substr';
        $i = $upper($sub($k[0], 0, 1));
        if (count($k) > 1) {
            $i .= $upper($sub($k[count($k) - 1], 0, 1));
        }
        return $i;
    }
}

if (!function_exists('tglPendek')) {
    /**
     * Format tanggal pendek: 2 Nov
     */
    function tglPendek($ts) {
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return date('j', $ts) . ' ' . ($bulan[(int)date('n', $ts)] ?? '');
    }
}

if (!function_exists('tglHari')) {
    /**
     * Format hari dan tanggal: Sen, 2 Nov 2026
     */
    function tglHari($ts) {
        $hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return ($hari[(int)date('w', $ts)] ?? '') . ', ' . date('j', $ts) . ' ' . ($bulan[(int)date('n', $ts)] ?? '') . ' ' . date('Y', $ts);
    }
}

if (!function_exists('tgl')) {
    /**
     * Format lengkap dengan jam: Sen, 2 Nov 2026 · 14.30
     */
    function tgl($ts) {
        $hari  = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        return ($hari[(int)date('w', $ts)] ?? '') . ', ' . date('j', $ts) . ' ' . ($bulan[(int)date('n', $ts)] ?? '') . ' ' . date('Y', $ts) . ' · ' . date('H.i', $ts);
    }
}

if (!function_exists('ringkasHari')) {
    /**
     * Meringkas daftar hari kerja, contoh: Sen – Sab, Setiap hari
     */
    function ringkasHari($hari, $namaHari = null) {
        if ($namaHari === null) {
            $namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
        }
        $h = $hari;
        sort($h);
        if ($h === [1, 2, 3, 4, 5, 6, 7]) return 'Setiap hari';
        if ($h === [1, 2, 3, 4, 5, 6]) return 'Sen – Sab';
        if ($h === [1, 2, 3, 4, 5]) return 'Sen – Jum';
        return implode(', ', array_map(function ($val) use ($namaHari) { return $namaHari[$val] ?? $val; }, $h));
    }
}

if (!function_exists('ikon')) {
    /**
     * Render ikon SVG garis (stroke) berdasarkan nama ikon
     */
    function ikon($nama) {
        $p = [
            'home'     => '<path d="M3 11l9-8 9 8"/><path d="M5 10v10h5v-6h4v6h5V10"/>',
            'store'    => '<path d="M3 9l1.5-5h15L21 9"/><path d="M4 9v11h16V9"/><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"/><path d="M10 20v-5h4v5"/>',
            'gunting'  => '<circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/>',
            'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.500 20c0-3.600 2.900-6 6.500-6s6.500 2.400 6.500 6"/><circle cx="17.500" cy="9" r="2.500"/><path d="M17 14.200c2.600.2 4.500 2 4.500 4.800"/>',
            'kalender' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/><path d="M8 17l2-2 2 1.500 3-3"/>',
            'laporan'  => '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 3v5h5"/><path d="M9 17v-3M12 17v-5M15 17v-2"/>',
            'user'     => '<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.200 3.600-7 8-7s8 2.800 8 7"/>',
            'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
            'turun'    => '<path d="M6 9l6 6 6-6"/>',
            'menu'     => '<path d="M4 6h16M4 12h10M4 18h16"/>',
            'naik'     => '<path d="M12 19V5M6 11l6-6 6 6"/>',
            'panah'    => '<path d="M5 12h14M13 6l6 6-6 6"/>',
            'plus'     => '<path d="M12 5v14M5 12h14"/>',
            'edit'     => '<path d="M4 20h4L19 9a2.800 2.800 0 0 0-4-4L4 16z"/><path d="M13.500 6.500l4 4"/>',
            'hapus'    => '<path d="M4 7h16M10 11v6M14 11v6"/><path d="M6 7l1 13h10l1-13"/><path d="M9 7V4h6v3"/>',
            'tutup'    => '<path d="M6 6l12 12M18 6L6 18"/>',
            'cek'      => '<path d="M5 12.500l4.500 4.500L19 7.500"/>',
            'koin'     => '<circle cx="12" cy="12" r="9"/><path d="M14.500 9.200c-.5-.8-1.400-1.200-2.500-1.200-1.400 0-2.500.7-2.500 1.800s1 1.500 2.500 1.900 2.500.8 2.500 1.900S13.400 16 12 16c-1.100 0-2-.4-2.500-1.200"/><path d="M12 6v2M12 16v2"/>',
            'pin'      => '<path d="M12 21s7-6.200 7-11.500a7 7 0 0 0-14 0C5 14.800 12 21 12 21z"/><circle cx="12" cy="9.500" r="2.500"/>',
            'jam'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
            'wajah'    => '<circle cx="12" cy="12" r="9"/><path d="M8.500 14.500c1 1.200 2 1.800 3.500 1.800s2.500-.6 3.500-1.800"/><path d="M9 10h.01M15 10h.01"/>',
            'tetes'    => '<path d="M12 3s6 6.200 6 10.500a6 6 0 0 1-12 0C6 9.200 12 3 12 3z"/>',
            'kilau'    => '<path d="M12 3l1.800 5.200L19 10l-5.200 1.800L12 17l-1.800-5.200L5 10l5.200-1.800z"/><path d="M19 17l.7 1.800 1.800.7-1.800.7L19 22l-.7-1.800-1.800-.7 1.800-.7z"/>',
            'mata'     => '<path d="M2 12s3.500-7 10-7 10 7 10 7-3.500 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/>',
            'kunci'    => '<rect x="4" y="10" width="16" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
            'cari'     => '<circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/>',
            'cetak'    => '<path d="M7 9V3h10v6"/><rect x="4" y="9" width="16" height="8" rx="2"/><path d="M7 14h10v7H7z"/>',
            'kamera'   => '<path d="M4 8h3l2-3h6l2 3h3a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1z"/><circle cx="12" cy="13.500" r="3.500"/>',
        ];
        return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
            . ($p[$nama] ?? '') . '</svg>';
    }
}
