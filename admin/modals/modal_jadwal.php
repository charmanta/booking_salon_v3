<?php
/* =====================================================================
   RESERVIN — MODAL JADWAL (admin/modals/modal_jadwal.php)
   Pop-up pengaturan jadwal kerja mingguan pegawai (hari & jam kerja).
   ===================================================================== */
?>
<!-- ===== POP-UP ATUR / UBAH JADWAL ===== -->
<div class="ad-modal" id="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">

    <div class="ad-modal-box">

        <div class="ad-modal-head">
            <h2 id="modalTitle">Atur Jadwal</h2>
            <button type="button" class="ad-x" id="btnX" aria-label="Tutup"><?= ikon('tutup') ?></button>
        </div>

        <div class="ad-field">
            <label for="j_pegawai">Pegawai</label>
            <select id="j_pegawai">
                <option value="">Pilih pegawai</option>
                <?php if (!empty($pegawai)): ?>
                    <?php foreach ($pegawai as $i => $p): ?>
                        <option value="<?= $i ?>"><?= e($p[0]) ?> · <?= e($p[1]) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="ad-field">
            <span class="lbl" id="lblHari">Hari kerja</span>
            <div class="ad-hari" role="group" aria-labelledby="lblHari">
                <?php if (!empty($namaHari)): ?>
                    <?php foreach ($namaHari as $no => $h): ?>
                        <label>
                            <input type="checkbox" name="hari" value="<?= $no ?>">
                            <span><?= e($h) ?></span>
                        </label>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="ad-field-2">
            <div class="ad-field">
                <label for="jamMasuk">Jam masuk</label>
                <input type="time" id="jamMasuk" value="09:00">
            </div>

            <div class="ad-field">
                <label for="jamPulang">Jam pulang</label>
                <input type="time" id="jamPulang" value="17:00">
            </div>
        </div>

        <small class="bantu" style="color:var(--muted);font-size:12.5px">Jadwal berlaku setiap pekan sampai diubah lagi.</small>

        <div class="ad-modal-aksi">
            <button type="button" class="ad-btn kedua" id="btnBatal">Batal</button>
            <button type="button" class="ad-btn utama" id="btnSimpan">Simpan</button>
        </div>

    </div>

</div>

