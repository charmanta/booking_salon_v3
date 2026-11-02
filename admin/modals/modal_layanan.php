<?php
/* =====================================================================
   RESERVIN — MODAL LAYANAN (admin/modals/modal_layanan.php)
   Pop-up formulir tambah dan edit data layanan salon.
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

        <div class="ad-modal-aksi">
            <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
            <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
        </div>

    </div>

</div>

