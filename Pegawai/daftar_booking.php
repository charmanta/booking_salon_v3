<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/theme.css">
</head>
<body class="page-staff p-pegawai-daftar_booking">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--staff">
        <nav class="site-nav">
            <a href="dashboard.php">Dashboard</a>
            <a href="booking.php" class="active">Daftar Booking</a>
            <a href="profil.php">Profil</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <div class="user-chip"><span class="avatar">SA</span><span><b>Siti Amelia</b><small>Pegawai</small></span></div>
            <a href="../login.php" class="btn btn-cta" style="padding:26px 34px">Logout</a>
        </div>
    </header>



<div class="app">

<!-- SIDEBAR -->


<!-- MAIN -->
<main class="main">
        <!-- FILTER -->
        <div class="filter">

            <div class="filter-group">

                <label>
                    Cari Pelanggan
                </label>

                <input
                    type="text"
                    id="cariPelanggan"
                    placeholder="Masukkan nama pelanggan">

            </div>

            <div class="filter-group">

                <label>
                    Tanggal
                </label>

                <input
                    type="date"
                    id="filterTanggal">

            </div>

            <div class="filter-group">

                <label>
                    Status
                </label>

                <select id="filterStatus">

                    <option value="">
                        Semua Status
                    </option>

                    <option value="Menunggu">
                        Menunggu
                    </option>

                    <option value="Dikonfirmasi">
                        Dikonfirmasi
                    </option>

                    <option value="Selesai">
                        Selesai
                    </option>

                </select>

            </div>

            <button
                class="filter-btn"
                onclick="filterBooking()">

                Cari

            </button>

            <button
                class="reset-btn"
                onclick="resetFilter()">

                Reset

            </button>

        </div>

        <!-- TABLE -->
        <div class="card">

            <div class="card-title">
                Data Booking
            </div>

            <div class="table-wrapper">

                <table id="bookingTable">

                    <thead>

                        <tr>
                            <th>Kode</th>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>

                            <td>RSV-001</td>

                            <td>Rina</td>

                            <td>Creambath</td>

                            <td>17 Oktober 2026</td>

                            <td>10:00</td>

                            <td>
                                <span class="status waiting">
                                    Menunggu
                                </span>
                            </td>

                            <td>
                                <a
                                    href="detail_booking.php"
                                    class="btn">
                                    Detail
                                </a>
                            </td>

                        </tr>

                        <tr>

                            <td>RSV-002</td>

                            <td>Dewi</td>

                            <td>Potong Rambut</td>

                            <td>17 Oktober 2026</td>

                            <td>13:00</td>

                            <td>
                                <span class="status confirmed">
                                    Dikonfirmasi
                                </span>
                            </td>

                            <td>
                                <a
                                    href="detail_booking.php"
                                    class="btn">
                                    Detail
                                </a>
                            </td>

                        </tr>

                        <tr>

                            <td>RSV-003</td>

                            <td>Maya</td>

                            <td>Hair Spa</td>

                            <td>18 Oktober 2026</td>

                            <td>15:00</td>

                            <td>
                                <span class="status done">
                                    Selesai
                                </span>
                            </td>

                            <td>
                                <a
                                    href="detail_booking.php"
                                    class="btn">
                                    Detail
                                </a>
                            </td>

                        </tr>

                        <tr>

                            <td>RSV-004</td>

                            <td>Andi</td>

                            <td>Hair Cut</td>

                            <td>18 Oktober 2026</td>

                            <td>16:00</td>

                            <td>
                                <span class="status waiting">
                                    Menunggu
                                </span>
                            </td>

                            <td>
                                <a
                                    href="detail_booking.php"
                                    class="btn">
                                    Detail
                                </a>
                            </td>

                        </tr>

                    </tbody>

                </table>

                <div
                    class="empty"
                    id="dataKosong">

                    Data booking tidak ditemukan.

                </div>

            </div>

        </div>

    </section>

</main>

</div>

<script>

function filterBooking(){

    let nama =
        document
        .getElementById("cariPelanggan")
        .value
        .toLowerCase()
        .trim();

    let tanggal =
        document
        .getElementById("filterTanggal")
        .value;

    let status =
        document
        .getElementById("filterStatus")
        .value;

    let rows =
        document.querySelectorAll(
            "#bookingTable tbody tr"
        );

    let jumlahTampil = 0;

    rows.forEach(function(row){

        let namaPelanggan =
            row.cells[1]
            .textContent
            .toLowerCase()
            .trim();

        let tanggalBooking =
            row.cells[3]
            .textContent
            .trim();

        let statusBooking =
            row.cells[5]
            .textContent
            .trim();

        let cocokNama =
            nama === "" ||
            namaPelanggan.includes(nama);

        let cocokTanggal = true;

        if(tanggal !== ""){

            let bagianTanggal =
                tanggal.split("-");

            let tanggalFormat =
                parseInt(bagianTanggal[2])
                + " " +
                namaBulan(
                    parseInt(bagianTanggal[1])
                ) +
                " " +
                bagianTanggal[0];

            cocokTanggal =
                tanggalBooking === tanggalFormat;
        }

        let cocokStatus =
            status === "" ||
            statusBooking === status;

        if(
            cocokNama &&
            cocokTanggal &&
            cocokStatus
        ){

            row.style.display = "";
            jumlahTampil++;

        }else{

            row.style.display = "none";

        }

    });

    if(jumlahTampil === 0){

        document
        .getElementById("dataKosong")
        .style.display = "block";

    }else{

        document
        .getElementById("dataKosong")
        .style.display = "none";

    }

}


function namaBulan(bulan){

    let nama = [
        "",
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];

    return nama[bulan];

}


function resetFilter(){

    document
    .getElementById("cariPelanggan")
    .value = "";

    document
    .getElementById("filterTanggal")
    .value = "";

    document
    .getElementById("filterStatus")
    .value = "";

    filterBooking();

}


/* BISA LANGSUNG MENCARI SAAT MENGETIK */

document
.getElementById("cariPelanggan")
.addEventListener("input", function(){

    filterBooking();

});

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
