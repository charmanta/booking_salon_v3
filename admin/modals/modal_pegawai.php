<?php
/* =====================================================================
   RESERVIN — MODAL PEGAWAI (admin/modals/modal_pegawai.php)
   Pop-up formulir tambah dan edit data akun serta data diri pegawai.
   ===================================================================== */
?>
<!-- ===== POP-UP TAMBAH / EDIT PEGAWAI ===== -->
<div class="ad-modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

    <div class="ad-modal-box">

        <div class="ad-modal-head">
            <h2 id="modalTitle">Tambah Pegawai</h2>
            <button type="button" class="ad-x" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>
        </div>

        <div class="ad-info-akun">
            <?= ikon('kunci') ?>
            <span>Data akun dan data diri pegawai hanya dapat dilihat oleh admin. Pegawai memakai username dan password ini untuk masuk ke akunnya.</span>
        </div>

        <div class="ad-field">
            <label for="f_nama">Nama Lengkap</label>
            <input type="text" id="f_nama" placeholder="Masukkan nama lengkap" autocomplete="off">
        </div>

        <h3 class="ad-sub" style="margin-top:6px">Akun Login</h3>

        <div class="ad-field-2">
            <div class="ad-field">
                <label for="f_username">Username</label>
                <input type="text" id="f_username" placeholder="Contoh: dewi.lestari" autocomplete="off">
            </div>

            <div class="ad-field">
                <label for="f_password">Password</label>
                <div class="ad-pass">
                    <input type="password" id="f_password" placeholder="Minimal 6 karakter" autocomplete="new-password">
                    <button type="button" id="f_lihat" aria-label="Tampilkan password"><?= ikon('mata') ?></button>
                </div>
                <small class="bantu" id="f_bantuPass" hidden>Kosongkan jika tidak ingin mengubah password.</small>
            </div>
        </div>

        <h3 class="ad-sub">Data Pegawai</h3>

        <div class="ad-field-2">
            <div class="ad-field">
                <label for="f_nik">NIK</label>
                <input type="text" id="f_nik" inputmode="numeric" maxlength="16" placeholder="16 digit NIK" autocomplete="off">
            </div>

            <div class="ad-field">
                <label for="f_keahlian">Specialist</label>
                <input type="text" id="f_keahlian" placeholder="Contoh: Hair Stylist" autocomplete="off">
            </div>
        </div>

        <div class="ad-field-2">
            <div class="ad-field">
                <label for="f_hp">Nomor HP</label>
                <input type="tel" id="f_hp" inputmode="numeric" placeholder="Contoh: 081234567890" autocomplete="off">
            </div>

            <div class="ad-field">
                <label for="f_email">Email</label>
                <input type="email" id="f_email" placeholder="nama@email.com" autocomplete="off">
            </div>
        </div>

        <div class="ad-field">
            <label for="f_alamat">Alamat</label>
            <textarea id="f_alamat" placeholder="Masukkan alamat lengkap"></textarea>
            <small class="bantu">Jadwal masuk diatur di halaman Jadwal.</small>
        </div>

        <div class="ad-modal-aksi">
            <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
            <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
        </div>

    </div>

</div>

