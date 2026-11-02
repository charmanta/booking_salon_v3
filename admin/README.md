# Panduan Struktur Komponen Admin (Reservin)

Dokumentasi ini dibuat agar seluruh anggota tim dapat mengubah tampilan (UI/CSS), alur kode (PHP/HTML), formulir modal, maupun script (JS) dengan cepat dan mudah tanpa bingung mencari letak kodenya.

---

## 📁 Struktur Direktori `admin/`

```text
admin/
│
├── includes/                      # Komponen layout & fungsi utama
│   ├── init.php                   # Bootstrapper: timezone, sesi admin & daftar menu navigasi
│   ├── fungsi.php                 # Helper fungsi global (ikon SVG, format rupiah, tanggal, inisial, escaping)
│   ├── header.php                 # Kerangka HTML atas (<head>, CSS, pembuka body, sidebar, topbar)
│   ├── topbar.php                 # Header atas (burger toggle, profil pengguna, dropdown menu)
│   ├── sidebar.php                # Navigasi samping kiri dengan deteksi menu aktif otomatis
│   └── footer.php                 # Kerangka HTML bawah (footer copyright, penutup div, admin.js)
│
├── modals/                        # Pop-up formulir (Modal Dialogs)
│   ├── modal_layanan.php          # Modal formulir Tambah / Edit Layanan
│   ├── modal_pegawai.php          # Modal formulir Tambah / Edit Pegawai & Akun
│   ├── modal_jadwal.php           # Modal pengaturan Jadwal Kerja Mingguan
│   └── modal_invoice.php          # Modal rincian Invoice & Cetak Dokumen
│
├── css/
│   └── admin.css                  # Seluruh styling CSS terpusat & terbagi rapi per bagian
│
├── js/
│   └── admin.js                   # JavaScript global admin (toggle sidebar, dropdown profil, responsive)
│
├── dashboard.php                  # Halaman Beranda / Dashboard
├── salon.php                      # Halaman Pengaturan Data Salon & Fasilitas
├── layanan.php                    # Halaman Data Layanan Salon
├── pegawai.php                    # Halaman Data Pegawai Salon
├── jadwal.php                     # Halaman Matriks Jadwal Kerja Pegawai
├── laporan.php                    # Halaman Laporan Keuangan & Riwayat Transaksi
└── profil.php                     # Halaman Profil Admin & Ringkasan Salon
```

---

## 🧭 Panduan Cepat untuk Tim Developer

| Kebutuhan Anda | File yang Perlu Diedit |
| :--- | :--- |
| **Menambah / Mengubah Menu Sidebar** | `admin/includes/init.php` (array `$menu_admin`) |
| **Mengubah Tampilan Sidebar & Logo** | `admin/includes/sidebar.php` |
| **Mengubah Header Atas / Profil Dropdown** | `admin/includes/topbar.php` |
| **Mengubah Warna, Font, Grid, atau CSS** | `admin/css/admin.css` |
| **Mengubah Interaksi Global (Sidebar Buka/Tutup)** | `admin/js/admin.js` |
| **Menambah Ikon SVG atau Fungsi Helper** | `admin/includes/fungsi.php` |
| **Mengubah Form Modal Pop-up** | `admin/modals/modal_{nama_halaman}.php` |
| **Mengubah Isi/Data Halaman Tertentu** | Buka langsung file halaman terkait, misal: `admin/layanan.php` |

---

## 🚀 Cara Membuat Halaman Admin Baru

Setiap halaman baru cukup mengikuti pola standar berikut:

```php
<?php
// 1. Tentukan judul dan nama file halaman aktif
$page_title   = 'Nama Halaman Baru';
$current_page = 'halaman_baru.php';

// 2. Muat konfigurasi & fungsi helper
require_once __DIR__ . '/includes/init.php';

// 3. Taruh logika PHP / data halaman di sini
// ...

// 4. Muat kerangka header (otomatis merender sidebar & topbar)
require_once __DIR__ . '/includes/header.php';
?>

<!-- 5. KONTEN UTAMA HALAMAN -->
<section class="ad-sapa">
    <h1>Judul Halaman</h1>
    <p>Deskripsi halaman Anda.</p>
</section>

<section class="ad-kartu">
    <!-- Konten kartu / tabel / formulir -->
</section>

<?php
// 6. Muat kerangka footer (otomatis memuat script admin.js)
require_once __DIR__ . '/includes/footer.php';
?>
```

