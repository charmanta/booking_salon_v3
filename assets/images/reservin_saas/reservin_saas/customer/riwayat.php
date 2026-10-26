<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/customer.css">
</head>
<body class="page-customer p-riwayat">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php">Beranda</a>
            <a href="booking.php">Reservasi</a>
            <a href="riwayat.php" class="active">Riwayat</a>
            <a href="https://gemini.google.com/" target="_blank">Tanya AI</a>
            <a href="../login.php">Keluar</a>
        </nav>
        <a class="brand" href="dashboard.php" aria-label="Reservin"><span class="brand-name">RESERVIN</span><span class="brand-sub"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" aria-hidden="true"><circle cx="6" cy="18" r="3"/><circle cx="18" cy="18" r="3"/><path d="M8 16 19 3M16 16 5 3"/></svg> Salon Booking</span></a>
        <div class="header-right">
            <a href="pilih_salon.php" class="btn btn-cta">Booking Sekarang</a>
        </div>
    </header>

    <!-- ===== BANNER (taruh fotomu di assets/img/banner.jpg) ===== -->
    <div class="banner" role="img" aria-label="Salon"></div>



<div class="app">

    <!-- HEADER -->

    


    <!-- CONTENT -->

    <div class="content">
        <div class="title"><h2>Riwayat Booking</h2><p>Luna Salon</p></div>

        <!-- BOOKING 1 -->

        <div class="booking-card">

            <div class="booking-top">

                <div class="kode">
                    RSV-001
                </div>

                <div class="status">
                    Menunggu
                </div>

            </div>


            <div class="nama">
                Rina (Saya)
            </div>


            <div class="detail">
                Creambath · Pegawai ·
                17 Okt, 18.00
            </div>


            <button
                class="schedule-btn"
                onclick="bukaJadwal('RSV-001')">

                Ganti Jadwal

            </button>


            <div class="total">
                Total Rp 100.000 ·
                DP Rp 30.000
            </div>

        </div>


        <!-- BOOKING 2 -->

        <div class="booking-card">

            <div class="booking-top">

                <div class="kode">
                    RSV-002
                </div>

                <div class="status confirmed">
                    Dikonfirmasi
                </div>

            </div>


            <div class="nama">
                Rina (Saya)
            </div>


            <div class="detail">
                Potong Rambut · Owner ·
                19 Okt, 17.40
            </div>


            <button
                class="schedule-btn"
                onclick="bukaJadwal('RSV-002')">

                Ganti Jadwal

            </button>


            <div class="nama"
                 style="font-size:17px">

                Dewi (Teman)

            </div>


            <div class="detail">
                Facial · Pegawai ·
                19 Okt, 18.40
            </div>


            <button
                class="schedule-btn"
                onclick="bukaJadwal('RSV-002')">

                Ganti Jadwal

            </button>


            <div class="total">
                Total Rp 245.000 ·
                DP Rp 73.500
            </div>

        </div>


        <div class="note">

            Ganti jadwal hanya bisa sampai
            30 menit sebelum jadwal semula.

        </div>

    </div>


    <!-- MENU BAWAH -->

    <div class="bottom">

        <a href="dashboard.php">

            <span class="icon">
                🏠
            </span>

            Beranda

        </a>


        <a href="booking.php">

            <span class="icon">
                📅
            </span>

            Reservasi

        </a>


        <a
            href="riwayat.php"
            class="active">

            <span class="icon">
                📋
            </span>

            Riwayat

        </a>


        <a
            href="https://gemini.google.com/"
            target="_blank">

            <span class="icon">
                💬
            </span>

            Tanya AI

        </a>

    </div>

</div>


<!-- MODAL GANTI JADWAL -->

<div
    class="modal"
    id="scheduleModal">

    <div class="modal-box">

        <div class="modal-title">
            Pilih tanggal dan jam
        </div>


        <div class="owner-info">

            <b>Dilayani owner:</b><br>

            Jadwal mengikuti
            jadwal owner.

        </div>


        <!-- HARI -->

        <div class="week">

            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>

        </div>


        <!-- KALENDER OTOMATIS -->

        <div
            class="calendar"
            id="calendar">

        </div>


        <!-- JAM -->

        <div class="time-title">

            Pilih Jam

        </div>


        <div
            class="times"
            id="times">

            <div>
                Pilih tanggal terlebih dahulu.
            </div>

        </div>


        <button
            class="modal-btn"
            onclick="simpanJadwal()">

            Pilih jadwal ini

        </button>


        <button
            class="cancel-btn"
            onclick="tutupJadwal()">

            Batal

        </button>

    </div>

</div>


<script>

let bookingDipilih = "";

let tanggalDipilih = "";

let jamDipilih = "";


/* BUKA MODAL */

function bukaJadwal(id) {

    bookingDipilih = id;

    tanggalDipilih = "";

    jamDipilih = "";

    document
        .getElementById("scheduleModal")
        .style.display = "flex";

    buatKalender();

    document
        .getElementById("times")
        .innerHTML =
        "<div>Pilih tanggal terlebih dahulu.</div>";

}


/* TUTUP MODAL */

function tutupJadwal() {

    document
        .getElementById("scheduleModal")
        .style.display = "none";

}


/* KALENDER OTOMATIS */

function buatKalender() {

    let calendar =
        document.getElementById("calendar");

    calendar.innerHTML = "";


    let sekarang = new Date();


    /*
       Membuat tanggal otomatis
       mulai hari ini sampai
       30 hari ke depan.
    */

    for (let i = 0; i < 30; i++) {

        let tanggal = new Date();

        tanggal.setDate(
            sekarang.getDate() + i
        );


        let tombol =
            document.createElement("div");

        tombol.className = "date";


        tombol.innerHTML =
            tanggal.getDate();


        tombol.onclick = function () {

            document
                .querySelectorAll(".date")
                .forEach(function(item) {

                    item.classList.remove(
                        "active"
                    );

                });


            tombol.classList.add(
                "active"
            );


            tanggalDipilih =
                tanggal.toISOString()
                .split("T")[0];


            buatJam();

        };


        calendar.appendChild(tombol);

    }

}


/* JAM OTOMATIS */

function buatJam() {

    let times =
        document.getElementById("times");

    times.innerHTML = "";


    /*
       Jam salon 09.00 - 20.00
    */

    for (
        let jam = 9;
        jam <= 20;
        jam++
    ) {

        let waktu =
            String(jam)
            .padStart(2, "0")
            + ":00";


        let tombol =
            document.createElement("div");


        tombol.className = "time";

        tombol.innerHTML = waktu;


        tombol.onclick = function () {

            document
                .querySelectorAll(".time")
                .forEach(function(item) {

                    item.classList.remove(
                        "active"
                    );

                });


            tombol.classList.add(
                "active"
            );


            jamDipilih = waktu;

        };


        times.appendChild(tombol);

    }

}


/* SIMPAN JADWAL */

function simpanJadwal() {

    if (tanggalDipilih == "") {

        alert(
            "Silakan pilih tanggal terlebih dahulu."
        );

        return;

    }


    if (jamDipilih == "") {

        alert(
            "Silakan pilih jam terlebih dahulu."
        );

        return;

    }


    alert(
        "Jadwal berhasil dipilih!\n\n"
        + "Booking: "
        + bookingDipilih
        + "\nTanggal: "
        + tanggalDipilih
        + "\nJam: "
        + jamDipilih
    );


    tutupJadwal();

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
