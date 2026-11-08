<?php
/* =====================================================================
   RESERVIN — MODAL LAYANAN (admin/modals/modal_layanan.php)
   Pop-up formulir tambah dan edit data layanan salon.
   Untuk layanan pewarnaan (nama mengandung "color"/"warna") akan muncul
   panel "Kelola Warna" di bagian bawah formulir.
   ===================================================================== */
?>
<!-- ===== MODAL TAMBAH / EDIT LAYANAN ===== -->
<div class="ad-modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

    <div class="ad-modal-box">

        <div class="ad-modal-head">
            <h2 id="modalTitle">Tambah Layanan</h2>
            <button type="button" class="ad-x" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>
        </div>

        <div class="ad-field">
            <label for="nama">Nama Layanan</label>
            <input type="text" id="nama" placeholder="Contoh: Creambath">
        </div>

        <div class="ad-field-2">
            <div class="ad-field">
                <label for="harga">Harga (Rp)</label>
                <input type="number" id="harga" min="0" placeholder="Contoh: 100000">
            </div>

            <div class="ad-field">
                <label for="durasi">Durasi (menit)</label>
                <input type="number" id="durasi" min="0" placeholder="Contoh: 60">
            </div>
        </div>

        <div class="ad-field">
            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" placeholder="Masukkan keterangan layanan"></textarea>
        </div>

        <!-- ===== KELOLA WARNA (hanya untuk layanan pewarnaan) ===== -->
        <div class="ad-warna" id="panelWarna">
            <div class="ad-warna-head">
                <h3>Kelola Warna</h3>
                <p>Warna yang bisa dipilih customer saat booking layanan ini.</p>
            </div>

            <div class="ad-warna-list" id="listWarna"></div>

            <div class="ad-warna-tambah">
                <div class="ad-field">
                    <label for="warnaNama">Tambah warna baru</label>
                    <input type="text" id="warnaNama" maxlength="40" placeholder="Contoh: Rose Gold">
                </div>
                <div class="ad-field">
                    <label for="warnaHex">Contoh warna</label>
                    <input type="color" id="warnaHex" value="#b76e79">
                </div>
                <button type="button" class="ad-btn kedua" id="btnTambahWarna">+ Tambah</button>
            </div>

            <p class="ad-warna-catatan">Warna yang dinonaktifkan tidak akan muncul di halaman booking customer. Perubahan tersimpan saat kamu menekan Simpan.</p>
        </div>

        <div class="ad-modal-aksi">
            <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
            <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
        </div>

    </div>

</div>