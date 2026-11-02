<?php
/* =====================================================================
   RESERVIN — MODAL GANTI JADWAL (customer/modals/modal_ganti_jadwal.php)
   Pop-up kalender dan pilihan jam untuk mengubah jadwal reservasi.
   ===================================================================== */
?>
<!-- MODAL GANTI JADWAL (RIWAYAT) -->
<div class="modal" id="scheduleModal">
    <div class="modal-box">
        <div class="modal-title">Pilih tanggal dan jam</div>
        <div class="owner-info" id="infoModal"></div>

        <div class="week">
            <div>Min</div>
            <div>Sen</div>
            <div>Sel</div>
            <div>Rab</div>
            <div>Kam</div>
            <div>Jum</div>
            <div>Sab</div>
        </div>

        <div class="calendar" id="calendar"></div>

        <div class="time-title">Pilih Jam</div>
        <div class="times" id="times">
            <div>Pilih tanggal terlebih dahulu.</div>
        </div>

        <button type="button" class="modal-btn" onclick="simpanJadwal()">Pilih jadwal ini</button>
        <button type="button" class="cancel-btn" onclick="tutupJadwal()">Batal</button>
    </div>
</div>

