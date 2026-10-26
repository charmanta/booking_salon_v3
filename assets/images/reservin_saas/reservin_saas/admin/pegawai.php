<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pegawai Salon</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/staff-base.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="page-admin p-admin-pegawai">


<!-- SIDEBAR -->

<aside class="sidebar">

    <div class="logo">
        RESERVIN
    </div>

    <nav class="menu">

        <a href="dashboard.php">
            🏠 Dashboard
        </a>

        <a href="salon.php">
            🏪 Data Salon
        </a>

        <a href="layanan.php">
            💇 Layanan
        </a>

        <a href="pegawai.php" class="active">
            👤 Pegawai
        </a>

        <a href="laporan.php">
            📊 Laporan
        </a>

        <a href="profil.php">
            ⚙️ Profil
        </a>

        <a href="../login.php">
            🚪 Logout
        </a>

    </nav>

</aside>


<!-- MAIN -->

<main class="main">

    <!-- TOPBAR -->

    <header class="topbar">

        <div class="topbar-title">
            Pegawai
        </div>

        <div class="profile">

            <div class="profile-icon">
                👤
            </div>

            <div>
                <b>Siti Amelia</b>
                <br>
                <small>Pemilik Salon</small>
            </div>

        </div>

    </header>


    <!-- CONTENT -->

    <section class="content">

        <div class="page-title">

            <h1>
                Data Pegawai
            </h1>

            <p>
                Kelola data pegawai yang bekerja di salon Anda.
            </p>

        </div>


        <div class="page-header">

            <b>
                Daftar Pegawai
            </b>

            <button
                class="btn btn-primary"
                onclick="bukaTambah()">

                + Tambah Pegawai

            </button>

        </div>


        <!-- TABLE -->

        <div class="card">

            <div class="table-wrapper">

                <table>

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Nama Pegawai</th>

                            <th>No. HP</th>

                            <th>Jabatan</th>

                            <th>Keahlian</th>

                            <th>Status</th>

                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        <tr>

                            <td>1</td>

                            <td>
                                <div class="nama">
                                    Dewi Lestari
                                </div>
                            </td>

                            <td>
                                081234567890
                            </td>

                            <td>
                                Pegawai
                            </td>

                            <td>
                                Hair Stylist
                            </td>

                            <td>
                                <span class="status aktif">
                                    Aktif
                                </span>
                            </td>

                            <td>

                                <div class="action">

                                    <button
                                        class="btn-edit"
                                        onclick="editPegawai(
                                        'Dewi Lestari',
                                        '081234567890',
                                        'Pegawai',
                                        'Hair Stylist',
                                        'Aktif'
                                        )">

                                        Edit

                                    </button>

                                    <button
                                        class="btn-delete"
                                        onclick="hapusPegawai('Dewi Lestari')">

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>


                        <tr>

                            <td>2</td>

                            <td>
                                <div class="nama">
                                    Andi Pratama
                                </div>
                            </td>

                            <td>
                                082345678901
                            </td>

                            <td>
                                Pegawai
                            </td>

                            <td>
                                Barber
                            </td>

                            <td>
                                <span class="status aktif">
                                    Aktif
                                </span>
                            </td>

                            <td>

                                <div class="action">

                                    <button
                                        class="btn-edit"
                                        onclick="editPegawai(
                                        'Andi Pratama',
                                        '082345678901',
                                        'Pegawai',
                                        'Barber',
                                        'Aktif'
                                        )">

                                        Edit

                                    </button>

                                    <button
                                        class="btn-delete"
                                        onclick="hapusPegawai('Andi Pratama')">

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>


                        <tr>

                            <td>3</td>

                            <td>
                                <div class="nama">
                                    Maya Putri
                                </div>
                            </td>

                            <td>
                                083456789012
                            </td>

                            <td>
                                Pegawai
                            </td>

                            <td>
                                Facial & Beauty
                            </td>

                            <td>
                                <span class="status aktif">
                                    Aktif
                                </span>
                            </td>

                            <td>

                                <div class="action">

                                    <button
                                        class="btn-edit"
                                        onclick="editPegawai(
                                        'Maya Putri',
                                        '083456789012',
                                        'Pegawai',
                                        'Facial & Beauty',
                                        'Aktif'
                                        )">

                                        Edit

                                    </button>

                                    <button
                                        class="btn-delete"
                                        onclick="hapusPegawai('Maya Putri')">

                                        Hapus

                                    </button>

                                </div>

                            </td>

                        </tr>


                        <tr>

                            <td>4</td>

                            <td>
                                <div class="nama">
                                    Rani Salsabila
                                </div>
                            </td>

                            <td>
                                084567890123
                            </td>

                            <td>
                                Pegawai
                            </td>

                            <td>
                                Hair Coloring
                            </td>

                            <td>
                                <span class="status nonaktif">
                                    Nonaktif
                                </span>
                            </td>

                            <td>

                                <div class="action">

                                    <button
                                        class="btn-edit"
                                        onclick="editPegawai(
                                        'Rani Salsabila',
                                        '084567890123',
                                        'Pegawai',
                                        'Hair Coloring',
                                        'Nonaktif'
                                        )">

                                        Edit

                                    </button>

                                    <button
                                        class="btn-delete"
                                        onclick="hapusPegawai('Rani Salsabila')">

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


<!-- MODAL TAMBAH / EDIT -->

<div
    class="modal"
    id="modal">

    <div class="modal-box">

        <div class="modal-title">

            <span id="modalTitle">
                Tambah Pegawai
            </span>

        </div>


        <div class="form-group">

            <label>
                Nama Pegawai
            </label>

            <input
                type="text"
                id="nama"
                placeholder="Masukkan nama pegawai">

        </div>


        <div class="form-group">

            <label>
                No. HP
            </label>

            <input
                type="text"
                id="hp"
                placeholder="Contoh: 081234567890">

        </div>


        <div class="form-group">

            <label>
                Jabatan
            </label>

            <select id="jabatan">

                <option value="">
                    Pilih jabatan
                </option>

                <option value="Pegawai">
                    Pegawai
                </option>

            </select>

        </div>


        <div class="form-group">

            <label>
                Keahlian
            </label>

            <input
                type="text"
                id="keahlian"
                placeholder="Contoh: Hair Stylist">

        </div>


        <div class="form-group">

            <label>
                Status
            </label>

            <select id="status">

                <option value="Aktif">
                    Aktif
                </option>

                <option value="Nonaktif">
                    Nonaktif
                </option>

            </select>

        </div>


        <div class="modal-actions">

            <button
                class="btn-cancel"
                onclick="tutupModal()">

                Batal

            </button>

            <button
                class="btn btn-primary"
                onclick="simpanPegawai()">

                Simpan

            </button>

        </div>

    </div>

</div>


<script>

function bukaTambah(){

    document.getElementById("modalTitle").innerText =
        "Tambah Pegawai";

    document.getElementById("nama").value = "";
    document.getElementById("hp").value = "";
    document.getElementById("jabatan").value = "";
    document.getElementById("keahlian").value = "";
    document.getElementById("status").value = "Aktif";

    document.getElementById("modal").style.display =
        "flex";
}


function editPegawai(
    nama,
    hp,
    jabatan,
    keahlian,
    status
){

    document.getElementById("modalTitle").innerText =
        "Edit Pegawai";

    document.getElementById("nama").value =
        nama;

    document.getElementById("hp").value =
        hp;

    document.getElementById("jabatan").value =
        jabatan;

    document.getElementById("keahlian").value =
        keahlian;

    document.getElementById("status").value =
        status;

    document.getElementById("modal").style.display =
        "flex";
}


function tutupModal(){

    document.getElementById("modal").style.display =
        "none";
}


function simpanPegawai(){

    let nama =
        document.getElementById("nama").value.trim();

    let hp =
        document.getElementById("hp").value.trim();

    let jabatan =
        document.getElementById("jabatan").value;

    let keahlian =
        document.getElementById("keahlian").value.trim();


    if(nama === ""){

        alert("Nama pegawai belum diisi.");

        return;
    }


    if(hp === ""){

        alert("No. HP belum diisi.");

        return;
    }


    if(jabatan === ""){

        alert("Jabatan belum dipilih.");

        return;
    }


    if(keahlian === ""){

        alert("Keahlian belum diisi.");

        return;
    }


    alert(
        "Data pegawai berhasil disimpan."
    );

    tutupModal();
}


function hapusPegawai(nama){

    let yakin = confirm(
        "Apakah Anda yakin ingin menghapus pegawai " +
        nama +
        "?"
    );


    if(yakin){

        alert(
            "Data " +
            nama +
            " berhasil dihapus."
        );

    }

}

</script>

    <footer class="admin-foot">© Reservin · Panel Pemilik Salon</footer>
</body>
</html>
