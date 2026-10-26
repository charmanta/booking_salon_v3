<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-admin-layanan">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="salon.php">Data Salon</a>
            <a href="layanan.php" class="active">Layanan</a>
            <a href="pegawai.php">Pegawai</a>
            <a href="laporan.php">Laporan</a>
            <a href="profil.php">Profil</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <div class="user-chip"><span class="avatar">SA</span><span><b>Siti Amelia</b><small>Pemilik Salon</small></span></div>
            <a href="../login.php" class="btn btn-cta" style="padding:26px 34px">Logout</a>
        </div>
    </header>



<div class="app">

<!-- SIDEBAR -->




<!-- MAIN -->

<main class="main">

<!-- TOPBAR -->

<div class="hero hero--sm">
                <h2>Layanan Salon</h2>
            </div>


<!-- CONTENT -->

<section class="content">

    <div class="page-title">

        

        <p>
            Kelola layanan yang tersedia di salon Anda.
        </p>

    </div>


    <!-- HEADER -->

    <div class="page-header">

        <div>

            <b>
                Daftar Layanan
            </b>

        </div>


        <button
            class="btn btn-primary"
            onclick="bukaModalTambah()">

            + Tambah Layanan

        </button>

    </div>


    <!-- TABLE -->

    <div class="card">

        <div class="table-wrapper">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Nama Layanan
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Durasi
                        </th>

                        <th>
                            Keterangan
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>
                            1
                        </td>

                        <td>

                            <div class="service-name">
                                Creambath
                            </div>

                        </td>

                        <td>

                            <div class="price">
                                Rp100.000
                            </div>

                        </td>

                        <td>

                            <div class="duration">
                                60 menit
                            </div>

                        </td>

                        <td>
                            Perawatan rambut dan kulit kepala.
                        </td>

                        <td>

                            <div class="action">

                                <button
                                    class="edit"
                                    onclick="editLayanan('Creambath','100000','60','Perawatan rambut dan kulit kepala.')">

                                    Edit

                                </button>


                                <button
                                    class="delete"
                                    onclick="hapusLayanan('Creambath')">

                                    Hapus

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>
                            2
                        </td>

                        <td>

                            <div class="service-name">
                                Hair Spa
                            </div>

                        </td>

                        <td>

                            <div class="price">
                                Rp150.000
                            </div>

                        </td>

                        <td>

                            <div class="duration">
                                90 menit
                            </div>

                        </td>

                        <td>
                            Perawatan rambut intensif.
                        </td>

                        <td>

                            <div class="action">

                                <button
                                    class="edit"
                                    onclick="editLayanan('Hair Spa','150000','90','Perawatan rambut intensif.')">

                                    Edit

                                </button>


                                <button
                                    class="delete"
                                    onclick="hapusLayanan('Hair Spa')">

                                    Hapus

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>
                            3
                        </td>

                        <td>

                            <div class="service-name">
                                Potong Rambut
                            </div>

                        </td>

                        <td>

                            <div class="price">
                                Rp50.000
                            </div>

                        </td>

                        <td>

                            <div class="duration">
                                45 menit
                            </div>

                        </td>

                        <td>
                            Potong rambut sesuai model pilihan.
                        </td>

                        <td>

                            <div class="action">

                                <button
                                    class="edit"
                                    onclick="editLayanan('Potong Rambut','50000','45','Potong rambut sesuai model pilihan.')">

                                    Edit

                                </button>


                                <button
                                    class="delete"
                                    onclick="hapusLayanan('Potong Rambut')">

                                    Hapus

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>
                            4
                        </td>

                        <td>

                            <div class="service-name">
                                Hair Coloring
                            </div>

                        </td>

                        <td>

                            <div class="price">
                                Rp250.000
                            </div>

                        </td>

                        <td>

                            <div class="duration">
                                120 menit
                            </div>

                        </td>

                        <td>
                            Pewarnaan rambut sesuai pilihan pelanggan.
                        </td>

                        <td>

                            <div class="action">

                                <button
                                    class="edit"
                                    onclick="editLayanan('Hair Coloring','250000','120','Pewarnaan rambut sesuai pilihan pelanggan.')">

                                    Edit

                                </button>


                                <button
                                    class="delete"
                                    onclick="hapusLayanan('Hair Coloring')">

                                    Hapus

                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</section>

</main>

</div>


<!-- MODAL -->

<div
    class="modal"
    id="modal">

    <div class="modal-box">

        <div class="modal-title">
            <span id="modalTitle">
                Tambah Layanan
            </span>
        </div>


        <div class="form-group">

            <label>
                Nama Layanan
            </label>

            <input
                type="text"
                id="nama"
                placeholder="Contoh: Creambath">

        </div>


        <div class="form-group">

            <label>
                Harga
            </label>

            <input
                type="number"
                id="harga"
                placeholder="Contoh: 100000">

        </div>


        <div class="form-group">

            <label>
                Durasi (menit)
            </label>

            <input
                type="number"
                id="durasi"
                placeholder="Contoh: 60">

        </div>


        <div class="form-group">

            <label>
                Keterangan
            </label>

            <textarea
                id="keterangan"
                placeholder="Masukkan keterangan layanan"></textarea>

        </div>


        <div class="modal-actions">

            <button
                class="btn btn-secondary"
                onclick="tutupModal()">

                Batal

            </button>


            <button
                class="btn btn-primary"
                onclick="simpanLayanan()">

                Simpan

            </button>

        </div>

    </div>

</div>


<script>

function bukaModalTambah(){

    document.getElementById("modalTitle").innerText =
        "Tambah Layanan";

    document.getElementById("nama").value = "";

    document.getElementById("harga").value = "";

    document.getElementById("durasi").value = "";

    document.getElementById("keterangan").value = "";

    document.getElementById("modal").style.display =
        "flex";

}


function tutupModal(){

    document.getElementById("modal").style.display =
        "none";

}


function editLayanan(
    nama,
    harga,
    durasi,
    keterangan
){

    document.getElementById("modalTitle").innerText =
        "Edit Layanan";

    document.getElementById("nama").value =
        nama;

    document.getElementById("harga").value =
        harga;

    document.getElementById("durasi").value =
        durasi;

    document.getElementById("keterangan").value =
        keterangan;

    document.getElementById("modal").style.display =
        "flex";

}


function simpanLayanan(){

    let nama =
        document.getElementById("nama").value;

    if(nama === ""){

        alert(
            "Nama layanan belum diisi."
        );

        return;

    }

    alert(
        "Data layanan berhasil disimpan."
    );

    tutupModal();

}


function hapusLayanan(nama){

    let yakin =
        confirm(
            "Hapus layanan " +
            nama +
            "?"
        );

    if(yakin){

        alert(
            "Layanan " +
            nama +
            " berhasil dihapus."
        );

    }

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
