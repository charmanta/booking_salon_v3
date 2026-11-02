<?php
/* =====================================================================
   RESERVIN — MODAL JADWAL BOOKING (customer/modals/modal_jadwal_booking.php)
   Pop-up pemilihan tanggal dan jam saat melakukan reservasi.
   ===================================================================== */
?>
<!-- POP-UP PILIH TANGGAL & JAM (BOOKING) -->
<div class="jm-overlay" id="jmOverlay">
    <div class="jm-box">
        <h3 id="jmJudul">Pilih jadwal</h3>
        <div class="info" id="jmInfo"></div>

        <span class="jm-sub">Pilih Tanggal</span>
        <div class="date-grid" id="jmDates"></div>

        <span class="jm-sub">Pilih Jam</span>
        <div class="time-grid" id="jmTimes">
            <div class="info">Pilih tanggal terlebih dahulu.</div>
        </div>

        <div class="jm-ringkas" id="jmRingkas"></div>

        <div class="jm-actions">
            <button type="button" onclick="tutupJadwal()">Batal</button>
            <button type="button" class="utama" id="jmSimpan" onclick="simpanJadwal()" disabled>Simpan jadwal</button>
        </div>
    </div>
</div>

