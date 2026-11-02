# Panduan Struktur Komponen Customer (Reservin)

Dokumentasi ini dibuat agar tim pengembang dapat mengganti atau memodifikasi tampilan (UI/CSS), alur data (PHP/HTML), pop-up modal, maupun script logika pelanggan (JS) dengan cepat dan teratur tanpa kebingungan mencari letak kodenya.

---

## 📁 Struktur Direktori `customer/`

```text
customer/
│
├── includes/                         # Komponen layout & fungsi utama pelanggan
│   ├── init.php                      # Bootstrapper: timezone, inisialisasi user customer & menu sidebar
│   ├── fungsi.php                    # Helper fungsi global (ikon SVG, sanitasi XSS, rupiah, format tanggal)
│   ├── header.php                    # Kerangka HTML atas (<head>, CSS, body opening, sidebar, topbar)
│   ├── topbar.php                    # Header brand & menu navigasi horizontal (tampilan desktop)
│   ├── sidebar.php                   # Sidebar drawer & tombol burger (hanya aktif di tampilan mobile)
│   └── footer.php                    # Kerangka HTML bawah (footer copyright, customer.js, tag penutup)
│
├── modals/                           # Pop-up dialog interaktif (Modals)
│   ├── modal_pilih_salon.php         # Modal konfirmasi saat memilih cabang salon
│   ├── modal_jadwal_booking.php      # Modal pemilihan tanggal & slot jam saat reservasi
│   ├── modal_ganti_jadwal.php        # Modal kalender interaktif untuk reschedule jadwal booking
│   └── modal_invoice.php             # Modal rincian invoice transaksi digital (cetak & PDF)
│
├── css/
│   └── customer.css                  # CSS customer terpusat & terorganisir per komponen
│
├── js/
│   └── customer.js                   # JavaScript global customer (sidebar toggle, overlay, ESC key)
│
├── dashboard.php                     # Halaman Beranda (Hero sambutan, grid navigasi, galeri slider)
├── pilih_salon.php                   # Halaman Katalog Salon (Carousel cabang salon & fasilitas)
├── booking.php                       # Halaman Formulir Reservasi (Multi-orang, pegawai, rincian biaya, bukti bayar)
├── riwayat.php                       # Halaman Riwayat Transaksi (Tab filter status, ganti jadwal, invoice)
├── customer.css                      # Compatibility file (mengimpor css/customer.css)
└── customer_menu.php                 # Wrapper kompatibilitas mundur
```

---

## 🧭 Panduan Cepat untuk Tim Developer

| Kebutuhan Anda | File yang Perlu Diedit |
| :--- | :--- |
| **Menambah / Mengubah Menu Sidebar Customer** | `customer/includes/init.php` (array `$cmMenu`) |
| **Mengubah Struktur Tampilan Sidebar & Logo** | `customer/includes/sidebar.php` |
| **Mengubah Header Atas / Logo Brand** | `customer/includes/topbar.php` |
| **Mengubah Warna, Font, Card, atau CSS Terpusat** | `customer/css/customer.css` |
| **Mengubah Modal Konfirmasi Salon** | `customer/modals/modal_pilih_salon.php` |
| **Mengubah Modal Jadwal & Jam Booking** | `customer/modals/modal_jadwal_booking.php` |
| **Mengubah Modal Kalender Ganti Jadwal** | `customer/modals/modal_ganti_jadwal.php` |
| **Mengubah Format / Tampilan Modal Invoice** | `customer/modals/modal_invoice.php` & `customer/css/customer.css` (bagian 7) |
| **Menambah Ikon SVG Baru** | `customer/includes/fungsi.php` (fungsi `cm_ikon()`) |
| **Menambah Helper Format Angka / Tanggal** | `customer/includes/fungsi.php` (`rp()`, `tgl()`, `tglHari()`) |

---

## ⚙️ Cara Kerja Setiap Halaman Customer

Setiap halaman customer (`dashboard.php`, `pilih_salon.php`, `booking.php`, `riwayat.php`) menggunakan standar modular:

```php
<?php
// 1. Inisialisasi konfigurasi dasar & fungsi helper
require_once __DIR__ . '/includes/init.php';

// 2. Set metadata halaman
$page_title   = 'Nama Halaman';
$current_page = 'nama_file.php';
$body_class   = 'p-nama_halaman';

// 3. (Opsional) Inject CSS atau JS tambahan khusus halaman
$extra_js = '<script> ... </script>';

// 4. Panggil Header & Navigasi
require __DIR__ . '/includes/header.php';
?>

<!-- Konten Halaman Anda Disini -->

<?php
// 5. (Opsional) Panggil modal jika diperlukan
// require __DIR__ . '/modals/modal_contoh.php';

// 6. Panggil Footer & Script Global
require __DIR__ . '/includes/footer.php';
?>
```

---

## 🎨 Organisasi Bagian CSS (`customer/css/customer.css`)

CSS telah dikelompokkan dengan penomoran jelas:
1. **Root Variables & Layout Dasar** (variabel warna `--cm-*`, reset link dan button)
2. **Navigasi Sidebar Customer** (`.cm-burger`, `.cm-side`, `.cm-link`, `.cm-profil`, `.cm-overlay`)
3. **Header / Topbar** (`.site-header--customer`, `.brand`, `.site-nav`)
4. **Beranda / Dashboard** (`.customer-hero`, `.quick-grid`, `.customer-gallery`)
5. **Halaman Pilih Salon** (`.select-page`, `.salon-carousel`, `.salon-card-new`, `.chips`)
6. **Halaman Reservasi / Booking** (`.hero-booking`, `.person`, `.pay-box`, `.upload-box`, `.jm-overlay`, `.jm-box`)
7. **Halaman Riwayat & Invoice** (`.rv-card`, `.rv-tabs`, `.rv-b`, `.iv-overlay`, `.iv-box`, print optimization)
8. **Media Queries & Responsif Mobile** (breakpoint 900px dan 560px)
9. **Efek Interaktif & Tactile Animation** (Ripple wave, hover elevation, active button press down, modal pop-up & backdrop blur)

---

## ✨ Sistem Animasi & Efek Interaktif Tombol

Setiap pergerakan pada folder customer telah dirancang memiliki umpan balik visual (*tactile feedback*):
- **Efek Tekan Fisik (`:active`)**: Ketika tombol ditekan, tombol akan tertekan ke bawah (`scale(0.96)` & `translateY(1.5px)`) memberikan sensasi klik yang nyata.
- **Efek Ripple Wave**: Gelombang cahaya dinamis muncul dari koordinat kursor pengguna saat tombol ditekan (dikelola oleh `js/customer.js`).
- **Efek Hover Kartu**: Kartu salon terangkat (`translateY(-8px)`) dengan foto salon yang melakukan *zoom* halus (`scale(1.05)`).
- **Animasi Modal Pop-up**: Modal muncul dengan animasi *slide-up + scale* (`cmModalIn`) disertai *backdrop blur* modern.
- **Slot Tanggal & Jam**: Tanggal & jam yang diklik memiliki efek pantulan lembut (`cmPopIn`) dan aksen bayangan tan.

