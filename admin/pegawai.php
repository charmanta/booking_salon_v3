<?php
/* =====================================================================
   RESERVIN — DATA PEGAWAI ADMIN (admin/pegawai.php)
   Halaman daftar dan manajemen data pegawai (staf salon, akun login,
   spesialisasi, status kehadiran hari ini).
   ===================================================================== */

$page_title   = 'Pegawai Salon';
$current_page = 'pegawai.php';

require_once __DIR__ . '/includes/init.php';

/* nomor hari: 1 = Senin ... 7 = Minggu */
$namaHari = [1 => 'Sen', 2 => 'Sel', 3 => 'Rab', 4 => 'Kam', 5 => 'Jum', 6 => 'Sab', 7 => 'Min'];
$hariIni  = (int)date('N');

/*
 * [0 nama, 1 no hp, 2 jabatan, 3 specialist, 4 hari kerja, 5 jam masuk, 6 jam pulang,
 *  7 status kehadiran, 8 waktu dicatat, 9 username, 10 NIK, 11 email, 12 alamat]
 */
$pegawai = [
    ['Dewi Lestari',   '081234567890', 'Pegawai', 'Hair Stylist',    [1, 2, 3, 4, 5, 6], '09:00', '17:00', 'masuk',       '08:42', 'dewi',  '3372010101900001', 'dewi@email.com',  'Jl. Melati No. 12, Surakarta'],
    ['Andi Pratama',   '082345678901', 'Pegawai', 'Barber',          [1, 2, 3, 4, 5, 6], '10:00', '18:00', 'masuk',       '09:51', 'andi',  '3372010202910002', 'andi@email.com',  'Jl. Kenanga No. 5, Surakarta'],
    ['Maya Putri',     '083456789012', 'Pegawai', 'Facial & Beauty', [2, 3, 4, 5, 6, 7], '09:00', '17:00', 'masuk',       '08:55', 'maya',  '3372010303920003', 'maya@email.com',  'Jl. Mawar No. 8, Surakarta'],
    ['Rani Salsabila', '084567890123', 'Pegawai', 'Hair Coloring',   [1, 3, 5, 6],       '11:00', '20:00', 'tidak_masuk', '07:30', 'rani',  '3372010404930004', 'rani@email.com',  'Jl. Dahlia No. 20, Surakarta'],
];

$jmlMasuk = count(array_filter($pegawai, function ($p) { return $p[7] === 'masuk'; }));

// Muat kerangka header admin
require_once __DIR__ . '/includes/header.php';
?>

<!-- KEPALA HALAMAN & TOMBOL TAMBAH -->
<div class="ad-sapa-baris">
    <section class="ad-sapa">
        <h1>Data Pegawai</h1>
        <p>Kelola data pegawai yang bekerja di salon Anda.</p>
    </section>

    <button type="button" class="ad-btn utama" id="btnTambah">
        <?= ikon('plus') ?> Tambah Pegawai
    </button>
</div>

<!-- DAFTAR PEGAWAI -->
<section class="ad-kartu">
    <div class="ad-kartu-head">
        <h2>Daftar Pegawai</h2>
        <span class="ad-jumlah" id="ringkas"><?= $jmlMasuk ?> masuk · <?= count($pegawai) - $jmlMasuk ?> tidak masuk</span>
    </div>

    <p class="ad-tip">Status masuk atau tidak masuk diisi oleh pegawai sendiri. Admin hanya dapat melihatnya. Jadwal kerja diatur di halaman Jadwal.</p>

    <div class="ad-tabel-box">
        <table class="ad-tabel">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>No. HP</th>
                    <th>Jabatan</th>
                    <th>Specialist</th>
                    <th>Jadwal Masuk</th>
                    <th>Kehadiran Hari Ini</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pegawai as $i => $p): ?>
                    <?php
                        $kerjaHariIni = in_array($hariIni, $p[4], true);
                        $hadir        = ($p[7] === 'masuk');
                    ?>
                    <tr class="baris"
                        data-nama="<?= e($p[0]) ?>"
                        data-hp="<?= e($p[1]) ?>"
                        data-keahlian="<?= e($p[3]) ?>"
                        data-username="<?= e($p[9]) ?>"
                        data-nik="<?= e($p[10]) ?>"
                        data-email="<?= e($p[11]) ?>"
                        data-alamat="<?= e($p[12]) ?>">
                        <td><?= $i + 1 ?></td>
                        <td class="nama"><?= e($p[0]) ?></td>
                        <td class="nowrap"><?= e($p[1]) ?></td>
                        <td><?= e($p[2]) ?></td>
                        <td class="nowrap"><?= e($p[3]) ?></td>
                        <td class="ad-jadwal">
                            <b><?= e(ringkasHari($p[4], $namaHari)) ?></b>
                            <small class="<?= $kerjaHariIni ? 'hari-ini' : '' ?>">
                                <?= e($p[5]) ?> – <?= e($p[6]) ?><?= $kerjaHariIni ? ' · jadwal hari ini' : '' ?>
                            </small>
                        </td>
                        <td>
                            <div class="ad-hadir<?= $hadir ? '' : ' off' ?>">
                                <span class="ad-hadir-teks"><?= $hadir ? 'Masuk' : 'Tidak masuk' ?></span>
                                <?php if (!empty($p[8])): ?>
                                    <small>Dicatat pukul <?= e($p[8]) ?></small>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="ad-pil <?= $hadir ? 'ok' : 'off' ?>"><?= $hadir ? 'Aktif' : 'Nonaktif' ?></span>
                        </td>
                        <td>
                            <div class="ad-aksi-sel">
                                <button type="button" class="ad-mini btn-edit"><?= ikon('edit') ?> Edit</button>
                                <button type="button" class="ad-mini bahaya btn-hapus"><?= ikon('hapus') ?> Hapus</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- MODAL TAMBAH / EDIT PEGAWAI -->
<?php require __DIR__ . '/modals/modal_pegawai.php'; ?>

<?php
// Script khusus halaman pegawai
$extra_js = '
<script>
const $ = function (id) { return document.getElementById(id); };

(function () {
    const modal = $("modal");
    const idField = ["f_nama", "f_username", "f_password", "f_nik", "f_keahlian", "f_hp", "f_email", "f_alamat"];
    let modeEdit = false;

    function aturLihat(tampil) {
        $("f_password").type = tampil ? "text" : "password";
        $("f_lihat").setAttribute("aria-label", tampil ? "Sembunyikan password" : "Tampilkan password");
    }

    function buka(edit, d) {
        modeEdit = edit;
        d = d || {};

        $("modalTitle").textContent = edit ? "Edit Pegawai" : "Tambah Pegawai";
        $("f_nama").value = d.nama || "";
        $("f_username").value = d.username || "";
        $("f_password").value = "";
        $("f_nik").value = d.nik || "";
        $("f_keahlian").value = d.keahlian || "";
        $("f_hp").value = d.hp || "";
        $("f_email").value = d.email || "";
        $("f_alamat").value = d.alamat || "";

        $("f_password").placeholder = edit ? "Isi jika ingin mengubah" : "Minimal 6 karakter";
        $("f_bantuPass").hidden = !edit;
        aturLihat(false);

        modal.classList.add("show");
        $("f_nama").focus();
    }

    function tutup() {
        modal.classList.remove("show");
        idField.forEach(function (id) { $(id).value = ""; });
        aturLihat(false);
    }

    $("btnTambah").addEventListener("click", function () { buka(false); });

    document.querySelectorAll("tr.baris").forEach(function (tr) {
        tr.querySelector(".btn-edit").addEventListener("click", function () {
            buka(true, {
                nama: tr.dataset.nama,
                username: tr.dataset.username,
                nik: tr.dataset.nik,
                keahlian: tr.dataset.keahlian,
                hp: tr.dataset.hp,
                email: tr.dataset.email,
                alamat: tr.dataset.alamat
            });
        });

        tr.querySelector(".btn-hapus").addEventListener("click", function () {
            if (confirm("Apakah Anda yakin ingin menghapus pegawai " + tr.dataset.nama + "?")) {
                alert("Data " + tr.dataset.nama + " berhasil dihapus.");
            }
        });
    });

    $("f_lihat").addEventListener("click", function () {
        aturLihat($("f_password").type === "password");
    });

    ["f_nik", "f_hp"].forEach(function (id) {
        $(id).addEventListener("input", function () {
            this.value = this.value.replace(/\\D/g, "");
        });
    });

    $("f_username").addEventListener("input", function () {
        this.value = this.value.toLowerCase().replace(/\\s/g, "");
    });

    $("btnSimpan").addEventListener("click", function () {
        const nama = $("f_nama").value.trim();
        const user = $("f_username").value.trim();
        const pass = $("f_password").value;
        const nik = $("f_nik").value.trim();
        const ahli = $("f_keahlian").value.trim();
        const hp = $("f_hp").value.trim();
        const email = $("f_email").value.trim();
        const alamat = $("f_alamat").value.trim();

        if (nama === "") { alert("Nama lengkap belum diisi."); $("f_nama").focus(); return; }
        if (user.length < 4) { alert("Username minimal 4 karakter."); $("f_username").focus(); return; }
        if (!/^[a-z0-9._-]+$/.test(user)) { alert("Username hanya boleh huruf, angka, titik, garis bawah, dan strip."); $("f_username").focus(); return; }
        if (!modeEdit && pass === "") { alert("Password belum diisi."); $("f_password").focus(); return; }
        if (pass !== "" && pass.length < 6) { alert("Password minimal 6 karakter."); $("f_password").focus(); return; }
        if (!/^\\d{16}$/.test(nik)) { alert("NIK harus 16 digit angka."); $("f_nik").focus(); return; }
        if (ahli === "") { alert("Specialist belum diisi."); $("f_keahlian").focus(); return; }
        if (!/^\\d{9,15}$/.test(hp)) { alert("Nomor HP tidak valid (9 sampai 15 digit)."); $("f_hp").focus(); return; }
        if (!/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(email)) { alert("Format email tidak valid."); $("f_email").focus(); return; }
        if (alamat === "") { alert("Alamat belum diisi."); $("f_alamat").focus(); return; }

        alert(modeEdit
            ? "Data pegawai " + nama + " berhasil disimpan."
            : "Pegawai " + nama + " berhasil ditambahkan.\\nUsername: " + user);
        tutup();
    });

    $("btnBatal").addEventListener("click", tutup);
    $("btnX").addEventListener("click", tutup);

    modal.addEventListener("click", function (e) {
        if (e.target === modal) tutup();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && modal.classList.contains("show")) tutup();
    });
})();
</script>
';

// Muat kerangka footer admin
require_once __DIR__ . '/includes/footer.php';
?>
