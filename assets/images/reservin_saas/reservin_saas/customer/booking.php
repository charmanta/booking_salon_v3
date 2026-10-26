<?php
$salon = $_GET['salon'] ?? 'Luna Salon';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Great+Vibes&family=Jost:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/customer.css">
</head>
<body class="page-customer p-booking">

    <!-- ===== HEADER ===== -->
    <header class="site-header site-header--customer">
        <nav class="site-nav">
            <a href="dashboard.php">Beranda</a>
            <a href="booking.php" class="active">Reservasi</a>
            <a href="riwayat.php">Riwayat</a>
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

    

    <div class="content">

        <h1>
            Detail Reservasi
        </h1>

        <div class="card">

            <label>
                Salon
            </label>

            <div class="salon">

                <b>
                    <?= htmlspecialchars($salon) ?>
                </b>

                <div class="info">
                    📍 Bandung
                </div>

                <div class="info">
                    🕘 09.00 - 20.00
                </div>

                <div class="info">
                    Fasilitas:
                    WiFi · Parkir · Ruang Tunggu
                </div>

            </div>


            <label>
                Pilih Layanan
            </label>

            <select id="layanan">

                <option value="">
                    Pilih layanan
                </option>

                <option>
                    Creambath - Rp100.000
                </option>

                <option>
                    Potong Rambut - Rp75.000
                </option>

                <option>
                    Facial - Rp120.000
                </option>

                <option>
                    Hair Spa - Rp150.000
                </option>

            </select>


            <label>
                Orang yang Dibooking
            </label>

            <div id="people">

                <div class="person">

                    <b>
                        Saya
                    </b>

                    <div class="info">
                        Pemilik akun
                    </div>

                </div>

            </div>


            <button
                class="add"
                onclick="tambahOrang()">

                + Tambah orang

            </button>


            <label
                style="margin-top:20px">

                Pilih yang Melayani

            </label>


            <div class="option">

                <label>

                    <input
                        type="radio"
                        name="staff"
                        value="Pegawai"
                        checked>

                    Pegawai -
                    harga normal

                </label>

            </div>


            <div class="option">

                <label>

                    <input
                        type="radio"
                        name="staff"
                        value="Owner">

                    Owner -
                    +Rp50.000

                </label>

            </div>


            <label
                style="margin-top:20px">

                Pilih Tanggal

            </label>


            <div
                class="date-grid"
                id="dates">

            </div>


            <div class="time-title">

                Pilih Jam

            </div>


            <div
                class="time-grid"
                id="times">

                <div class="info">

                    Pilih tanggal terlebih dahulu.

                </div>

            </div>


            <button
                class="btn"
                onclick="konfirmasi()">

                Konfirmasi Reservasi

            </button>

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


        <a
            href="booking.php"
            class="active">

            <span class="icon">
                📅
            </span>

            Reservasi

        </a>


        <a href="riwayat.php">

            <span class="icon">
                📋
            </span>

            Riwayat

        </a>


        <a href="https://gemini.google.com/" target="_blank">

            <span class="icon">
                💬
            </span>

            Tanya AI

        </a>

    </div>

</div>


<script>

let tanggal = "";

let jam = "";

const dates =
    document.getElementById("dates");

const times =
    document.getElementById("times");

let today = new Date();


/* TANGGAL OTOMATIS */

for (let i = 0; i < 14; i++) {

    let d = new Date();

    d.setDate(
        today.getDate() + i
    );

    let el =
        document.createElement("div");

    el.className = "date";

    el.innerHTML =
        d.getDate()
        + " "
        + d.toLocaleDateString(
            "id-ID",
            {
                month: "short"
            }
        );

    el.onclick = function () {

        document
            .querySelectorAll(".date")
            .forEach(function (x) {

                x.classList.remove(
                    "active"
                );

            });

        el.classList.add("active");

        tanggal =
            d.toLocaleDateString(
                "id-ID"
            );

        buatJam();

    };

    dates.appendChild(el);
}


/* JAM OTOMATIS */

function buatJam() {

    times.innerHTML = "";

    for (let h = 9; h <= 20; h++) {

        let el =
            document.createElement("div");

        el.className = "time";

        let waktu =
            String(h).padStart(2, "0")
            + ":00";

        el.innerText = waktu;

        el.onclick = function () {

            document
                .querySelectorAll(".time")
                .forEach(function (x) {

                    x.classList.remove(
                        "active"
                    );

                });

            el.classList.add("active");

            jam = waktu;

        };

        times.appendChild(el);

    }

}


/* TAMBAH ORANG */

function tambahOrang() {

    let nama =
        prompt(
            "Masukkan nama orang:"
        );

    if (!nama) {
        return;
    }

    let el =
        document.createElement("div");

    el.className = "person";

    el.innerHTML =
        "<b>"
        + nama
        + "</b>"
        + "<div class='info'>"
        + "Booking bersama"
        + "</div>";

    document
        .getElementById("people")
        .appendChild(el);

}


/* KONFIRMASI */

function konfirmasi() {

    let layanan =
        document.getElementById(
            "layanan"
        ).value;


    if (layanan == "") {

        alert(
            "Pilih layanan terlebih dahulu."
        );

        return;
    }


    if (tanggal == "") {

        alert(
            "Pilih tanggal terlebih dahulu."
        );

        return;
    }


    if (jam == "") {

        alert(
            "Pilih jam terlebih dahulu."
        );

        return;
    }


    alert(
        "Reservasi berhasil dipilih!\n\n"
        + "Salon: "
        + "<?= htmlspecialchars($salon) ?>"
        + "\nTanggal: "
        + tanggal
        + "\nJam: "
        + jam
    );

}

</script>

    <footer class="site-footer site-footer--slim">
        <div class="copy">© RESERVIN · BOOKING SALON</div>
    </footer>

</body>
</html>
