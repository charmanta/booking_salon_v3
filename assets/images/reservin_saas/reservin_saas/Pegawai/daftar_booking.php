<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Booking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/pegawai.css">
</head>
<body class="page-pegawai p-pegawai-daftar_booking">

    <header class="topnav">
        <a class="tn-brand" href="dashboard.php"><b>RESERVIN</b><small>Staff</small></a>
        <nav class="tn-menu">
            <a href="dashboard.php">Dashboard</a>
            <a href="booking.php" class="active">Daftar Booking</a>
            <a href="profil.php">Profil</a>
        </nav>
        <div class="tn-right">
            <div class="tn-user"><span class="av">SA</span><div><b>Siti Amelia</b><small>Pegawai</small></div></div>
            <a class="tn-out" href="../login.php">Logout</a>
        </div>
    </header>


<div class="app">

<!-- SIDEBAR -->


<!-- MAIN -->
<main class="main">

    <!-- HEADER -->
    

    <!-- CONTENT -->
    <section class="content">

        <div class="page-title">

            <h1>
                Daftar Booking
            </h1>

            <p>
                Kelola booking pelanggan yang masuk.
            </p>

        </div>

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

    <footer class="pg-foot">© Reservin · Ruang Kerja Pegawai</footer>
</body>
</html>
